<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\BankAccount;
use App\Models\Product;
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

        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = $products->get($productId);
            $quantity = (int) ($item['quantity'] ?? 1);
            
            $price = $item['price'] ?? null;
            if (!$price && $product) {
                $price = $product->sale_price > 0 ? $product->sale_price : $product->price;
            }
            $price = (float) ($price ?? 0);

            if ($product) {
                $cartItems[] = [
                    'product_id' => $productId,
                    'product' => $product,
                    'name' => $product->name,
                    'price' => $price,
                    'quantity' => $quantity,
                ];
                $subtotal += $price * $quantity;
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
                'payment_method_id' => 'required|exists:payment_methods,id',
                'notes' => 'nullable|string|max:500',
            ]);

            $user = Auth::user();
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
            }

            $cartData = $this->processCartItems($cart);
            $shipping = 30000;
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
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
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

