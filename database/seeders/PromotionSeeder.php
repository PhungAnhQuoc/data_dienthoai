<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing promotions
        Promotion::truncate();

        // Create sample promotions
        Promotion::create([
            'title' => 'Khuyến mãi mùa hè',
            'description' => 'Giảm 20% cho tất cả sản phẩm trong mùa hè',
            'code' => 'SUMMER20',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'start_date' => Carbon::now()->subDays(10),
            'end_date' => Carbon::now()->addMonths(2),
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Khuyến mãi Black Friday',
            'description' => 'Giảm 50% cho tất cả sản phẩm',
            'code' => 'BLACK50',
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(1),
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Khuyến mãi khách hàng mới',
            'description' => 'Giảm 100.000₫ cho đơn hàng lần đầu',
            'code' => 'NEW100K',
            'discount_type' => 'fixed',
            'discount_value' => 100000,
            'start_date' => Carbon::now()->subDays(30),
            'end_date' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Khuyến mãi Năm mới',
            'description' => 'Giảm 250.000₫ cho đơn hàng có giá trị cao',
            'code' => 'NEWYEAR250K',
            'discount_type' => 'fixed',
            'discount_value' => 250000,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addMonths(1),
            'is_active' => true,
        ]);

        Promotion::create([
            'title' => 'Khuyến mãi Ngày lễ',
            'description' => 'Giảm 15% cho tất cả sản phẩm',
            'code' => 'HOLIDAY15',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'start_date' => Carbon::now()->subDays(5),
            'end_date' => Carbon::now()->addDays(10),
            'is_active' => false, // Vô hiệu hóa
        ]);

        echo "✅ Đã tạo 5 mã ưu đãi mẫu thành công!\n";
    }
}
