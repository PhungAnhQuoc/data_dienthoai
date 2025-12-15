@component('mail::message')
# Đơn hàng được xác nhận!

Cảm ơn bạn đã đặt hàng!

**Mã đơn hàng:** {{ $order->order_number }}  
**Ngày đặt:** {{ $order->created_at->format('d/m/Y H:i') }}  
**Tổng tiền:** {{ number_format($order->total_amount, 0, ',', '.') }}₫

## Chi tiết đơn hàng

| Sản phẩm | Số lượng | Giá | Thành tiền |
|----------|---------|-----|-----------|
@foreach($order->items as $item)
| {{ $item->product->name }} | {{ $item->quantity }} | {{ number_format($item->unit_price, 0, ',', '.') }}₫ | {{ number_format($item->total_price, 0, ',', '.') }}₫ |
@endforeach

**Tạm tính:** {{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount + $order->discount_amount, 0, ',', '.') }}₫  
**Phí vận chuyển:** {{ number_format($order->shipping_cost, 0, ',', '.') }}₫  
**Thuế:** {{ number_format($order->tax_amount, 0, ',', '.') }}₫  
@if($order->discount_amount > 0)
**Giảm giá:** -{{ number_format($order->discount_amount, 0, ',', '.') }}₫  
@endif

## Thông tin giao hàng

**Người nhận:** {{ $order->shipping_name }}  
**Địa chỉ:** {{ $order->shipping_address }}  
**Điện thoại:** {{ $order->shipping_phone }}

@component('mail::button', ['url' => route('checkout.success', $order->id)])
Xem chi tiết đơn hàng
@endcomponent

Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi.

Cảm ơn,  
{{ config('app.name') }}
@endcomponent
