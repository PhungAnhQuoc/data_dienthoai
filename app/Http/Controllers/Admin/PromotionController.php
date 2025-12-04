<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|unique:promotions,code|max:50',
                'description' => 'nullable|string|max:500',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'is_active' => 'boolean',
            ]);

            $validated['is_active'] = $request->has('is_active');

            Promotion::create($validated);

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Tạo mã ưu đãi thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.promotions.edit', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|unique:promotions,code,' . $promotion->id . '|max:50',
                'description' => 'nullable|string|max:500',
                'discount_type' => 'required|in:percentage,fixed',
                'discount_value' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'is_active' => 'boolean',
            ]);

            $validated['is_active'] = $request->has('is_active');

            $promotion->update($validated);

            return redirect()->route('admin.promotions.index')
                ->with('success', 'Cập nhật mã ưu đãi thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function destroy(Promotion $promotion)
    {
        try {
            $promotion->delete();
            return redirect()->route('admin.promotions.index')
                ->with('success', 'Xóa mã ưu đãi thành công');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
