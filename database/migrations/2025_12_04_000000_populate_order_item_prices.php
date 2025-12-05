<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate unit_price and total_price for order items that have NULL values
        $orderItems = OrderItem::whereNull('unit_price')
            ->orWhere('unit_price', 0)
            ->get();

        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                // Use sale_price if available, otherwise use price
                $price = $product->sale_price > 0 ? $product->sale_price : $product->price;
                $item->unit_price = $price;
                $item->total_price = $price * $item->quantity;
                $item->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration doesn't need a down method as it just populates data
    }
};
