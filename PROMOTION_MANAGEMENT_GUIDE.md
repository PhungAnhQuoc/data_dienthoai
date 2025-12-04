# Hướng dẫn Quản lý Mã Ưu đãi (Promotions Management)

## 📋 Tính năng

Hệ thống quản lý mã ưu đãi cho phép bạn:

-   ✅ Tạo mã ưu đãi mới
-   ✅ Chỉnh sửa mã ưu đãi hiện tại
-   ✅ Xóa mã ưu đãi
-   ✅ Kích hoạt/vô hiệu hóa mã ưu đãi
-   ✅ Theo dõi thời gian áp dụng mã ưu đãi
-   ✅ Hỗ trợ 2 loại giảm giá: Phần trăm (%) và Cố định (₫)

## 🚀 Cách sử dụng

### 1. Truy cập trang quản lý

-   Đăng nhập vào Admin Panel
-   Chọn **"Mã ưu đãi"** từ menu sidebar bên trái

### 2. Tạo mã ưu đãi mới

1. Nhấp nút **"Thêm mã ưu đãi"** (nút xanh)
2. Điền thông tin:

    - **Mã ưu đãi**: VD `SUMMER20`, `SALE50` (chữ hoa, không khoảng trắng)
    - **Mô tả**: Mô tả chi tiết về mã ưu đãi (tùy chọn)
    - **Loại giảm giá**:
        - Phần trăm (%): Giảm % so với giá trị đơn hàng
        - Cố định (₫): Giảm số tiền cố định
    - **Giá trị**: Nhập giá trị giảm giá (VD: 20 cho 20%, hoặc 100000 cho 100.000₫)
    - **Ngày bắt đầu**: Ngày bắt đầu áp dụng mã
    - **Ngày kết thúc**: Ngày hết hạn mã
    - **Kích hoạt**: Ticked để bật mã ưu đãi

3. Nhấn **"Tạo mã ưu đãi"** để lưu

### 3. Chỉnh sửa mã ưu đãi

1. Từ danh sách, nhấn nút **Chỉnh sửa** (biểu tượng bút chì)
2. Chỉnh sửa thông tin cần thiết
3. Nhấn **"Cập nhật"** để lưu

### 4. Xóa mã ưu đãi

1. Từ danh sách, nhấn nút **Xóa** (biểu tượng thùng rác)
2. Xác nhận lại khi được yêu cầu

### 5. Kích hoạt/Vô hiệu hóa mã

-   Chỉnh sửa mã ưu đãi và tick/bỏ tick vào checkbox "Kích hoạt mã ưu đãi"
-   Hoặc ngoài mục **Trạng thái** trong danh sách hiển thị `Hoạt động` hoặc `Không hoạt động`

## 📊 Ví dụ

### Ví dụ 1: Mã giảm 20%

```
Mã ưu đãi: SUMMER20
Loại giảm giá: Phần trăm (%)
Giá trị: 20
→ Khách hàng nhập mã này, giảm 20% giá đơn hàng
```

### Ví dụ 2: Mã giảm 100.000₫

```
Mã ưu đãi: SALE100K
Loại giảm giá: Cố định (₫)
Giá trị: 100000
→ Khách hàng nhập mã này, giảm 100.000₫ (cố định)
```

## 🔗 Quy trình hoạt động

### Luồng dữ liệu:

1. **Admin tạo mã ưu đãi** → Lưu vào database (bảng `promotions`)
2. **Khách hàng nhập mã** → Kiểm tra API `/kiem-tra-ma-giam-gia`
3. **Server xác thực**:
    - Mã có tồn tại?
    - Mã có hoạt động?
    - Có nằm trong thời gian áp dụng?
4. **Tính toán giảm giá** → Trả về cho frontend
5. **Lưu vào đơn hàng** → Trường `promotion_code` và `discount_amount` trong bảng `orders`

## 📱 Giao diện người dùng (Customer)

Khách hàng sẽ thấy:

1. Ô nhập mã ưu đãi ở trang **Giỏ hàng** (cart/index.blade.php)
2. Ô nhập mã ưu đãi ở trang **Thanh toán** (checkout/index.blade.php)
3. Khi nhập mã:
    - ✅ Thành công: Hiển thị mức giảm giá, tổng tiền được cập nhật
    - ❌ Thất bại: Hiển thị lỗi (mã không hợp lệ, hết hạn, etc.)

## 🔐 Điều kiện áp dụng (có thể mở rộng)

Hiện tại hệ thống kiểm tra:

-   ✅ Mã tồn tại trong database
-   ✅ Mã được kích hoạt (`is_active = true`)
-   ✅ Ngày hiện tại nằm trong khoảng từ `start_date` đến `end_date`

Có thể thêm điều kiện khác:

-   Đơn hàng tối thiểu (VD: tối thiểu 500.000₫)
-   Sản phẩm cụ thể
-   Danh mục cụ thể
-   Số lần sử dụng tối đa

## 📝 Cơ sở dữ liệu

### Bảng: `promotions`

```
id              - ID (khóa chính)
title           - Tiêu đề
description     - Mô tả
code            - Mã ưu đãi (duy nhất)
discount_value  - Giá trị giảm giá
discount_type   - Loại: 'percentage' hoặc 'fixed'
start_date      - Ngày bắt đầu
end_date        - Ngày kết thúc
is_active       - Trạng thái hoạt động
created_at      - Thời điểm tạo
updated_at      - Thời điểm cập nhật
```

### Bảng: `orders` (các trường mới)

```
promotion_code  - Mã ưu đãi được áp dụng
discount_amount - Số tiền giảm giá (tính toán được)
```

## 🛠️ Kỹ thuật

### Routes được thêm:

```php
Route::resource('promotions', PromotionController::class);
```

### API Endpoint (cho checkout):

```
POST /kiem-tra-ma-giam-gia
Request: { code: "SUMMER20" }
Response: { success: true, discount: 100000, ... }
```

### Controller chính:

-   `App\Http\Controllers\Admin\PromotionController`

### Views:

-   `resources/views/admin/promotions/index.blade.php` - Danh sách
-   `resources/views/admin/promotions/create.blade.php` - Tạo mới
-   `resources/views/admin/promotions/edit.blade.php` - Chỉnh sửa

## ⚠️ Lưu ý quan trọng

1. **Mã phải duy nhất**: Không thể có 2 mã ưu đãi giống nhau
2. **Mã viết hoa**: Hệ thống tự động chuyển mã nhập vào thành chữ hoa
3. **Kiểm tra ngày**: Đảm bảo `start_date ≤ end_date`
4. **Kích hoạt**: Chỉ mã được kích hoạt mới được sử dụng
5. **Loại giảm giá**:
    - Phần trăm: Tối đa 100%
    - Cố định: Có thể bất kỳ số tiền nào

## 🎯 Tiếp theo có thể làm

-   [ ] Thêm đếm số lần sử dụng của mỗi mã
-   [ ] Thêm giới hạn số lần sử dụng (`usage_limit`)
-   [ ] Thêm điều kiện: Đơn hàng tối thiểu
-   [ ] Thêm các sản phẩm/danh mục áp dụng cụ thể
-   [ ] Thêm báo cáo: Mã được sử dụng bao nhiêu lần?
-   [ ] Thêm nhập/xuất dữ liệu mã ưu đãi (Excel)
-   [ ] Thêm QR code cho mã ưu đãi

---

**Phiên bản**: 1.0  
**Ngày cập nhật**: Tháng 12, 2025
