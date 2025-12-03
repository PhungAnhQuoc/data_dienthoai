<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Payment Methods
        PaymentMethod::create([
            'name' => 'bank_transfer',
            'display_name' => 'Chuyển khoản ngân hàng',
            'description' => 'Thanh toán bằng cách chuyển khoản vào tài khoản ngân hàng của cửa hàng',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        PaymentMethod::create([
            'name' => 'cod',
            'display_name' => 'Thanh toán khi nhận hàng',
            'description' => 'Thanh toán khi nhận sản phẩm tại địa chỉ',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        // Bank Accounts
        BankAccount::create([
            'bank_name' => 'Vietcombank',
            'account_number' => '0081000123456789',
            'account_holder' => 'PHUNG ANH QUOC',
            'qr_code' => 'https://www.bing.com/th/id/OIP.QVUyzD-MNXtUCLq264fMcgHaIQ?w=198&h=211&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2',
            'is_active' => true,
        ]);

        
    }
}