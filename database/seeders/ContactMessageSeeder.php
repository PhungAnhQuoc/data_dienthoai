<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample contact messages with specific email
        ContactMessage::create([
            'name' => 'Phùng Anh Quốc',
            'email' => 'bag4store06@gmail.com',
            'phone' => '0987654321',
            'subject' => 'Câu hỏi về sản phẩm iPhone 15',
            'message' => 'Tôi muốn biết thêm thông tin chi tiết về iPhone 15 Pro Max, đặc biệt là cấu hình camera và pin.',
            'status' => 'replied',
            'admin_reply' => 'Cảm ơn bạn đã liên hệ! iPhone 15 Pro Max có camera 48MP với tính năng quay video 8K, pin kéo dài cả ngày. Vui lòng ghé shop để xem trực tiếp hoặc liên hệ 028.1234.567 để biết thêm chi tiết.',
            'replied_at' => now()->subHours(2),
        ]);

        ContactMessage::create([
            'name' => 'Phùng Anh Quốc',
            'email' => 'bag4store06@gmail.com',
            'phone' => '0987654321',
            'subject' => 'Vấn đề về bảo hành',
            'message' => 'Tôi mới mua Galaxy S24 nhưng phát hiện lỗi màn hình. Có thể trao đổi hoặc bảo hành được không?',
            'status' => 'replied',
            'admin_reply' => 'Xin lỗi vì sự cố! Samsung Galaxy S24 được bảo hành 12 tháng. Vui lòng mang sản phẩm và hoá đơn đến shop. Chúng tôi sẽ kiểm tra và xử lý ngay lập tức.',
            'replied_at' => now()->subDays(1),
        ]);

        ContactMessage::create([
            'name' => 'Phùng Anh Quốc',
            'email' => 'bag4store06@gmail.com',
            'phone' => '0987654321',
            'subject' => 'Yêu cầu hỗ trợ kỹ thuật',
            'message' => 'Điện thoại của tôi bị chậm, làm cách nào để tối ưu hóa hiệu suất?',
            'status' => 'pending',
            'admin_reply' => null,
            'replied_at' => null,
        ]);
    }
}
