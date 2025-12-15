@component('mail::message')
# {{ $title }}

{!! $content !!}

@component('mail::button', ['url' => $buttonUrl])
{{ $buttonText }}
@endcomponent

---

Bạn nhận được email này vì đã đăng ký nhận tin tức từ {{ config('app.name') }}.

[Hủy đăng ký]({{ $unsubscribeUrl }})

{{ config('app.name') }}
@endcomponent
