<?php

namespace Database\Seeders;

use App\Models\FlashSale;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        
        FlashSale::create([
            'title' => 'iPhone 15 Pro Max',
            'description' => 'Điện thoại flagship mới nhất của Apple với camera 48MP siêu nét và pin 4,582mAh',
            'original_price' => 35000000,
            'sale_price' => 28500000,
            'discount_percentage' => 18,
            'stock' => 50,
            'sold' => 15,
            'starts_at' => $now->copy()->subHours(2),
            'ends_at' => $now->copy()->addHours(4),
            'image' => 'flash-sales/iphone-15.jpg',
            'color_badge' => '#FF6B6B',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        FlashSale::create([
            'title' => 'Samsung Galaxy S24 Ultra',
            'description' => 'Màn hình 6.8" QHD+ 120Hz, Snapdragon 8 Gen 3 Leading Version, Camera 200MP',
            'original_price' => 32000000,
            'sale_price' => 26500000,
            'discount_percentage' => 17,
            'stock' => 40,
            'sold' => 8,
            'starts_at' => $now->copy()->subHours(1),
            'ends_at' => $now->copy()->addHours(5),
            'image' => 'flash-sales/galaxy-s24.jpg',
            'color_badge' => '#4F46E5',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        FlashSale::create([
            'title' => 'Xiaomi 14 Ultra',
            'description' => 'Camera chính 50MP f/1.6, zoom quang học 3.2x, quay video 8K',
            'original_price' => 20000000,
            'sale_price' => 15500000,
            'discount_percentage' => 23,
            'stock' => 100,
            'sold' => 45,
            'starts_at' => $now->copy()->subMinutes(30),
            'ends_at' => $now->copy()->addHours(3),
            'image' => 'flash-sales/xiaomi-14.jpg',
            'color_badge' => '#FF9500',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        FlashSale::create([
            'title' => 'Google Pixel 8 Pro',
            'description' => 'Chip Tensor G3, Camera vệ tinh công nghệ Magic Eraser',
            'original_price' => 24000000,
            'sale_price' => 19800000,
            'discount_percentage' => 17,
            'stock' => 30,
            'sold' => 20,
            'starts_at' => $now->copy()->addMinutes(15),
            'ends_at' => $now->copy()->addHours(6),
            'image' => 'flash-sales/pixel-8.jpg',
            'color_badge' => '#10B981',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        FlashSale::create([
            'title' => 'OnePlus 12',
            'description' => 'Snapdragon 8 Gen 3, AMOLED 6.7", Sạc nhanh 100W',
            'original_price' => 18000000,
            'sale_price' => 14500000,
            'discount_percentage' => 19,
            'stock' => 60,
            'sold' => 35,
            'starts_at' => $now->copy()->subHours(3),
            'ends_at' => $now->copy()->addHours(2),
            'image' => 'flash-sales/oneplus-12.jpg',
            'color_badge' => '#EF4444',
            'is_active' => true,
            'sort_order' => 5,
        ]);
    }
}
