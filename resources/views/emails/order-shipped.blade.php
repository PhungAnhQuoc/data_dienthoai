@component('mail::message')
# Đơn hàng đang trên đường!

Đơn hàng {{ $order->order_number }} của bạn vừa được giao cho đơn vị vận chuyển.

**Mã đơn hàng:** {{ $order->order_number }}  
**Ngày giao vận chuyển:** {{ optional($order->shipped_at)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}  
**Địa chỉ nhận:** {{ $order->shipping_address }}

Bạn có thể theo dõi tình trạng giao hàng bằng cách nhấp vào nút dưới đây.

@component('mail::button', ['url' => route('checkout.success', $order->id)])
Theo dõi giao hàng
@endcomponent

Cảm ơn bạn đã chọn chúng tôi!

{{ config('app.name') }}
@endcomponent
