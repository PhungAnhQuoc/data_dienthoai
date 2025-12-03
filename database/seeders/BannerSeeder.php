<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa tất cả banner cũ
        Banner::truncate();

        Banner::create([
            'title' => 'iPhone 15 Pro Max',
            'description' => 'Khám phá công nghệ tiên tiến và hiệu năng vô cùng mạnh mẽ',
            'image' => 'banner/iphone-15-pro-max.jpg',
            'link' => '/san-pham',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Samsung Galaxy S24',
            'description' => 'Trải nghiệm màn hình AMOLED tuyệt đẹp và camera AI tiên tiến',
            'image' => 'storage/app/public/banner/banner-dien-thoai-mobilecity-02.jpg',
            'link' => '/san-pham',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Banner::create([
            'title' => 'Xiaomi 14 Ultra',
            'description' => 'Sức mạnh Snapdragon 8 Gen 3 với giá tốt nhất',
            'image' => 'banner/xiaomi-14-ultra.jpg',
            'link' => '/san-pham',
            'sort_order' => 3,
            'is_active' => true,
        ]);
    }
}