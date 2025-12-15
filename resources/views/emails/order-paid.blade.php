@component('mail::message')
# Thanh toán thành công!

Chúng tôi đã nhận được thanh toán của bạn cho đơn hàng {{ $order->order_number }}.

**Mã đơn hàng:** {{ $order->order_number }}  
**Ngày thanh toán:** {{ now()->format('d/m/Y H:i') }}  
**Tổng tiền:** {{ number_format($order->total_amount, 0, ',', '.') }}₫  
**Trạng thái:** ✓ Đã thanh toán

Đơn hàng của bạn đang được chuẩn bị và sẽ được giao sớm nhất có thể.

@component('mail::button', ['url' => route('checkout.success', $order->id)])
Theo dõi đơn hàng
@endcomponent

Cảm ơn bạn đã mua hàng!

{{ config('app.name') }}
@endcomponent
