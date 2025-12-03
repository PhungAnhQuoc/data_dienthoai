<!-- Toast Helper - Thêm vào view bất kỳ nơi bạn muốn hiển thị toast -->
<!-- 
    Cách sử dụng:
    
    1. Trong Blade view, thêm phần tử này để hiển thị toast:
    @if ($message = Session::get('success'))
        <div data-toast-success="{{ $message }}"></div>
    @endif
    
    2. Hoặc sử dụng JavaScript trực tiếp:
    <script>
        Toast.success('Đã thêm sản phẩm vào giỏ hàng');
        Toast.error('Có lỗi xảy ra');
        Toast.warning('Cảnh báo');
        Toast.info('Thông tin');
    </script>
    
    3. Trong controller Laravel:
    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng');
-->

<div class="toast-helpers">
    <!-- Hiển thị session messages tự động -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div data-toast-error="{{ $error }}"></div>
        @endforeach
    @endif

    @if (session('success'))
        <div data-toast-success="{{ session('success') }}"></div>
    @endif

    @if (session('error'))
        <div data-toast-error="{{ session('error') }}"></div>
    @endif

    @if (session('warning'))
        <div data-toast-warning="{{ session('warning') }}"></div>
    @endif

    @if (session('info'))
        <div data-toast-info="{{ session('info') }}"></div>
    @endif
</div>

<script>
    // Hỗ trợ sử dụng Toast từ bất kỳ nơi đâu
    window.showToast = function(message, type = 'info', title = null) {
        if (window.Toast) {
            window.Toast[type](message, title);
        }
    };
</script>
