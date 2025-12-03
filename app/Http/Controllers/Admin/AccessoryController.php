<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AccessoryController extends Controller
{
    public function index()
    {
        $accessories = Accessory::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.accessories.index', compact('accessories'));
    }

    public function create()
    {
        return view('admin.accessories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $count = Accessory::where('slug', $validated['slug'])->count();
        if ($count > 0) {
            $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('accessories', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        Accessory::create($validated);

        return redirect()->route('admin.accessories.index')
            ->with('success', 'Thêm phụ kiện thành công!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Accessory $accessory)
    {
        return view('admin.accessories.edit', compact('accessory'));
    }

    public function update(Request $request, Accessory $accessory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $count = Accessory::where('slug', $validated['slug'])
            ->where('id', '!=', $accessory->id)
            ->count();
        if ($count > 0) {
            $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
        }

        if ($request->hasFile('image')) {
            if ($accessory->image && Storage::disk('public')->exists($accessory->image)) {
                Storage::disk('public')->delete($accessory->image);
            }
            $validated['image'] = $request->file('image')->store('accessories', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $accessory->update($validated);

        return redirect()->route('admin.accessories.index')
            ->with('success', 'Cập nhật phụ kiện thành công!');
    }

    public function destroy(Accessory $accessory)
    {
        if ($accessory->image && Storage::disk('public')->exists($accessory->image)) {
            Storage::disk('public')->delete($accessory->image);
        }

        $accessory->delete();

        return redirect()->route('admin.accessories.index')
            ->with('success', 'Xóa phụ kiện thành công!');
    }
}
