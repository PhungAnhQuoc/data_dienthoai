<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\FlashSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getCartTotal(array $cart): array
    {
        if (empty($cart)) {
            return ['items' => [], 'total' => 0];
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
        $total = 0;

        foreach ($cart as $id => $details) {
            // Handle Flash Sale Items
            if (strpos($id, 'flash_sale_') === 0) {
                $flashSaleId = $details['flash_sale_id'] ?? str_replace('flash_sale_', '', $id);
                if ($flashSales->has($flashSaleId)) {
                    $flashSale = $flashSales->get($flashSaleId);
                    $price = $flashSale->sale_price;
                    $subtotal = $price * $details['quantity'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'id' => $id,
                        'flashSale' => $flashSale,
                        'product' => null,
                        'quantity' => $details['quantity'],
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'isFlashSale' => true
                    ];
                }
            } else {
                // Handle Regular Product Items
                if ($products->has($id)) {
                    $product = $products->get($id);
                    $price = $product->sale_price ?? $product->price;
                    $subtotal = $price * $details['quantity'];
                    $total += $subtotal;

                    $cartItems[] = [
                        'id' => $id,
                        'product' => $product,
                        'flashSale' => null,
                        'quantity' => $details['quantity'],
                        'price' => $price,
                        'subtotal' => $subtotal,
                        'isFlashSale' => false
                    ];
                }
            }
        }

        return ['items' => $cartItems, 'total' => $total];
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        $result = $this->getCartTotal($cart);

        return view('cart.index', ['cartItems' => $result['items'], 'total' => $result['total']]);
    }

    public function add(Request $request)
    {
        \Log::info('Cart add request received', [
            'flash_sale_id' => $request->get('flash_sale_id'),
            'product_id' => $request->get('product_id'),
            'quantity' => $request->get('quantity'),
            'session_id' => session()->getId()
        ]);
        
        // Handle JSON request (for AJAX flash sale)
        $isJson = $request->wantsJson();
        
        if ($isJson) {
            $request->validate([
                'flash_sale_id' => 'required_without:product_id|exists:flash_sales,id',
                'product_id' => 'required_without:flash_sale_id|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);
        } else {
            // For form requests, accept either flash_sale_id or product_id
            if ($request->has('flash_sale_id')) {
                $request->validate([
                    'flash_sale_id' => 'required|exists:flash_sales,id',
                    'quantity' => 'required|integer|min:1'
                ]);
            } else {
                $request->validate([
                    'product_id' => 'required|exists:products,id',
                    'quantity' => 'required|integer|min:1'
                ]);
            }
        }

        $cart = Session::get('cart', []);

        // Handle Flash Sale
        if ($request->has('flash_sale_id')) {
            $flashSale = FlashSale::findOrFail($request->flash_sale_id);

            // Check if flash sale is still active
            if (!$flashSale->is_active || $flashSale->starts_at > now() || $flashSale->ends_at <= now()) {
                $message = 'Flash sale này đã kết thúc hoặc không còn hoạt động!';
                return $isJson 
                    ? response()->json(['success' => false, 'message' => $message], 400)
                    : back()->with('error', $message);
            }

            // Check stock
            if ($flashSale->getRemainingStock() < $request->quantity) {
                $message = 'Số lượng flash sale không đủ. Chỉ còn ' . $flashSale->getRemainingStock() . ' sản phẩm.';
                return $isJson
                    ? response()->json(['success' => false, 'message' => $message], 400)
                    : back()->with('error', $message);
            }

            // Add to cart with flash sale data
            $flashSaleKey = 'flash_sale_' . $flashSale->id;
            
            if (isset($cart[$flashSaleKey])) {
                $newQuantity = $cart[$flashSaleKey]['quantity'] + $request->quantity;
                
                if ($newQuantity > $flashSale->getRemainingStock()) {
                    $message = 'Số lượng vượt quá tồn kho flash sale!';
                    return $isJson
                        ? response()->json(['success' => false, 'message' => $message], 400)
                        : back()->with('error', $message);
                }
                
                $cart[$flashSaleKey]['quantity'] = $newQuantity;
                $cart[$flashSaleKey]['price'] = $flashSale->sale_price;
            } else {
                $cart[$flashSaleKey] = [
                    'quantity' => $request->quantity,
                    'price' => $flashSale->sale_price,
                    'type' => 'flash_sale',
                    'flash_sale_id' => $flashSale->id,
                    'flash_sale_title' => $flashSale->title
                ];
            }

            // Update flash sale sold count
            $flashSale->increment('sold', $request->quantity);

            Session::put('cart', $cart);
            
            \Log::info('Flash sale added to cart', [
                'flash_sale_id' => $flashSale->id,
                'quantity' => $request->quantity,
                'cart_contents' => $cart,
                'session_id' => session()->getId()
            ]);

            $message = $flashSale->title . ' đã được thêm vào giỏ hàng!';
            return $isJson
                ? response()->json(['success' => true, 'message' => $message, 'cart' => $cart])
                : back()->with('success', $message);
        }

        // Handle Regular Product
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            $message = 'Số lượng sản phẩm không đủ trong kho!';
            return $isJson
                ? response()->json(['success' => false, 'message' => $message], 400)
                : back()->with('error', $message);
        }

        $price = $product->sale_price ?? $product->price;

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            
            if ($newQuantity > $product->stock) {
                $message = 'Số lượng vượt quá tồn kho!';
                return $isJson
                    ? response()->json(['success' => false, 'message' => $message], 400)
                    : back()->with('error', $message);
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
            $cart[$product->id]['price'] = $price;
        } else {
            $cart[$product->id] = [
                'quantity' => $request->quantity,
                'price' => $price
            ];
        }

        Session::put('cart', $cart);

        $message = 'Đã thêm sản phẩm vào giỏ hàng!';
        return $isJson
            ? response()->json(['success' => true, 'message' => $message])
            : back()->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);

        if (!is_array($cart) || !isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
            ]);
        }

        // Handle Flash Sale Items
        if (strpos($id, 'flash_sale_') === 0) {
            $flashSaleId = $cart[$id]['flash_sale_id'] ?? str_replace('flash_sale_', '', $id);
            $flashSale = FlashSale::findOrFail($flashSaleId);

            if ($flashSale->getRemainingStock() < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho flash sale! Chỉ còn ' . $flashSale->getRemainingStock() . ' sản phẩm.'
                ]);
            }

            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            $price = $flashSale->sale_price;
            $subtotal = $price * $request->quantity;
            $result = $this->getCartTotal($cart);

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
                'total' => number_format($result['total'], 0, ',', '.') . 'đ'
            ]);
        }

        // Handle Regular Product Items
        $product = Product::findOrFail($id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho!'
            ]);
        }

        $cart[$id]['quantity'] = $request->quantity;
        Session::put('cart', $cart);

        $price = $product->sale_price ?? $product->price;
        $subtotal = $price * $request->quantity;
        $result = $this->getCartTotal($cart);

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
            'total' => number_format($result['total'], 0, ',', '.') . 'đ'
        ]);
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (!is_array($cart) || !isset($cart[$id])) {
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
        }

        unset($cart[$id]);
        Session::put('cart', $cart);

        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Đã xóa toàn bộ giỏ hàng!');
    }
}