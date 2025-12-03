# Hướng Dẫn Sử Dụng Toast Notification

## 🎯 Tổng Quan

Dự án đã được cấu hình để hiển thị **Toast Notifications** (thông báo tự động) mỗi khi các thao tác thành công hoặc có lỗi. Chúng tôi đã sử dụng **Toastr.js** - một thư viện notification phổ biến, tin cậy và dễ sử dụng.

## ✨ Tính Năng

-   ✅ **Tự động hiển thị** session messages từ Laravel
-   ✅ **4 loại thông báo**: Success, Error, Warning, Info
-   ✅ **Hiệu ứng slide** mượt mà
-   ✅ **Progress bar** tự động đóng sau 5 giây
-   ✅ **Có nút close** để đóng thủ công
-   ✅ **Responsive** trên mobile và desktop

## 🚀 Cách Sử Dụng

### 1. Từ Controller (Laravel)

Trả về thông báo thành công:

```php
return back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
```

Trả về thông báo lỗi:

```php
return back()->with('error', 'Số lượng vượt quá tồn kho!');
```

Các loại khác:

```php
return back()->with('warning', 'Cảnh báo');
return back()->with('info', 'Thông tin');
```

### 2. Từ JavaScript

Gọi trực tiếp từ script:

```javascript
// Success
window.Toast.success("Thành công!", "Tiêu đề");

// Error
window.Toast.error("Có lỗi xảy ra", "Lỗi");

// Warning
window.Toast.warning("Cảnh báo", "Cảnh báo");

// Info
window.Toast.info("Thông tin", "Thông tin");
```

Hoặc sử dụng các hàm helper từ toast.js:

```javascript
import { showSuccess, showError, showWarning, showInfo } from "./toast";

showSuccess("Sản phẩm đã được thêm");
showError("Có lỗi xảy ra");
showWarning("Vui lòng kiểm tra lại");
showInfo("Thông tin cập nhật");
```

### 3. Từ Blade View

Thêm vào view:

```blade
<div data-toast-success="Thao tác thành công"></div>
<div data-toast-error="Có lỗi xảy ra"></div>
<div data-toast-warning="Cảnh báo"></div>
<div data-toast-info="Thông tin"></div>
```

## 📝 Cấu Hình Toastr

Các tùy chọn được cấu hình trong `resources/js/bootstrap.js`:

```javascript
toastr.options = {
    closeButton: true, // Hiển thị nút close
    debug: false, // Chế độ debug
    newestOnTop: false, // Toast mới ở dưới
    progressBar: true, // Hiển thị progress bar
    positionClass: "toast-top-right", // Vị trí hiển thị
    preventDuplicates: false, // Không chặn toast trùng
    onclick: null, // Hàm khi click
    showDuration: "300", // Thời gian hiệu ứng show (ms)
    hideDuration: "1000", // Thời gian hiệu ứng hide (ms)
    timeOut: "5000", // Thời gian tự đóng (ms)
    extendedTimeOut: "1000", // Thời gian extended (ms)
    showEasing: "swing", // Easing show
    hideEasing: "linear", // Easing hide
    showMethod: "slideDown", // Phương thức show
    hideMethod: "slideUp", // Phương thức hide
};
```

## 🎨 Styling

Toast notifications được style tự động với các màu sắc:

-   **Success**: Xanh lá (#28a745)
-   **Error**: Đỏ (#dc3545)
-   **Warning**: Vàng (#ffc107)
-   **Info**: Xanh dương (#17a2b8)

Tùy chỉnh CSS trong `node_modules/toastr/build/toastr.css` hoặc tạo override CSS riêng.

## 📂 Các File Liên Quan

-   `resources/js/bootstrap.js` - Khởi tạo Toastr
-   `resources/js/toast.js` - Helper functions
-   `resources/views/partials/toast-helper.blade.php` - Blade component
-   `resources/views/partials/toast-container.blade.php` - CSS styling (cũ, không sử dụng)
-   `resources/js/app.js` - Import CSS và khởi tạo toast

## 🔍 Kiểm Tra Hoạt Động

1. Truy cập trang thêm sản phẩm vào giỏ hàng
2. Thêm sản phẩm -> Sẽ hiện toast "Đã thêm sản phẩm vào giỏ hàng!"
3. Liên hệ -> Gửi form -> Sẽ hiện toast "Cảm ơn bạn!"
4. Tra cứu đơn với dữ liệu sai -> Sẽ hiện toast lỗi

## 🛠️ Troubleshooting

**Toast không hiển thị?**

1. Đảm bảo đã chạy `npm run build`
2. Kiểm tra browser console có error không
3. Đảm bảo `window.Toast` được khởi tạo (`window.Toast.success` phải hoạt động)
4. Xác nhận `toastr` đã được import trong `bootstrap.js`

**Thay đổi không có hiệu lực?**

1. Xóa cache browser (Ctrl+Shift+Delete)
2. Chạy lại `npm run build`
3. Refresh trang (F5)

**Toast hiển thị quá nhanh hoặc quá chậm?**
Điều chỉnh `timeOut` trong `resources/js/bootstrap.js` (tính bằng milliseconds)

## 📚 Tài Liệu Thêm

-   [Toastr.js Documentation](http://codeseven.github.io/toastr/)
-   [GitHub Repository](https://github.com/CodeSeven/toastr)

---

**Cập nhật:** 03/12/2025
