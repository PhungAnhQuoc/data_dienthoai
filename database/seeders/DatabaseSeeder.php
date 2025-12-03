<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Banner;
use App\Models\Promotion;
use App\Models\BlogPost;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Run all seeders
        $this->call([
            BannerSeeder::class,
            AdminSeeder::class,
        ]);

        // Categories
        $categories = [
            ['name' => 'Điện thoại', 'slug' => 'dien-thoai'],
            ['name' => 'Phụ kiện', 'slug' => 'phu-kien'],
            ['name' => 'Tai nghe', 'slug' => 'tai-nghe'],
            ['name' => 'Sạc dự phòng', 'slug' => 'sac-du-phong'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Brands
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple'],
            ['name' => 'Samsung', 'slug' => 'samsung'],
            ['name' => 'Xiaomi', 'slug' => 'xiaomi'],
            ['name' => 'OPPO', 'slug' => 'oppo'],
            ['name' => 'Realme', 'slug' => 'realme'],
            ['name' => 'OnePlus', 'slug' => 'oneplus'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }

        // Products
        $products = [
            [
                'category_id' => 1,
                'brand_id' => 1,
                'name' => 'iPhone 15 Pro Max',
                'slug' => 'iphone-15-pro-max',
                'sku' => 'IPHONE15PROMAX',
                'description' => 'Chip A17 Pro mạnh mẽ, Camera 48MP, Titan Design',
                'price' => 29990000,
                'sale_price' => 27990000,
                'stock' => 50,
                'main_image' => 'products/iphone-15-pro-max.jpg',
                'is_featured' => true,
                'is_new' => true,
            ],
            [
                'category_id' => 1,
                'brand_id' => 2,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'sku' => 'SAMSUNGS24ULTRA',
                'description' => 'Snapdragon 8 Gen 3, S Pen tích hợp, Camera 200MP',
                'price' => 32990000,
                'sale_price' => 29990000,
                'stock' => 40,
                'main_image' => 'products/samsung-s24-ultra.jpg',
                'is_featured' => true,
                'is_bestseller' => true,
            ],
            [
                'category_id' => 1,
                'brand_id' => 3,
                'name' => 'Xiaomi 14 Pro',
                'slug' => 'xiaomi-14-pro',
                'sku' => 'XIAOMI14PRO',
                'description' => 'Snapdragon 8 Gen 3, Camera Leica, Sạc nhanh 120W',
                'price' => 19990000,
                'sale_price' => 17990000,
                'stock' => 30,
                'main_image' => 'products/xiaomi-14-pro.jpg',
                'is_featured' => true,
            ],
            [
                'category_id' => 1,
                'brand_id' => 4,
                'name' => 'OPPO Find X7 Pro',
                'slug' => 'oppo-find-x7-pro',
                'sku' => 'OPPOFINDX7PRO',
                'description' => 'Dimensity 9300, Camera Hasselblad, Màn hình AMOLED 120Hz',
                'price' => 22990000,
                'stock' => 25,
                'main_image' => 'products/oppo-find-x7.jpg',
                'is_bestseller' => true,
            ],
            [
                'category_id' => 2,
                'brand_id' => 1,
                'name' => 'AirPods Pro (Gen 2)',
                'slug' => 'airpods-pro-gen-2',
                'sku' => 'AIRPODSPRO2',
                'description' => 'Chống ồn chủ động, Âm thanh không gian',
                'price' => 6490000,
                'stock' => 100,
                'main_image' => 'products/airpods-pro.jpg',
            ],
            [
                'category_id' => 2,
                'brand_id' => 2,
                'name' => 'Galaxy Buds2 Pro',
                'slug' => 'galaxy-buds2-pro',
                'sku' => 'GALAXYBUDS2PRO',
                'description' => 'Âm thanh Hi-Fi 24bit, Chống ồn thông minh',
                'price' => 4990000,
                'stock' => 80,
                'main_image' => 'products/galaxy-buds2-pro.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Banners
        Banner::create([
            'title' => 'Mẫu Flagship Mới Nhất Đã Ra Mắt',
            'description' => 'Trải nghiệm thế hệ tiếp theo của công nghệ di động. Mạnh mẽ, đẹp mắt và thông minh hơn bao giờ hết.',
            'image' => 'banners/hero-banner.jpg',
            'link' => '/san-pham',
            'sort_order' => 1,
        ]);

        // Promotions
        $promotions = [
            [
                'title' => 'Giảm giá khi chọn khách hàng mới',
                'description' => 'Giảm ngay 5.000.000đ cho đơn hàng từ 20 triệu',
                'code' => 'NEWVIP',
                'discount_value' => 5000000,
                'discount_type' => 'fixed',
                'start_date' => now(),
                'end_date' => now()->addDays(30),
            ],
            [
                'title' => 'Miễn Phí Vận Chuyển',
                'description' => 'Cho đơn hàng trên 5.000.000đ',
                'code' => 'FREESHIP',
                'discount_value' => 0,
                'discount_type' => 'fixed',
                'start_date' => now(),
                'end_date' => now()->addDays(60),
            ],
            [
                'title' => 'Flash Sale cuối tuần',
                'description' => 'Giảm giá đến 50% cho sản phẩm chọn lọc',
                'code' => 'SALE50',
                'discount_value' => 50,
                'discount_type' => 'percentage',
                'start_date' => now(),
                'end_date' => now()->addDays(7),
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }

        // Blog Posts
        $posts = [
            [
                'title' => 'Đánh giá chi tiết Flagship mới nhất năm 2024',
                'slug' => 'danh-gia-flagship-2024',
                'excerpt' => 'Những mẫu điện thoại cao cấp đáng chú ý nhất trong năm',
                'content' => 'Nội dung bài viết chi tiết...',
                'featured_image' => 'blog/flagship-2024.jpg',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'So sánh camera: iPhone 15 Pro Max vs Samsung S24 Ultra',
                'slug' => 'so-sanh-camera-iphone-samsung',
                'excerpt' => 'Cuộc đối đầu của hai ông lớn trong làng smartphone',
                'content' => 'Nội dung bài viết chi tiết...',
                'featured_image' => 'blog/camera-compare.jpg',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => '5 mẹo để kéo dài thời lượng pin cho điện thoại của bạn',
                'slug' => '5-meo-keo-dai-pin',
                'excerpt' => 'Những thủ thuật đơn giản giúp tiết kiệm pin hiệu quả',
                'content' => 'Nội dung bài viết chi tiết...',
                'featured_image' => 'blog/battery-tips.jpg',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create($post);
        }
    }
}