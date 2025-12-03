<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bỏ qua nếu admin user đã tồn tại
        if (User::where('email', 'admin@example.com')->exists()) {
            echo "Admin account already exists!\n";
            return;
        }

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'is_admin' => 1,
            'phone' => '0123456789',
            'address' => 'Hà Nội, Việt Nam'
        ]);

        echo "Admin account created!\n";
        echo "Email: admin@example.com\n";
        echo "Password: admin123\n";
    }
}
