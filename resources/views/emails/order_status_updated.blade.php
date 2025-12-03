<div style="font-family: Arial, sans-serif; color: #333;">
    <h2>Thông báo cập nhật đơn hàng</h2>

    <p>Xin chào {{ $order->shipping_name ?? ($order->user->name ?? 'Khách hàng') }},</p>

    <p>Đơn hàng <strong>{{ $order->order_number }}</strong> của bạn đã được cập nhật trạng thái:</p>

    <p style="font-size: 1.1rem;"><strong>{{ ucfirst($order->status) }}</strong></p>

    <p>Tổng tiền: <strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></p>

    <p>Bạn có thể xem chi tiết đơn hàng tại trang quản lý hoặc liên hệ với chúng tôi nếu cần hỗ trợ.</p>

    <hr>
    <p style="font-size:0.9rem; color:#666;">Cảm ơn bạn đã mua sắm tại cửa hàng.</p>
</div>
