<?php
// app/Http/Controllers/CartController.php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $cartItems = [];

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $price = $product->sale_price ?? $product->price;
                $subtotal = $price * $details['quantity'];
                $total += $subtotal;

                $cartItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal
                ];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Số lượng sản phẩm không đủ trong kho!');
        }

        $cart = Session::get('cart', []);
        $price = $product->sale_price ?? $product->price;

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $request->quantity;
            
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Số lượng vượt quá tồn kho!');
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
        
        return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho!'
            ]);
        }

        $cart = Session::get('cart', []);

        if (!is_array($cart) || !isset($cart[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
            ]);
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            $price = $product->sale_price ?? $product->price;
            $subtotal = $price * $request->quantity;
            
            $total = 0;
            foreach ($cart as $cartId => $details) {
                $cartProduct = Product::find($cartId);
                if ($cartProduct) {
                    $cartPrice = $cartProduct->sale_price ?? $cartProduct->price;
                    $total += $cartPrice * $details['quantity'];
                }
            }

            return response()->json([
                'success' => true,
                'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
                'total' => number_format($total, 0, ',', '.') . 'đ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
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