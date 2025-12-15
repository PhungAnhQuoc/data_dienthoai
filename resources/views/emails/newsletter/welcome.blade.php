@component('mail::message')
# Chào mừng bạn!

Cảm ơn bạn đã đăng ký nhận tin tức từ {{ config('app.name') }}.

Từ giờ bạn sẽ nhận được những:
- 📰 Tin tức mới nhất
- 🎁 Các chương trình khuyến mãi độc quyền
- 🆕 Sản phẩm mới từ cửa hàng

@component('mail::button', ['url' => route('home')])
Ghé thăm cửa hàng
@endcomponent

Nếu bạn không muốn nhận các email này, bạn có thể [hủy đăng ký]({{ $unsubscribeUrl }}) bất kỳ lúc nào.

Cảm ơn,<br>
{{ config('app.name') }}
@endcomponent
