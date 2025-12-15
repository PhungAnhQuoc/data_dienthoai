<?php

namespace App\Http\Controllers\Admin;

use App\Models\FlashSale;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlashSaleController extends Controller
{
    /**
     * Hiển thị danh sách flash sales
     */
    public function index()
    {
        $flashSales = FlashSale::with('product')
            ->orderBy('sort_order', 'asc')
            ->paginate(15);
        
        return view('admin.flash-sales.index', compact('flashSales'));
    }

    /**
     * Hiển thị form tạo flash sale
     */
    public function create()
    {
        $products = Product::where('is_active', true)->get();
        return view('admin.flash-sales.create', compact('products'));
    }

    /**
     * Lưu flash sale mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lt:original_price',
            'stock' => 'required|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'color_badge' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['discount_percentage'] = round(
            (($validated['original_price'] - $validated['sale_price']) / $validated['original_price']) * 100
        );

        // Mặc định kích hoạt flash sale
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('flash-sales', 'public');
            $validated['image'] = $path;
        }

        FlashSale::create($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa
     */
    public function edit($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $products = Product::where('is_active', true)->get();
        
        return view('admin.flash-sales.edit', compact('flashSale', 'products'));
    }

    /**
     * Cập nhật flash sale
     */
    public function update(Request $request, $id)
    {
        $flashSale = FlashSale::findOrFail($id);

        $validated = $request->validate([
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'original_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0|lt:original_price',
            'stock' => 'required|integer|min:1',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'color_badge' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['discount_percentage'] = round(
            (($validated['original_price'] - $validated['sale_price']) / $validated['original_price']) * 100
        );

        if ($request->hasFile('image')) {
            if ($flashSale->image) {
                \Storage::disk('public')->delete($flashSale->image);
            }
            $path = $request->file('image')->store('flash-sales', 'public');
            $validated['image'] = $path;
        }

        $flashSale->update($validated);

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale đã được cập nhật thành công!');
    }

    /**
     * Xóa flash sale
     */
    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);

        if ($flashSale->image) {
            \Storage::disk('public')->delete($flashSale->image);
        }

        $flashSale->delete();

        return redirect()->route('admin.flash-sales.index')
            ->with('success', 'Flash Sale đã được xóa thành công!');
    }
}
