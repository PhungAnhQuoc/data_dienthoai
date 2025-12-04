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

    public function index()
    {
        $user = Auth::user();
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
            $product = Product::find($productId);
            
            // Lấy giá từ cart nếu có, nếu không lấy từ product (ưu tiên sale_price)
            if (isset($item['price']) && $item['price'] > 0) {
                $price = (float) $item['price'];
            } else if ($product) {
                $price = $product->sale_price > 0 ? (float) $product->sale_price : (float) $product->price;
            } else {
                $price = 0;
            }

            $cartItems[] = array_merge([
                'product_id' => $productId,
                'product' => $product,
                'name' => $product ? $product->name : (is_array($item) && isset($item['name']) ? $item['name'] : 'Sản phẩm'),
                'price' => $price,
                'quantity' => $quantity,
            ], is_array($item) ? $item : []);

            $subtotal += $price * $quantity;
        }

        $shipping = 30000;
        $tax = round($subtotal * 0.1);
        $total = $subtotal + $shipping + $tax;

        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $bankAccounts = BankAccount::where('is_active', true)->get();

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'tax',
            'total',
            'user',
            'paymentMethods',
            'bankAccounts'
        ));
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

            $subtotal = 0;
            foreach ($cart as $productId => $item) {
                $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $product = Product::find($productId);
                
                // Lấy giá từ cart nếu có, nếu không lấy từ product
                if (isset($item['price']) && $item['price'] > 0) {
                    $price = (float) $item['price'];
                } else if ($product) {
                    $price = $product->sale_price > 0 ? (float) $product->sale_price : (float) $product->price;
                } else {
                    $price = 0;
                }

                $subtotal += $price * $quantity;
            }

            $shipping = 30000;
            $tax = round($subtotal * 0.1);
            $discount = 0;
            $promotionCode = null;

            // Validate promotion code if provided
            if ($request->has('promotion_code') && !empty($request->get('promotion_code'))) {
                $promoCode = trim(strtoupper($request->get('promotion_code')));
                $promotion = Promotion::where('code', $promoCode)
                    ->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if ($promotion) {
                    // Calculate discount
                    if ($promotion->discount_type === 'percentage') {
                        $discount = round($subtotal * ($promotion->discount_value / 100));
                    } else {
                        $discount = (int)$promotion->discount_value;
                    }
                    $promotionCode = $promoCode;
                }
            }

            $total = $subtotal + $shipping + $tax - $discount;

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

            foreach ($cart as $productId => $item) {
                $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $product = Product::find($productId);
                
                // Lấy giá từ cart nếu có, nếu không lấy từ product
                if (isset($item['price']) && $item['price'] > 0) {
                    $price = (float) $item['price'];
                } else if ($product) {
                    $price = $product->sale_price > 0 ? (float) $product->sale_price : (float) $product->price;
                } else {
                    $price = 0;
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'total_price' => $price * $quantity,
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
            $code = trim(strtoupper($request->get('code', '')));
            
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

            // Get current cart subtotal
            $cart = session()->get('cart', []);
            if (empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng trống'
                ]);
            }

            $subtotal = 0;
            foreach ($cart as $productId => $item) {
                $quantity = isset($item['quantity']) ? (int) $item['quantity'] : 1;
                $product = Product::find($productId);
                
                if (isset($item['price']) && $item['price'] > 0) {
                    $price = (float) $item['price'];
                } else if ($product) {
                    $price = $product->sale_price > 0 ? (float) $product->sale_price : (float) $product->price;
                } else {
                    $price = 0;
                }
                $subtotal += $price * $quantity;
            }

            // Calculate discount
            $discount = 0;
            if ($promotion->discount_type === 'percentage') {
                $discount = round($subtotal * ($promotion->discount_value / 100));
            } else {
                $discount = (int)$promotion->discount_value;
            }

            // Add conditions message if needed
            $conditions = [];
            if ($subtotal < 500000) {
                $conditions[] = 'Đơn hàng tối thiểu 500.000₫';
            }

            if (!empty($conditions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Điều kiện áp dụng: ' . implode(', ', $conditions)
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng thành công',
                'code' => $code,
                'discount' => $discount,
                'discount_text' => number_format($discount, 0, ',', '.'),
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}

