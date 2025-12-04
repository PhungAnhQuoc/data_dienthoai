# ĐẶC TẢ USE CASE - MOBILE SHOP

## USE CASE 1: Xem Danh Sách Sản Phẩm

| Thuộc tính               | Giá trị                                                  |
| ------------------------ | -------------------------------------------------------- |
| **ID**                   | UC-001                                                   |
| **Tên**                  | Xem danh sách sản phẩm                                   |
| **Actor chính**          | Khách viếng thăm, Khách thành viên, Quản trị             |
| **Mục đích**             | Cho phép người dùng xem danh sách tất cả sản phẩm có sẵn |
| **Điều kiện tiên quyết** | Ứng dụng đang hoạt động                                  |
| **Điều kiện hậu quyết**  | Hiển thị danh sách sản phẩm                              |

**Luồng chính:**

1. Người dùng truy cập trang sản phẩm
2. Hệ thống tải danh sách sản phẩm từ database
3. Hiển thị danh sách sản phẩm với phân trang

---

## USE CASE 2: Xem Thông Tin Sản Phẩm

| Thuộc tính               | Giá trị                                      |
| ------------------------ | -------------------------------------------- |
| **ID**                   | UC-002                                       |
| **Tên**                  | Xem thông tin sản phẩm                       |
| **Actor chính**          | Khách viếng thăm, Khách thành viên, Quản trị |
| **Mục đích**             | Xem chi tiết một sản phẩm cụ thể             |
| **Điều kiện tiên quyết** | Sản phẩm tồn tại trong hệ thống              |
| **Điều kiện hậu quyết**  | Hiển thị thông tin chi tiết sản phẩm         |

**Luồng chính:**

1. Người dùng chọn một sản phẩm từ danh sách
2. Hệ thống lấy thông tin chi tiết sản phẩm
3. Hiển thị: tên, giá, hình ảnh, mô tả, đánh giá, hàng tồn kho

---

## USE CASE 3: Xem Thông Tin Bài Viết

| Thuộc tính               | Giá trị                                      |
| ------------------------ | -------------------------------------------- |
| **ID**                   | UC-003                                       |
| **Tên**                  | Xem thông tin bài viết                       |
| **Actor chính**          | Khách viếng thăm, Khách thành viên, Quản trị |
| **Mục đích**             | Xem nội dung chi tiết của một bài viết blog  |
| **Điều kiện tiên quyết** | Bài viết tồn tại và được xuất bản            |
| **Điều kiện hậu quyết**  | Hiển thị nội dung bài viết                   |

**Luồng chính:**

1. Người dùng chọn bài viết từ danh sách blog
2. Hệ thống lấy nội dung bài viết
3. Hiển thị: tiêu đề, nội dung, tác giả, ngày đăng, hình đại diện

---

## USE CASE 4: Đăng Ký

**2.2.1. Use Case "Đăng ký"**

| Thuộc tính      | Giá trị               |
| --------------- | --------------------- |
| **ID**          | UC-004                |
| **Tên**         | Đăng ký tài khoản     |
| **Actor chính** | Khách hàng viếng thăm |

**Tóm tắt:**
Khách hàng viếng thăm sử dụng use case "Đăng ký" để tạo tài khoản cho mình trên website.

**Điều kiện tiên quyết:**
Trước khi bắt đầu thực hiện Use-case không cần điều kiện gì.

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                                |
| ---- | ---------------------------------------------------------------------------------------------------------------------- |
| B1   | Trên giao diện màn hình chính, khách hàng viếng thăm chọn đăng ký.                                                     |
| B2   | Hệ thống sẽ hiển thị giao diện đăng ký và khách hàng viếng thăm nhập thông tin vào giao diện để lưu vào cơ sở dữ liệu. |
| B3   | Kết thúc Use case.                                                                                                     |

**Thông tin nhập liệu:**

-   Email
-   Mật khẩu
-   Xác nhận mật khẩu
-   Tên đầy đủ
-   Số điện thoại
-   Địa chỉ (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện Use-case:**

-   **Trường hợp thành công:** Hệ thống sẽ đưa khách hàng tới trang người dùng
-   **Trường hợp lỗi:** Hệ thống hiển thị thông báo lỗi tương ứng:
    -   Email đã tồn tại
    -   Mật khẩu không hợp lệ
    -   Thông tin thiếu
    -   Mật khẩu xác nhận không khớp

Người dùng được yêu cầu nhập lại thông tin cho đúng.

**Điểm mở rộng:**
Không có.

**Luồng ngoại lệ:**

1. **Email đã tồn tại:** Hệ thống báo lỗi, yêu cầu nhập email khác
2. **Mật khẩu không hợp lệ:** Hệ thống báo lỗi, mật khẩu phải từ 8 ký tự trở lên
3. **Thông tin thiếu:** Hệ thống báo lỗi, yêu cầu điền tất cả thông tin bắt buộc
4. **Mật khẩu xác nhận không khớp:** Hệ thống báo lỗi, yêu cầu nhập lại

---

## USE CASE 5: Tìm Kiếm, Lọc Sản Phẩm

| Thuộc tính               | Giá trị                                      |
| ------------------------ | -------------------------------------------- |
| **ID**                   | UC-005                                       |
| **Tên**                  | Tìm kiếm, lọc sản phẩm                       |
| **Actor chính**          | Khách viếng thăm, Khách thành viên, Quản trị |
| **Mục đích**             | Tìm kiếm sản phẩm theo tiêu chí              |
| **Điều kiện tiên quyết** | Sản phẩm tồn tại trong hệ thống              |
| **Điều kiện hậu quyết**  | Danh sách sản phẩm phù hợp được hiển thị     |

**Luồng chính:**

1. Người dùng nhập từ khóa tìm kiếm hoặc chọn bộ lọc
2. Hệ thống tìm kiếm theo: tên, danh mục, thương hiệu, khoảng giá
3. Hiển thị kết quả tìm kiếm

---

## USE CASE 6: Đưa Sản Phẩm Vào Giỏ Hàng

| Thuộc tính               | Giá trị                                  |
| ------------------------ | ---------------------------------------- |
| **ID**                   | UC-006                                   |
| **Tên**                  | Đưa sản phẩm vào giỏ hàng                |
| **Actor chính**          | Khách thành viên                         |
| **Mục đích**             | Thêm sản phẩm vào giỏ hàng               |
| **Điều kiện tiên quyết** | Người dùng đã đăng nhập, sản phẩm có sẵn |
| **Điều kiện hậu quyết**  | Sản phẩm được thêm vào giỏ hàng          |

**Luồng chính:**

1. Người dùng chọn sản phẩm và nhập số lượng
2. Kiểm tra hàng tồn kho
3. Thêm sản phẩm vào giỏ hàng
4. Hiển thị thông báo thành công

**Luồng ngoại lệ:**

-   Hàng không đủ: Hiển thị thông báo lỗi

---

## USE CASE 7: Đặt Mua

| Thuộc tính               | Giá trị                                       |
| ------------------------ | --------------------------------------------- |
| **ID**                   | UC-007                                        |
| **Tên**                  | Đặt mua                                       |
| **Actor chính**          | Khách thành viên                              |
| **Mục đích**             | Tạo đơn hàng                                  |
| **Điều kiện tiên quyết** | Giỏ hàng có sản phẩm, người dùng đã đăng nhập |
| **Điều kiện hậu quyết**  | Đơn hàng được tạo                             |

**Luồng chính:**

1. Người dùng xem giỏ hàng và nhấn "Đặt mua"
2. Nhập/xác nhận thông tin giao hàng
3. Chọn phương thức thanh toán
4. Xác nhận đơn hàng
5. Hệ thống tạo đơn hàng

---

## USE CASE 8: Thanh Toán

| Thuộc tính               | Giá trị                                     |
| ------------------------ | ------------------------------------------- |
| **ID**                   | UC-008                                      |
| **Tên**                  | Thanh toán                                  |
| **Actor chính**          | Khách thành viên                            |
| **Mục đích**             | Xử lý thanh toán đơn hàng                   |
| **Điều kiện tiên quyết** | Đơn hàng được tạo                           |
| **Điều kiện hậu quyết**  | Thanh toán hoàn tất, đơn hàng được xác nhận |

**Luồng chính:**

1. Hệ thống xử lý thanh toán theo phương thức đã chọn
2. Xác nhận giao dịch
3. Cập nhật trạng thái đơn hàng
4. Gửi email xác nhận

---

## USE CASE 9: Quản Lý Đơn Hàng

| Thuộc tính               | Giá trị                        |
| ------------------------ | ------------------------------ |
| **ID**                   | UC-009                         |
| **Tên**                  | Quản lý đơn hàng               |
| **Actor chính**          | Quản trị                       |
| **Mục đích**             | Xem và quản lý tất cả đơn hàng |
| **Điều kiện tiên quyết** | Đơn hàng tồn tại               |
| **Điều kiện hậu quyết**  | Hiển thị danh sách đơn hàng    |

**Luồng chính:**

1. Admin truy cập trang quản lý đơn hàng
2. Xem danh sách đơn hàng với các bộ lọc
3. Có thể xem chi tiết, cập nhật trạng thái

---

## USE CASE 10: Quản Lý Sản Phẩm

| Thuộc tính               | Giá trị                   |
| ------------------------ | ------------------------- |
| **ID**                   | UC-010                    |
| **Tên**                  | Quản lý sản phẩm          |
| **Actor chính**          | Quản trị                  |
| **Mục đích**             | CRUD sản phẩm             |
| **Điều kiện tiên quyết** | Admin đã đăng nhập        |
| **Điều kiện hậu quyết**  | Sản phẩm được tạo/sửa/xóa |

**Luồng chính (Tạo):**

1. Admin truy cập trang quản lý sản phẩm
2. Nhấn "Thêm sản phẩm mới"
3. Nhập: tên, giá, mô tả, hình ảnh, danh mục, thương hiệu
4. Lưu sản phẩm
5. Hiển thị thông báo thành công

**Luồng chính (Sửa):**

1. Chọn sản phẩm cần sửa
2. Cập nhật thông tin
3. Lưu thay đổi

**Luồng chính (Xóa):**

1. Chọn sản phẩm cần xóa
2. Xác nhận xóa
3. Sản phẩm được xóa

---

## USE CASE 11: Quản Lý Thông Tin Khác

| Thuộc tính               | Giá trị                                                            |
| ------------------------ | ------------------------------------------------------------------ |
| **ID**                   | UC-011                                                             |
| **Tên**                  | Quản lý thông tin khác                                             |
| **Actor chính**          | Quản trị                                                           |
| **Mục đích**             | Quản lý: danh mục, thương hiệu, phụ kiện, banner, khuyến mãi, blog |
| **Điều kiện tiên quyết** | Admin đã đăng nhập                                                 |
| **Điều kiện hậu quyết**  | Thông tin được cập nhật                                            |

**Luồng chính:** Tương tự UC-010 nhưng áp dụng cho các tài nguyên khác

---

## USE CASE 12: Thống Kê

| Thuộc tính               | Giá trị                            |
| ------------------------ | ---------------------------------- |
| **ID**                   | UC-012                             |
| **Tên**                  | Thống kê                           |
| **Actor chính**          | Quản trị                           |
| **Mục đích**             | Xem báo cáo thống kê               |
| **Điều kiện tiên quyết** | Admin đã đăng nhập                 |
| **Điều kiện hậu quyết**  | Hiển thị biểu đồ, số liệu thống kê |

**Luồng chính:**

1. Admin truy cập trang dashboard/thống kê
2. Xem: tổng doanh thu, số đơn hàng, sản phẩm bán chạy
3. Có thể lọc theo khoảng thời gian

---

## USE CASE 17: Đăng Nhập

| Thuộc tính               | Giá trị                  |
| ------------------------ | ------------------------ |
| **ID**                   | UC-017                   |
| **Tên**                  | Đăng nhập                |
| **Actor chính**          | Khách viếng thăm         |
| **Mục đích**             | Xác thực người dùng      |
| **Điều kiện tiên quyết** | Tài khoản đã tồn tại     |
| **Điều kiện hậu quyết**  | Người dùng được xác thực |

**Luồng chính:**

1. Người dùng truy cập trang đăng nhập
2. Nhập email/username và mật khẩu
3. Hệ thống xác thực thông tin
4. Tạo session/token
5. Chuyển hướng đến trang chủ

**Luồng ngoại lệ:**

-   Thông tin sai: Hiển thị thông báo lỗi

---

## USE CASE 18: Xem Lịch Sử Đơn Hàng

| Thuộc tính               | Giá trị                         |
| ------------------------ | ------------------------------- |
| **ID**                   | UC-018                          |
| **Tên**                  | Xem lịch sử đơn hàng            |
| **Actor chính**          | Khách thành viên                |
| **Mục đích**             | Xem danh sách đơn hàng của mình |
| **Điều kiện tiên quyết** | Người dùng đã đăng nhập         |
| **Điều kiện hậu quyết**  | Hiển thị danh sách đơn hàng     |

**Luồng chính:**

1. Người dùng truy cập tài khoản cá nhân
2. Xem tab "Lịch sử đơn hàng"
3. Hiển thị danh sách đơn hàng của người dùng
4. Có thể xem chi tiết từng đơn hàng

---

## USE CASE 20: Thêm Sản Phẩm Vào Yêu Thích

| Thuộc tính               | Giá trị                                    |
| ------------------------ | ------------------------------------------ |
| **ID**                   | UC-020                                     |
| **Tên**                  | Thêm sản phẩm vào yêu thích                |
| **Actor chính**          | Khách thành viên                           |
| **Mục đích**             | Lưu sản phẩm yêu thích                     |
| **Điều kiện tiên quyết** | Người dùng đã đăng nhập                    |
| **Điều kiện hậu quyết**  | Sản phẩm được thêm vào danh sách yêu thích |

**Luồng chính:**

1. Người dùng xem chi tiết sản phẩm
2. Nhấn nút "Thêm vào yêu thích"
3. Sản phẩm được lưu
4. Hiển thị thông báo thành công

---

## USE CASE 26: Đánh Giá Sản Phẩm

| Thuộc tính               | Giá trị                    |
| ------------------------ | -------------------------- |
| **ID**                   | UC-026                     |
| **Tên**                  | Đánh giá sản phẩm          |
| **Actor chính**          | Khách thành viên           |
| **Mục đích**             | Đánh giá sản phẩm đã mua   |
| **Điều kiện tiên quyết** | Người dùng đã mua sản phẩm |
| **Điều kiện hậu quyết**  | Đánh giá được lưu          |

**Luồng chính:**

1. Người dùng xem chi tiết sản phẩm
2. Điền: số sao (1-5), nội dung đánh giá
3. Gửi đánh giá
4. Đánh giá được lưu (chờ phê duyệt)

---

## USE CASE 30: Kiểm Tra Mã Giảm Giá

| Thuộc tính               | Giá trị                            |
| ------------------------ | ---------------------------------- |
| **ID**                   | UC-030                             |
| **Tên**                  | Kiểm tra mã giảm giá               |
| **Actor chính**          | Khách thành viên                   |
| **Mục đích**             | Áp dụng mã giảm giá vào đơn hàng   |
| **Điều kiện tiên quyết** | Có mã giảm giá hợp lệ              |
| **Điều kiện hậu quyết**  | Mã được áp dụng, giá được cập nhật |

**Luồng chính:**

1. Người dùng nhập mã giảm giá
2. Hệ thống kiểm tra tính hợp lệ
3. Nếu hợp lệ: tính giảm giá, cập nhật tổng tiền
4. Hiển thị kết quả

**Luồng ngoại lệ:**

-   Mã không hợp lệ: Hiển thị thông báo lỗi

---

## USE CASE 49: Phê Duyệt Đánh Giá

| Thuộc tính               | Giá trị                           |
| ------------------------ | --------------------------------- |
| **ID**                   | UC-049                            |
| **Tên**                  | Phê duyệt đánh giá                |
| **Actor chính**          | Quản trị                          |
| **Mục đích**             | Phê duyệt đánh giá của khách hàng |
| **Điều kiện tiên quyết** | Đánh giá chờ phê duyệt            |
| **Điều kiện hậu quyết**  | Đánh giá được xuất bản            |

**Luồng chính:**

1. Admin xem danh sách đánh giá chờ phê duyệt
2. Xem nội dung đánh giá
3. Nhấn "Phê duyệt"
4. Đánh giá được hiển thị công khai

---

## TÓMO TẮT CÁC USE CASE CHÍNH

| UC     | Tên                    | Actor    | Mô Tả Ngắn                 |
| ------ | ---------------------- | -------- | -------------------------- |
| UC-001 | Xem danh sách sản phẩm | All      | Hiển thị tất cả sản phẩm   |
| UC-004 | Đăng ký                | Guest    | Tạo tài khoản mới          |
| UC-005 | Tìm kiếm/Lọc           | All      | Tìm sản phẩm theo tiêu chí |
| UC-006 | Thêm vào giỏ           | Customer | Thêm sản phẩm vào giỏ      |
| UC-007 | Đặt mua                | Customer | Tạo đơn hàng               |
| UC-008 | Thanh toán             | Customer | Xử lý thanh toán           |
| UC-010 | Quản lý sản phẩm       | Admin    | CRUD sản phẩm              |
| UC-017 | Đăng nhập              | Guest    | Xác thực người dùng        |
| UC-020 | Yêu thích              | Customer | Lưu sản phẩm yêu thích     |
| UC-026 | Đánh giá               | Customer | Đánh giá sản phẩm          |

---

## GHI CHÚ

-   Tất cả use case đều có xử lý ngoại lệ và thông báo lỗi
-   Actor "All" = Guest + Customer + Admin
-   Các use case CRUD (34-59) có cấu trúc: Tạo, Sửa, Xóa
