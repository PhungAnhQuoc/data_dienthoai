<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Toast Container -->
    @include('partials.toast-container')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Sản phẩm</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.index') }}">Tin tức</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.tracking') }}">Tra cứu đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.index') }}">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.index') }}">Giỏ hàng</a>
                        </li>
                    </ul>

                    <!-- Search Bar -->
                    <form action="{{ route('products.index') }}" method="GET" class="d-flex me-3" role="search">
                        <input class="form-control me-2 rounded-3" type="search" name="search" placeholder="Tìm sản phẩm..." value="{{ request('search') }}" aria-label="Search">
                        <button class="btn btn-outline-primary rounded-3" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <!-- Authentication Links for Guests -->
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Wishlist Icon -->
                            <li class="nav-item me-3">
                                <a href="{{ route('wishlist.index') }}" class="nav-link position-relative" title="Yêu thích">
                                    <i class="bi bi-heart fs-5"></i>
                                    @php
                                        $wishlistCount = Auth::user()->wishlists()->count();
                                    @endphp
                                    @if ($wishlistCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $wishlistCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            <!-- Cart Icon -->
                            <li class="nav-item me-3">
                                <a href="{{ route('cart.index') }}" class="nav-link position-relative" title="Giỏ hàng">
                                    <i class="bi bi-cart3 fs-5"></i>
                                    @php
                                        $cartCount = count(session('cart', []));
                                    @endphp
                                    @if ($cartCount > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>

                            <!-- Account Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('account.profile') }}" title="Tài khoản">
                                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                                </a>
                            </li>
                            
                            <!-- Logout Form -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   title="Đăng xuất">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        @include('partials.footer')
        @include('partials.toast-helper')

    </div>
        @stack('scripts')
</body>
</html>
