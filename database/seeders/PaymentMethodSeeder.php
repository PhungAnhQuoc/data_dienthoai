<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'bank-transfer',
                'display_name' => 'Chuyển khoản ngân hàng',
                'description' => 'Thanh toán bằng chuyển khoản vào tài khoản ngân hàng của cửa hàng',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'cod',
                'display_name' => 'Thanh toán khi nhận hàng',
                'description' => 'Thanh toán khi nhân viên giao hàng tới nơi của bạn',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'vnpay',
                'display_name' => 'VNPay',
                'description' => 'Thanh toán trực tuyến qua cổng thanh toán VNPay',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'credit-card',
                'display_name' => 'Thẻ tín dụng',
                'description' => 'Thanh toán bằng thẻ tín dụng',
                'sort_order' => 4,
                'is_active' => false,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}
