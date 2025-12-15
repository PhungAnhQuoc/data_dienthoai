@component('mail::message')
# Đơn hàng đã giao!

Đơn hàng {{ $order->order_number }} của bạn đã được giao thành công.

**Mã đơn hàng:** {{ $order->order_number }}  
**Ngày giao:** {{ optional($order->delivered_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}  
**Tổng tiền:** {{ number_format($order->total_amount, 0, ',', '.') }}₫

Chúng tôi hy vọng bạn hài lòng với sản phẩm! Nếu bạn có bất kỳ câu hỏi hoặc vấn đề nào, vui lòng liên hệ với chúng tôi.

@component('mail::button', ['url' => route('checkout.success', $order->id)])
Xem đơn hàng
@endcomponent

Cảm ơn bạn!

{{ config('app.name') }}
@endcomponent
