<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    /**
     * Get all addresses for authenticated user
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        return $user->addresses()->get();
    }

    /**
     * Store a new address
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'street_address' => 'required|string|max:500',
            'ward' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean',
        ]);

        // If this is the default address, unset other defaults
        if ($validated['is_default'] ?? false) {
            /** @var User $user */
            $user = Auth::user();
            $user->addresses()->update(['is_default' => false]);
        }

        /** @var User $user */
        $user = Auth::user();
        $address = $user->addresses()->create($validated);

        return response()->json([
            'message' => 'Địa chỉ đã được thêm',
            'address' => $address,
        ]);
    }

    /**
     * Update an address
     */
    public function update(Request $request, UserAddress $address)
    {
        // Check if user owns this address
        if ($address->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'recipient_name' => 'string|max:255',
            'phone' => 'string|max:20',
            'email' => 'nullable|email',
            'street_address' => 'string|max:500',
            'ward' => 'string|max:255',
            'district' => 'string|max:255',
            'province' => 'string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            /** @var User $user */
            $user = Auth::user();
            $user->addresses()->update(['is_default' => false]);
        }

        $address->update($validated);

        return response()->json([
            'message' => 'Địa chỉ đã được cập nhật',
            'address' => $address,
        ]);
    }

    /**
     * Delete an address
     */
    public function destroy(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $address->delete();

        return response()->json(['message' => 'Địa chỉ đã được xóa']);
    }

    /**
     * Set as default address
     */
    public function setDefault(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        /** @var User $user */
        $user = Auth::user();
        $user->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return response()->json(['message' => 'Đã đặt làm địa chỉ mặc định']);
    }
}
