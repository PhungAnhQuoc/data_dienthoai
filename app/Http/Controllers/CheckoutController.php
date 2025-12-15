<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\BankAccount;
use App\Models\Product;
use App\Models\FlashSale;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function processCartItems(array $cart): array
    {
        if (empty($cart)) {
            return ['items' => [], 'subtotal' => 0, 'products' => []];
        }

        // Separate regular products and flash sales
        $productIds = [];
        $flashSaleIds = [];
        
        foreach ($cart as $id => $details) {
            if (strpos($id, 'flash_sale_') === 0) {
                $flashSaleIds[] = $details['flash_sale_id'] ?? str_replace('flash_sale_', '', $id);
            } else {
                $productIds[] = $id;
            }
        }

        $products = !empty($productIds) ? Product::whereIn('id', $productIds)->get()->keyBy('id') : collect();
        $flashSales = !empty($flashSaleIds) ? FlashSale::whereIn('id', $flashSaleIds)->get()->keyBy('id') : collect();
        
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            // Handle Flash Sale Items
            if (strpos($id, 'flash_sale_') === 0) {
                $flashSaleId = $item['flash_sale_id'] ?? str_replace('flash_sale_', '', $id);
                if ($flashSales->has($flashSaleId)) {
                    $flashSale = $flashSales->get($flashSaleId);
                    $quantity = (int) ($item['quantity'] ?? 1);
                    $price = (float) $flashSale->sale_price;
                    
                    $cartItems[] = [
                        'flash_sale_id' => $flashSaleId,
                        'flashSale' => $flashSale,
                        'name' => $flashSale->title,
                        'price' => $price,
                        'quantity' => $quantity,
                        'isFlashSale' => true
                    ];
                    $subtotal += $price * $quantity;
                }
            } else {
                // Handle Regular Product Items
                if ($products->has($id)) {
                    $product = $products->get($id);
                    $quantity = (int) ($item['quantity'] ?? 1);
                    
                    $price = $item['price'] ?? null;
                    if (!$price) {
                        $price = $product->sale_price > 0 ? $product->sale_price : $product->price;
                    }
                    $price = (float) $price;

                    $cartItems[] = [
                        'product_id' => $id,
                        'product' => $product,
                        'name' => $product->name,
                        'price' => $price,
                        'quantity' => $quantity,
                        'isFlashSale' => false
                    ];
                    $subtotal += $price * $quantity;
                }
            }
        }

        return ['items' => $cartItems, 'subtotal' => $subtotal, 'products' => $products];
    }

    public function index()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cartData = $this->processCartItems($cart);
        $shipping = 30000;
        $tax = (int) round($cartData['subtotal'] * 0.1);
        $total = $cartData['subtotal'] + $shipping + $tax;

        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $bankAccounts = BankAccount::where('is_active', true)->get();
        
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('checkout.index', [
            'cartItems' => $cartData['items'],
            'subtotal' => $cartData['subtotal'],
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'user' => $user,
            'paymentMethods' => $paymentMethods,
            'bankAccounts' => $bankAccounts,
            'promotions' => $promotions
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'shipping_name' => 'required|string|max:255',
                'shipping_email' => 'required|email',
                'shipping_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:500',
                'shipping_method' => 'required|in:standard,fast',
                'payment_method_id' => 'required|exists:payment_methods,id',
                'notes' => 'nullable|string|max:500',
            ]);

            $user = Auth::user();
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
            }

            $cartData = $this->processCartItems($cart);
            // Lấy phí vận chuyển từ form dựa trên phương thức được chọn
            $shipping = $validated['shipping_method'] === 'fast' ? 50000 : 30000;
            $tax = (int) round($cartData['subtotal'] * 0.1);
            $discount = 0;
            $promotionCode = null;

            // Validate promotion code if provided
            if ($promoCode = trim(strtoupper($request->input('promotion_code', '')))) {
                $promotion = Promotion::where('code', $promoCode)
                    ->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if ($promotion) {
                    $discount = $promotion->calculateDiscount($cartData['subtotal']);
                    $promotionCode = $promoCode;
                }
            }

            $total = $cartData['subtotal'] + $shipping + $tax - $discount;

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $total,
                'shipping_cost' => $shipping,
                'tax_amount' => $tax,
                'promotion_code' => $promotionCode,
                'discount_amount' => $discount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $validated['payment_method_id'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_phone' => $validated['shipping_phone'],
                'shipping_name' => $validated['shipping_name'],
                'shipping_email' => $validated['shipping_email'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($cartData['items'] as $item) {
                $orderItemData = [
                    'order_id' => $order->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ];

                // Handle regular products vs flash sales
                if (!empty($item['product_id'])) {
                    $orderItemData['product_id'] = $item['product_id'];
                } else if (!empty($item['flash_sale_id'])) {
                    // For flash sales, store as flash_sale_id
                    $orderItemData['flash_sale_id'] = $item['flash_sale_id'];
                    // Also try to get product_id from flash sale if linked
                    if ($item['flashSale']->product_id) {
                        $orderItemData['product_id'] = $item['flashSale']->product_id;
                    }
                }

                OrderItem::create($orderItemData);
            }

            session()->forget('cart');

            return redirect()->route('checkout.success', $order->id)
                ->with('success', 'Đặt hàng thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $paymentMethod = $order->paymentMethod;
        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('checkout.success', compact('order', 'paymentMethod', 'bankAccounts'));
    }

    public function validateCoupon(Request $request)
    {
        try {
            $code = trim(strtoupper($request->input('code', '')));
            
            if (empty($code)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập mã giảm giá'
                ]);
            }

            $promotion = Promotion::where('code', $code)
                ->where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$promotion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không hợp lệ hoặc hết hạn'
                ]);
            }

            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng trống'
                ]);
            }

            $cartData = $this->processCartItems($cart);
            $discount = $promotion->calculateDiscount($cartData['subtotal']);
            $isShippingDiscount = $promotion->isShippingDiscount();

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng thành công',
                'code' => $code,
                'discount' => $discount,
                'discount_text' => number_format($discount, 0, ',', '.'),
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value,
                'is_shipping_discount' => $isShippingDiscount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}

