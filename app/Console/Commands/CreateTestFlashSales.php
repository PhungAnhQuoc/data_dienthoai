<?php

namespace App\Console\Commands;

use App\Models\FlashSale;
use Illuminate\Console\Command;

class CreateTestFlashSales extends Command
{
    protected $signature = 'create:test-flash-sales';
    protected $description = 'Tạo 3 flash sale test với ngày giờ hợp lệ';

    public function handle()
    {
        // Xóa flash sales cũ
        FlashSale::truncate();
        
        // Tạo 3 flash sale
        $flashSales = [
            [
                'title' => 'iPhone 15 Pro Max - Giá Sốc',
                'description' => 'Giảm giá sốc 30% cho iPhone 15 Pro Max, chỉ còn 24h',
                'original_price' => 29990000,
                'sale_price' => 20990000,
                'discount_percentage' => 30,
                'stock' => 50,
                'sold' => 15,
                'starts_at' => now()->subHours(2), // Bắt đầu 2 giờ trước
                'ends_at' => now()->addHours(22), // Kết thúc trong 22 giờ
                'image' => 'flash-sales/iphone-15.jpg',
                'color_badge' => '#FF6B6B',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Samsung Galaxy S24 Ultra',
                'description' => 'Flagship Samsung giảm 25% - Công nghệ hàng đầu',
                'original_price' => 27990000,
                'sale_price' => 20990000,
                'discount_percentage' => 25,
                'stock' => 40,
                'sold' => 8,
                'starts_at' => now()->subMinutes(30), // Bắt đầu 30 phút trước
                'ends_at' => now()->addHours(23), // Kết thúc trong 23 giờ
                'image' => 'flash-sales/galaxy-s24.jpg',
                'color_badge' => '#FF8E72',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Xiaomi 14 Ultra',
                'description' => 'Camera 50MP giảm sâu 35% - Lợi dụng ngay!',
                'original_price' => 16990000,
                'sale_price' => 11090000,
                'discount_percentage' => 35,
                'stock' => 60,
                'sold' => 22,
                'starts_at' => now()->subHours(1), // Bắt đầu 1 giờ trước
                'ends_at' => now()->addHours(20), // Kết thúc trong 20 giờ
                'image' => 'flash-sales/xiaomi-14.jpg',
                'color_badge' => '#FFA500',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($flashSales as $sale) {
            FlashSale::create($sale);
        }

        $this->info('✅ Tạo 3 flash sale test thành công!');
        $this->line('Flash sales sẽ hiển thị ngay lập tức trên home page.');
    }
}
