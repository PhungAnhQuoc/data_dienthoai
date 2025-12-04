# ĐẶC TẢ USE CASE CHÍNH - MOBILE SHOP

---

## USE CASE 2.2.1: Đăng Ký

**Tóm tắt:** Khách hàng viếng thăm sử dụng use case "Đăng ký" để tạo tài khoản cho mình trên website

**Actor:** Khách hàng viếng thăm

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Trước khi bắt đầu thực hiện Use-case không cần điều kiện gì

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                               |
| ---- | --------------------------------------------------------------------------------------------------------------------- |
| B1   | Trên giao diện màn hình chính, khách hàng viếng thăm chọn đăng ký                                                     |
| B2   | Hệ thống sẽ hiển thị giao diện đăng ký và khách hàng viếng thăm nhập thông tin vào giao diện để lưu vào cơ sở dữ liệu |
| B3   | Kết thúc Use case                                                                                                     |

**Trạng thái hệ thống sau khi thực hiện Use-case:**

-   **Thành công:** Hệ thống sẽ đưa khách hàng tới trang người dùng
-   **Lỗi:** Hệ thống hiển thị thông báo lỗi tương ứng (ví dụ: email đã tồn tại, mật khẩu không hợp lệ, thông tin thiếu...). Người dùng được yêu cầu nhập lại thông tin cho đúng

**Điểm mở rộng:** Không có

---

## USE CASE 2.2.2: Thêm Giỏ Hàng

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Thêm giỏ hàng" để đặt những sản phẩm mình cần mua vào không gian lưu trữ tạm thời trên web

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Sau khi khách hàng xem danh sách sản phẩm hoặc chi tiết sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                        |
| ---- | ---------------------------------------------------------------------------------------------- |
| B1   | Trên giao diện màn hình chính hoặc màn hình chi tiết sản phẩm, khách hàng chọn "Thêm giỏ hàng" |
| B2   | Hệ thống sẽ lưu trữ thông tin sản phẩm mà khách hàng muốn đưa vào giỏ                          |
| B3   | Kết thúc Use case                                                                              |

**Trạng thái hệ thống sau khi thực hiện Use-case:**
Sau khi thực hiện Use-case hệ thống sẽ xuất thông tin của sản phẩm ra giao diện giỏ hàng

**Điểm mở rộng:**
Tại giao diện giỏ hàng sẽ có các chức năng:

-   Cập nhật số lượng cho sản phẩm đã đặt
-   Xóa 1 hoặc nhiều sản phẩm

---

## USE CASE 2.2.3: Đăng Nhập

**Tóm tắt:** Khách hàng viếng thăm sử dụng use case "Đăng nhập" để tham gia mua hàng trực tuyến

**Actor:** Khách hàng viếng thăm

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Trước khi thực hiện Use-case yêu cầu khách hàng phải đăng ký

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                                      |
| ---- | ---------------------------------------------------------------------------------------------------------------------------- |
| B1   | Trên giao diện màn hình chính khách hàng chọn "Đăng nhập"                                                                    |
| B2   | Hệ thống sẽ hiển thị giao diện đăng nhập và khách hàng nhập thông tin vào giao diện để kiểm tra xem tài khoản đã có hay chưa |
| B3   | Kết thúc Use case                                                                                                            |

**Trạng thái hệ thống sau khi thực hiện Use-case:**
Sau khi thực hiện Use-case hệ thống sẽ đưa vào trang người dùng hiển thị tài khoản người dùng

**Điểm mở rộng:**
Khách hàng thành viên có thể chọn đăng xuất bất cứ khi nào (yêu cầu trước đó là đã đăng nhập thành công)

---

## USE CASE 2: Đăng Nhập

**Tóm tắt:** Khách hàng viếng thăm đăng nhập vào tài khoản

**Actor:** Khách hàng viếng thăm

**Điều kiện tiên quyết:** Tài khoản đã tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                   |
| ---- | --------------------------------------------------------- |
| B1   | Khách hàng chọn "Đăng nhập"                               |
| B2   | Hệ thống hiển thị form, khách hàng nhập email và mật khẩu |
| B3   | Hệ thống xác thực thông tin                               |
| B4   | Đăng nhập thành công, tạo session                         |

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Chuyển hướng tới trang chủ, người dùng là "Khách hàng thành viên"
-   **Lỗi:** Hiển thị thông báo "Email hoặc mật khẩu sai"

**Luồng ngoại lệ:**

-   Email/mật khẩu sai → Yêu cầu nhập lại
-   Tài khoản bị khóa → Thông báo tài khoản bị khóa

---

---

## USE CASE 2.2.4: Đặt Mua

**Tóm tắt:** Khách hàng thành viên sử dụng use case "đặt mua" để tham gia mua hàng trực tuyến

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:**

-   Trước khi thực hiện Use-case yêu cầu khách hàng phải đăng nhập hệ thống
-   Trong giỏ hàng phải có tối thiểu 1 sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                                                                                 |
| ---- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| B1   | Trên giao diện giỏ hàng, khách hàng chọn "Đặt mua"                                                                                                                      |
| B2   | Hệ thống sẽ hiển thị giao diện chứa thông tin khách hàng và danh sách các sản phẩm mà khách hàng đặt mua. Sau khi nhập đầy đủ thông tin thì khách hàng xác nhận đặt mua |
| B3   | Kết thúc Use case                                                                                                                                                       |

**Trạng thái hệ thống sau khi thực hiện Use-case:**
Sau khi thực hiện Use-case hệ thống sẽ thông báo đặt hàng thành công hay chưa

**Điểm mở rộng:**
Khách hàng thành viên có thể chọn đăng xuất bất cứ khi nào (yêu cầu trước đó là đã đăng nhập thành công)

---

## USE CASE 2.2.5: Tra Cứu Đơn Hàng

**Tóm tắt:** Use case mô tả quá trình khách hàng nhập mã đơn hàng theo email đặt hàng để xem tình trạng đơn bao gồm: Mã đơn hàng, thông tin giao hàng, thông tin thanh toán, tổng tiền, trạng thái giao hàng, ngày đặt, các thông tin liên quan

**Actor:** Khách hàng thành viên, Quản trị

**Trạng thái hệ thống bắt đầu thực hiện Use-Case:**
Hệ thống hoạt động bình thường, dữ liệu đơn hàng đã có trong database (phải tồn tại để tra cứu). Người dùng truy cập giao diện tra cứu

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                                   |
| ---- | ------------------------------------------------------------------------------------------------------------------------- |
| B1   | Actor truy cập vào trang "Tra cứu đơn hàng"                                                                               |
| B2   | Hệ thống hiển thị ô nhập thông tin (mã đơn hàng, email của người đặt hàng)                                                |
| B3   | Actor nhập mã đơn hàng rồi tra cứu                                                                                        |
| B4   | Hệ thống kiểm tra và hiển thị kết quả: thông tin đơn hàng, danh sách sản phẩm, tổng giá trị đơn hàng, trạng thái đơn hàng |

**Trạng thái hệ thống sau khi thực hiện Use-case:**

-   **Nếu tra cứu thành công:** Hệ thống hiển thị đầy đủ thông tin đơn hàng:
    -   Mã đơn hàng
    -   Thông tin giao hàng
    -   Thông tin thanh toán
    -   Tổng tiền
    -   Trạng thái giao hàng
    -   Ngày đặt
    -   Danh sách sản phẩm
-   **Nếu tra cứu thất bại:** Hiển thị thông báo: "Không tìm thấy đơn hàng. Vui lòng kiểm tra mã đơn và email"

---

**Tóm tắt:** Khách hàng xem danh sách sản phẩm và tìm kiếm theo tiêu chí

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên, Quản trị

**Điều kiện tiên quyết:** Ứng dụng đang hoạt động, có sản phẩm trong hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                    |
| ---- | -------------------------------------------------------------------------- |
| B1   | Khách hàng truy cập trang "Sản phẩm" hoặc sử dụng tìm kiếm                 |
| B2   | Nhập từ khóa tìm kiếm hoặc chọn bộ lọc (danh mục, thương hiệu, khoảng giá) |
| B3   | Hệ thống xử lý tìm kiếm/lọc từ database                                    |
| B4   | Hiển thị danh sách sản phẩm phù hợp với phân trang                         |
| B5   | Khách hàng xem kết quả                                                     |

**Thông tin hiển thị:**

-   Hình ảnh, tên sản phẩm, giá, đánh giá, hàng tồn kho

**Các bộ lọc:**

-   Theo danh mục
-   Theo thương hiệu
-   Theo khoảng giá (từ - đến)
-   Theo đánh giá (sao)

**Trạng thái hệ thống sau khi thực hiện:**

-   Danh sách sản phẩm phù hợp được hiển thị

**Luồng ngoại lệ:**

-   Không có kết quả → Hiển thị "Không tìm thấy sản phẩm"

---

## USE CASE 4: Xem Chi Tiết Sản Phẩm

**Tóm tắt:** Khách hàng xem thông tin chi tiết một sản phẩm

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên, Quản trị

**Điều kiện tiên quyết:** Sản phẩm tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                     |
| ---- | ----------------------------------------------------------- |
| B1   | Khách hàng chọn một sản phẩm                                |
| B2   | Hệ thống tải chi tiết sản phẩm                              |
| B3   | Hiển thị: tên, giá, mô tả, hình ảnh, đánh giá, hàng tồn kho |
| B4   | Khách hàng xem thông tin                                    |

**Thông tin hiển thị:**

-   Hình ảnh (có thể xem nhiều ảnh)
-   Tên, giá tiền, giá gốc (nếu có)
-   Mô tả chi tiết
-   Danh mục, thương hiệu
-   Đánh giá trung bình, số lượt đánh giá
-   Hàng tồn kho
-   Nút "Thêm vào giỏ", "Yêu thích"

**Trạng thái hệ thống sau khi thực hiện:**

-   Chi tiết sản phẩm được hiển thị đầy đủ

---

## USE CASE 5: Thêm Vào Giỏ Hàng & Thanh Toán

**Tóm tắt:** Khách hàng thêm sản phẩm vào giỏ và tiến hành thanh toán

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Sản phẩm có sẵn trong kho

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                      |
| ---- | ---------------------------------------------------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm, nhập số lượng                              |
| B2   | Nhấn "Thêm vào giỏ hàng"                                                     |
| B3   | Hệ thống kiểm tra hàng tồn kho và thêm vào giỏ                               |
| B4   | Khách hàng xem giỏ hàng                                                      |
| B5   | Nhấn "Thanh toán"                                                            |
| B6   | Hệ thống hiển thị form đặt hàng                                              |
| B7   | Khách hàng xác nhận thông tin giao hàng (tên, email, số điện thoại, địa chỉ) |
| B8   | Chọn phương thức thanh toán (COD, chuyển khoản, ví điện tử)                  |
| B9   | Xác nhận đơn hàng                                                            |
| B10  | Hệ thống xử lý thanh toán, tạo đơn hàng                                      |
| B11  | Thanh toán thành công, gửi email xác nhận                                    |

**Thông tin nhập liệu:**

-   Số lượng sản phẩm
-   Tên giao hàng, số điện thoại, địa chỉ
-   Phương thức thanh toán
-   Ghi chú (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Đơn hàng được tạo, thanh toán hoàn tất
-   **Lỗi:** Thông báo lỗi, yêu cầu thử lại

**Luồng ngoại lệ:**

-   Hàng không đủ → Thông báo "Chỉ còn X sản phẩm"
-   Thông tin thiếu → Yêu cầu điền đầy đủ
-   Thanh toán thất bại → Cho phép thử lại

---

## USE CASE 6: Xem Lịch Sử Đơn Hàng & Đánh Giá

**Tóm tắt:** Khách hàng xem lịch sử đơn hàng và đánh giá sản phẩm đã mua

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:** Khách hàng đã đăng nhập

**Các dòng sự kiện chính (Xem lịch sử):**

| Bước | Diễn Tả                               |
| ---- | ------------------------------------- |
| B1   | Khách hàng vào tài khoản cá nhân      |
| B2   | Chọn tab "Lịch sử đơn hàng"           |
| B3   | Hệ thống hiển thị danh sách đơn hàng  |
| B4   | Khách hàng xem chi tiết từng đơn hàng |

**Thông tin hiển thị:**

-   Mã đơn hàng, ngày đặt, tổng tiền
-   Trạng thái (Chờ xác nhận, Đang giao, Đã giao, Hủy)
-   Nút "Xem chi tiết", "Hủy đơn"

**Các dòng sự kiện chính (Đánh giá):**

| Bước | Diễn Tả                                |
| ---- | -------------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm       |
| B2   | Cuộn xuống, chọn "Viết đánh giá"       |
| B3   | Nhập số sao (1-5) và nội dung đánh giá |
| B4   | Nhấn "Gửi đánh giá"                    |
| B5   | Hệ thống lưu đánh giá (chờ phê duyệt)  |

**Thông tin nhập liệu (Đánh giá):**

-   Số sao (1-5)
-   Nội dung đánh giá (tối thiểu 10 ký tự)
-   Hình ảnh (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện:**

-   Danh sách đơn hàng được hiển thị
-   Đánh giá được lưu, chờ phê duyệt

**Luồng ngoại lệ:**

-   Nội dung đánh giá quá ngắn → Yêu cầu nhập chi tiết hơn
-   Nội dung không hợp lệ → Yêu cầu sửa

---

## USE CASE 7: Quản Lý Sản Phẩm (Admin)

**Tóm tắt:** Quản trị viên thêm/sửa/xóa sản phẩm

**Actor:** Quản trị

**Điều kiện tiên quyết:** Admin đã đăng nhập

**Các dòng sự kiện chính:**

| Bước      | Diễn Tả                                                                                          |
| --------- | ------------------------------------------------------------------------------------------------ |
| B1        | Admin vào "Quản lý sản phẩm"                                                                     |
| B2a (Tạo) | Chọn "Thêm sản phẩm mới"                                                                         |
| B2b (Sửa) | Chọn sản phẩm cần sửa                                                                            |
| B2c (Xóa) | Chọn sản phẩm cần xóa                                                                            |
| B3        | Nhập/cập nhật thông tin: tên, giá, giá gốc, mô tả, hình ảnh, danh mục, thương hiệu, hàng tồn kho |
| B4        | Lưu hoặc xóa sản phẩm                                                                            |
| B5        | Hiển thị thông báo thành công/lỗi                                                                |

**Thông tin nhập liệu:**

-   Tên sản phẩm
-   Giá tiền, giá gốc
-   Mô tả
-   Hình ảnh (chọn/tải lên)
-   Danh mục
-   Thương hiệu
-   Hàng tồn kho
-   Trạng thái (Hoạt động/Tạm ẩn)

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Sản phẩm được tạo/sửa/xóa
-   **Lỗi:** Thông báo lỗi

---

## USE CASE 8: Quản Lý Đơn Hàng & Đánh Giá (Admin)

**Tóm tắt:** Quản trị viên xem và cập nhật trạng thái đơn hàng, phê duyệt/từ chối đánh giá

**Actor:** Quản trị

**Điều kiện tiên quyết:** Admin đã đăng nhập

**Các dòng sự kiện chính (Quản lý đơn hàng):**

| Bước | Diễn Tả                                                 |
| ---- | ------------------------------------------------------- |
| B1   | Admin vào "Quản lý đơn hàng"                            |
| B2   | Hệ thống hiển thị danh sách đơn hàng                    |
| B3   | Admin chọn đơn hàng để xem chi tiết                     |
| B4   | Xem thông tin: khách, sản phẩm, tổng tiền, địa chỉ giao |
| B5   | Cập nhật trạng thái: Chờ xác nhận → Đang giao → Đã giao |
| B6   | Lưu thay đổi, gửi email thông báo khách                 |

**Các dòng sự kiện chính (Phê duyệt đánh giá):**

| Bước | Diễn Tả                              |
| ---- | ------------------------------------ |
| B1   | Admin vào "Quản lý đánh giá"         |
| B2   | Xem danh sách đánh giá chờ phê duyệt |
| B3   | Chọn đánh giá để xem chi tiết        |
| B4   | Phê duyệt hoặc từ chối               |
| B5   | Lưu quyết định, hiển thị thông báo   |

**Trạng thái hệ thống sau khi thực hiện:**

-   Trạng thái đơn hàng được cập nhật, khách hàng nhận email
-   Đánh giá được xuất bản hoặc ẩn

---

## USE CASE 9: Yêu Thích

**Tóm tắt:** Khách hàng lưu sản phẩm yêu thích

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Sản phẩm tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                       |
| ---- | --------------------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm              |
| B2   | Nhấn nút "Yêu thích" (trái tim)               |
| B3   | Hệ thống lưu sản phẩm vào danh sách yêu thích |
| B4   | Hiển thị thông báo thành công                 |
| B5   | Nút "Yêu thích" chuyển sang màu đỏ            |

**Trạng thái hệ thống sau khi thực hiện:**

-   Sản phẩm được thêm vào danh sách yêu thích

---

## USE CASE 10: Kiểm Tra Mã Giảm Giá

**Tóm tắt:** Khách hàng áp dụng mã giảm giá vào đơn hàng

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:** Có mã giảm giá hợp lệ, giỏ hàng có sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                       |
| ---- | --------------------------------------------- |
| B1   | Khách hàng ở trang thanh toán                 |
| B2   | Nhập mã giảm giá                              |
| B3   | Hệ thống kiểm tra tính hợp lệ của mã          |
| B4   | Nếu hợp lệ: tính giảm giá, cập nhật tổng tiền |
| B5   | Hiển thị kết quả (số tiền giảm, tổng mới)     |

**Thông tin nhập liệu:**

-   Mã giảm giá

**Trạng thái hệ thống sau khi thực hiện:**

-   **Hợp lệ:** Mã được áp dụng, giá được cập nhật
-   **Không hợp lệ:** Thông báo lỗi

**Luồng ngoại lệ:**

-   Mã không tồn tại → Thông báo "Mã không hợp lệ"
-   Mã hết hạn → Thông báo "Mã đã hết hạn"
-   Không đủ điều kiện dùng mã → Thông báo điều kiện cần thiết

---

## TÓMO TẮT 10 USE CASE CHÍNH

| UC  | Tên                       | Actor    | Mục Đích                |
| --- | ------------------------- | -------- | ----------------------- |
| 1   | Đăng ký                   | Guest    | Tạo tài khoản           |
| 2   | Đăng nhập                 | Guest    | Xác thực người dùng     |
| 3   | Xem & Tìm kiếm sản phẩm   | All      | Hiển thị & tìm sản phẩm |
| 4   | Xem chi tiết sản phẩm     | All      | Xem thông tin chi tiết  |
| 5   | Thêm vào giỏ & Thanh toán | Customer | Mua hàng                |
| 6   | Lịch sử đơn & Đánh giá    | Customer | Quản lý đơn & đánh giá  |
| 7   | Quản lý sản phẩm          | Admin    | CRUD sản phẩm           |
| 8   | Quản lý đơn & Đánh giá    | Admin    | Xem & duyệt             |
| 9   | Yêu thích                 | Customer | Lưu sản phẩm yêu thích  |
| 10  | Kiểm tra mã giảm giá      | Customer | Áp dụng mã khuyến mãi   |

---

**Ghi chú:**

-   All = Guest + Customer + Admin
-   Guest = Khách viếng thăm
-   Customer = Khách hàng thành viên
-   Admin = Quản trị viên

**Tóm tắt:** Khách hàng viếng thăm tạo tài khoản mới trên website

**Actor:** Khách hàng viếng thăm

**Điều kiện tiên quyết:** Không cần điều kiện gì

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                                                 |
| ---- | ------------------------------------------------------------------------------------------------------- |
| B1   | Khách hàng viếng thăm chọn "Đăng ký" trên giao diện chính                                               |
| B2   | Hệ thống hiển thị form đăng ký, khách hàng nhập thông tin: email, mật khẩu, tên, số điện thoại, địa chỉ |
| B3   | Hệ thống xác thực và lưu thông tin vào cơ sở dữ liệu                                                    |
| B4   | Tài khoản được tạo thành công                                                                           |

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Hệ thống đưa khách hàng tới trang chủ, tài khoản được tạo
-   **Lỗi:** Hiển thị thông báo lỗi (email đã tồn tại, mật khẩu không hợp lệ, thông tin thiếu)

**Luồng ngoại lệ:**

-   Email đã tồn tại → Yêu cầu nhập email khác
-   Mật khẩu < 8 ký tự → Yêu cầu mật khẩu dài hơn
-   Thông tin thiếu → Yêu cầu điền đầy đủ

---

## USE CASE 2: Đăng Nhập

**Tóm tắt:** Khách hàng viếng thăm đăng nhập vào tài khoản

**Actor:** Khách hàng viếng thăm

**Điều kiện tiên quyết:** Tài khoản đã tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                   |
| ---- | --------------------------------------------------------- |
| B1   | Khách hàng chọn "Đăng nhập"                               |
| B2   | Hệ thống hiển thị form, khách hàng nhập email và mật khẩu |
| B3   | Hệ thống xác thực thông tin                               |
| B4   | Đăng nhập thành công, tạo session                         |

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Chuyển hướng tới trang chủ, người dùng là "Khách hàng thành viên"
-   **Lỗi:** Hiển thị thông báo "Email hoặc mật khẩu sai"

**Luồng ngoại lệ:**

-   Email/mật khẩu sai → Yêu cầu nhập lại
-   Tài khoản bị khóa → Thông báo tài khoản bị khóa

---

## USE CASE 3: Xem Danh Sách Sản Phẩm

**Tóm tắt:** Khách hàng xem danh sách tất cả sản phẩm có sẵn

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên, Quản trị

**Điều kiện tiên quyết:** Ứng dụng đang hoạt động

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                              |
| ---- | ---------------------------------------------------- |
| B1   | Khách hàng truy cập trang "Sản phẩm"                 |
| B2   | Hệ thống tải danh sách sản phẩm từ database          |
| B3   | Hiển thị sản phẩm với phân trang (20 sản phẩm/trang) |
| B4   | Khách hàng có thể cuộn hoặc chọn trang khác          |

**Thông tin hiển thị:**

-   Hình ảnh, tên sản phẩm, giá, đánh giá, hàng tồn kho

**Trạng thái hệ thống sau khi thực hiện:**

-   Danh sách sản phẩm được hiển thị thành công

---

## USE CASE 4: Tìm Kiếm, Lọc Sản Phẩm

**Tóm tắt:** Khách hàng tìm kiếm sản phẩm theo tiêu chí

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên, Quản trị

**Điều kiện tiên quyết:** Có sản phẩm trong hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                   |
| ---- | --------------------------------------------------------- |
| B1   | Khách hàng nhập từ khóa tìm kiếm hoặc chọn bộ lọc         |
| B2   | Hệ thống lọc theo: tên, danh mục, thương hiệu, khoảng giá |
| B3   | Hiển thị kết quả phù hợp                                  |
| B4   | Khách hàng xem kết quả                                    |

**Các bộ lọc:**

-   Theo danh mục
-   Theo thương hiệu
-   Theo khoảng giá (từ - đến)
-   Theo đánh giá (sao)

**Trạng thái hệ thống sau khi thực hiện:**

-   Danh sách sản phẩm phù hợp được hiển thị

**Luồng ngoại lệ:**

-   Không có kết quả → Hiển thị "Không tìm thấy sản phẩm"

---

## USE CASE 5: Xem Chi Tiết Sản Phẩm

**Tóm tắt:** Khách hàng xem thông tin chi tiết một sản phẩm

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên, Quản trị

**Điều kiện tiên quyết:** Sản phẩm tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                     |
| ---- | ----------------------------------------------------------- |
| B1   | Khách hàng chọn một sản phẩm                                |
| B2   | Hệ thống tải chi tiết sản phẩm                              |
| B3   | Hiển thị: tên, giá, mô tả, hình ảnh, đánh giá, hàng tồn kho |
| B4   | Khách hàng xem thông tin                                    |

**Thông tin hiển thị:**

-   Hình ảnh (có thể xem nhiều ảnh)
-   Tên, giá tiền, giá gốc (nếu có)
-   Mô tả chi tiết
-   Danh mục, thương hiệu
-   Đánh giá trung bình, số lượt đánh giá
-   Hàng tồn kho
-   Nút "Thêm vào giỏ", "Yêu thích"

**Trạng thái hệ thống sau khi thực hiện:**

-   Chi tiết sản phẩm được hiển thị đầy đủ

---

## USE CASE 6: Thêm Sản Phẩm Vào Giỏ Hàng

**Tóm tắt:** Khách hàng thêm sản phẩm vào giỏ hàng

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Sản phẩm có sẵn trong kho

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                          |
| ---- | -------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm |
| B2   | Nhập số lượng muốn mua           |
| B3   | Nhấn nút "Thêm vào giỏ hàng"     |
| B4   | Hệ thống kiểm tra hàng tồn kho   |
| B5   | Thêm sản phẩm vào giỏ hàng       |
| B6   | Hiển thị thông báo thành công    |

**Thông tin nhập liệu:**

-   Số lượng (phải > 0)

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Sản phẩm được thêm, giỏ hàng cập nhật
-   **Lỗi:** Hiển thị thông báo lỗi

**Luồng ngoại lệ:**

-   Hàng không đủ → Thông báo "Hàng không đủ, chỉ còn X sản phẩm"
-   Số lượng <= 0 → Yêu cầu nhập số lượng hợp lệ

---

## USE CASE 7: Xem Giỏ Hàng

**Tóm tắt:** Khách hàng xem các sản phẩm trong giỏ hàng

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:** Khách hàng đã đăng nhập

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                        |
| ---- | ---------------------------------------------- |
| B1   | Khách hàng chọn "Giỏ hàng"                     |
| B2   | Hệ thống hiển thị danh sách sản phẩm trong giỏ |
| B3   | Hiển thị: tên, giá, số lượng, tổng tiền        |
| B4   | Khách hàng có thể sửa số lượng, xóa sản phẩm   |

**Thông tin hiển thị:**

-   Danh sách sản phẩm với: tên, hình, giá, số lượng, tổng
-   Tổng cộng giỏ hàng
-   Nút "Thanh toán", "Tiếp tục mua sắm"

**Trạng thái hệ thống sau khi thực hiện:**

-   Giỏ hàng được hiển thị

**Luồng ngoại lệ:**

-   Giỏ trống → Hiển thị "Giỏ hàng của bạn trống"

---

## USE CASE 8: Đặt Mua

**Tóm tắt:** Khách hàng tạo đơn hàng từ giỏ hàng

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Giỏ hàng có sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                                         |
| ---- | ------------------------------------------------------------------------------- |
| B1   | Khách hàng xem giỏ hàng và nhấn "Thanh toán"                                    |
| B2   | Hệ thống hiển thị form đặt hàng                                                 |
| B3   | Khách hàng xác nhận/sửa thông tin giao hàng: tên, email, số điện thoại, địa chỉ |
| B4   | Chọn phương thức thanh toán                                                     |
| B5   | Xác nhận đơn hàng                                                               |
| B6   | Hệ thống tạo đơn hàng                                                           |
| B7   | Chuyển sang trang thanh toán                                                    |

**Thông tin nhập liệu:**

-   Tên giao hàng
-   Số điện thoại
-   Địa chỉ giao hàng
-   Phương thức thanh toán (COD, chuyển khoản, ví điện tử)
-   Ghi chú (tùy chọn)

**Trạng thái hệ thViewModel:**

-   **Thành công:** Đơn hàng được tạo, chuyển sang thanh toán
-   **Lỗi:** Thông báo lỗi, yêu cầu nhập lại

**Luồng ngoại lệ:**

-   Thông tin thiếu → Yêu cầu điền đầy đủ
-   Địa chỉ không hợp lệ → Yêu cầu nhập lại

---

## USE CASE 9: Thanh Toán

**Tóm tắt:** Khách hàng thanh toán đơn hàng

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:** Đơn hàng được tạo

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                        |
| ---- | -------------------------------------------------------------- |
| B1   | Khách hàng ở trang thanh toán                                  |
| B2   | Hệ thống hiển thị thông tin đơn hàng và phương thức thanh toán |
| B3   | Khách hàng chọn phương thức thanh toán                         |
| B4   | Hệ thống xử lý thanh toán                                      |
| B5   | Thanh toán thành công                                          |
| B6   | Gửi email xác nhận, chuyển sang trang thành công               |

**Phương thức thanh toán:**

-   COD (Trả tiền khi nhận)
-   Chuyển khoản ngân hàng
-   Ví điện tử (Momo, Zalopay, ...)

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Đơn hàng được xác nhận, gửi email
-   **Lỗi:** Thông báo lỗi, cho phép thử lại

**Luồng ngoại lệ:**

-   Thanh toán thất bại → Yêu cầu thử lại
-   Timeout → Yêu cầu thử lại

---

## USE CASE 10: Xem Lịch Sử Đơn Hàng

**Tóm tắt:** Khách hàng xem danh sách đơn hàng của mình

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:** Khách hàng đã đăng nhập

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                               |
| ---- | ------------------------------------- |
| B1   | Khách hàng vào tài khoản cá nhân      |
| B2   | Chọn tab "Lịch sử đơn hàng"           |
| B3   | Hệ thống hiển thị danh sách đơn hàng  |
| B4   | Khách hàng xem chi tiết từng đơn hàng |

**Thông tin hiển thị:**

-   Mã đơn hàng, ngày đặt, tổng tiền
-   Trạng thái (Chờ xác nhận, Đang giao, Đã giao, Hủy)
-   Nút "Xem chi tiết", "Hủy đơn"

**Trạng thái hệ thống sau khi thực hiện:**

-   Danh sách đơn hàng được hiển thị

---

## USE CASE 11: Quản Lý Sản Phẩm (Admin)

**Tóm tắt:** Quản trị viên thêm/sửa/xóa sản phẩm

**Actor:** Quản trị

**Điều kiện tiên quyết:** Admin đã đăng nhập

**Các dòng sự kiện chính (Tạo):**

| Bước | Diễn Tả                                                                                 |
| ---- | --------------------------------------------------------------------------------------- |
| B1   | Admin vào "Quản lý sản phẩm"                                                            |
| B2   | Chọn "Thêm sản phẩm mới"                                                                |
| B3   | Nhập thông tin: tên, giá, giá gốc, mô tả, hình ảnh, danh mục, thương hiệu, hàng tồn kho |
| B4   | Lưu sản phẩm                                                                            |
| B5   | Hiển thị thông báo thành công                                                           |

**Các dòng sự kiện chính (Sửa):**

| Bước | Diễn Tả                      |
| ---- | ---------------------------- |
| B1   | Admin vào "Quản lý sản phẩm" |
| B2   | Chọn sản phẩm cần sửa        |
| B3   | Cập nhật thông tin           |
| B4   | Lưu thay đổi                 |

**Các dòng sự kiện chính (Xóa):**

| Bước | Diễn Tả                     |
| ---- | --------------------------- |
| B1   | Admin chọn sản phẩm cần xóa |
| B2   | Nhấn "Xóa"                  |
| B3   | Xác nhận xóa                |
| B4   | Sản phẩm được xóa           |

**Thông tin nhập liệu:**

-   Tên sản phẩm
-   Giá tiền, giá gốc
-   Mô tả
-   Hình ảnh (chọn/tải lên)
-   Danh mục
-   Thương hiệu
-   Hàng tồn kho

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Sản phẩm được tạo/sửa/xóa
-   **Lỗi:** Thông báo lỗi

---

## USE CASE 12: Quản Lý Đơn Hàng (Admin)

**Tóm tắt:** Quản trị viên xem và cập nhật trạng thái đơn hàng

**Actor:** Quản trị

**Điều kiện tiên quyết:** Admin đã đăng nhập

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                                              |
| ---- | -------------------------------------------------------------------- |
| B1   | Admin vào "Quản lý đơn hàng"                                         |
| B2   | Hệ thống hiển thị danh sách đơn hàng                                 |
| B3   | Admin chọn đơn hàng để xem chi tiết                                  |
| B4   | Xem thông tin đơn hàng (khách, sản phẩm, tổng tiền)                  |
| B5   | Cập nhật trạng thái: Chờ xác nhận → Đang giao → Đã giao → Hoàn thành |
| B6   | Lưu thay đổi                                                         |

**Thông tin hiển thị:**

-   Mã đơn hàng, khách hàng, ngày đặt
-   Danh sách sản phẩm, tổng tiền
-   Trạng thái hiện tại
-   Địa chỉ giao hàng
-   Phương thức thanh toán

**Trạng thái hệ thống sau khi thực hiện:**

-   Trạng thái đơn hàng được cập nhật, gửi email thông báo khách

---

## USE CASE 13: Đánh Giá Sản Phẩm

**Tóm tắt:** Khách hàng đánh giá sản phẩm đã mua

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Đã mua sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                |
| ---- | -------------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm       |
| B2   | Cuộn xuống, chọn "Viết đánh giá"       |
| B3   | Nhập số sao (1-5) và nội dung đánh giá |
| B4   | Nhấn "Gửi đánh giá"                    |
| B5   | Hệ thống lưu đánh giá (chờ phê duyệt)  |

**Thông tin nhập liệu:**

-   Số sao (1-5)
-   Nội dung đánh giá (tối thiểu 10 ký tự)
-   Hình ảnh (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện:**

-   **Thành công:** Đánh giá được lưu, chờ phê duyệt
-   **Lỗi:** Thông báo lỗi

**Luồng ngoại lệ:**

-   Nội dung quá ngắn → Yêu cầu nhập chi tiết hơn
-   Nội dung không hợp lệ → Yêu cầu sửa

---

## USE CASE 14: Phê Duyệt Đánh Giá (Admin)

**Tóm tắt:** Quản trị viên phê duyệt/từ chối đánh giá

**Actor:** Quản trị

**Điều kiện tiên quyết:** Admin đã đăng nhập, có đánh giá chờ phê duyệt

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                              |
| ---- | ------------------------------------ |
| B1   | Admin vào "Quản lý đánh giá"         |
| B2   | Xem danh sách đánh giá chờ phê duyệt |
| B3   | Chọn đánh giá để xem chi tiết        |
| B4   | Phê duyệt hoặc từ chối               |
| B5   | Lưu quyết định                       |

**Thông tin hiển thị:**

-   Khách hàng, sản phẩm, ngày đánh giá
-   Số sao, nội dung
-   Nút "Phê duyệt", "Từ chối"

**Trạng thái hệ thViewModel:**

-   **Phê duyệt:** Đánh giá hiển thị công khai
-   **Từ chối:** Đánh giá bị ẩn, gửi email thông báo khách

---

## USE CASE 15: Yêu Thích

**Tóm tắt:** Khách hàng lưu sản phẩm yêu thích

**Actor:** Khách hàng thành viên

**Điều kiện tiên quyết:**

-   Khách hàng đã đăng nhập
-   Sản phẩm tồn tại

**Các dòng sự kiện chính:**

| Bước | Diễn Tả                                       |
| ---- | --------------------------------------------- |
| B1   | Khách hàng xem chi tiết sản phẩm              |
| B2   | Nhấn nút "Yêu thích" (trái tim)               |
| B3   | Hệ thống lưu sản phẩm vào danh sách yêu thích |
| B4   | Hiển thị thông báo thành công                 |

**Trạng thái hệ thống sau khi thực hiện:**

-   Sản phẩm được thêm vào danh sách yêu thích
-   Nút "Yêu thích" chuyển sang màu đỏ để chỉ đã thêm

---

## TÓMO TẮT CÁC USE CASE CHÍNH

| UC  | Tên                    | Actor    | Mục Đích               |
| --- | ---------------------- | -------- | ---------------------- |
| 1   | Đăng ký                | Guest    | Tạo tài khoản          |
| 2   | Đăng nhập              | Guest    | Xác thực người dùng    |
| 3   | Xem danh sách sản phẩm | All      | Hiển thị sản phẩm      |
| 4   | Tìm kiếm/Lọc           | All      | Tìm sản phẩm           |
| 5   | Xem chi tiết sản phẩm  | All      | Xem thông tin chi tiết |
| 6   | Thêm vào giỏ hàng      | Customer | Thêm sản phẩm vào giỏ  |
| 7   | Xem giỏ hàng           | Customer | Xem danh sách giỏ      |
| 8   | Đặt mua                | Customer | Tạo đơn hàng           |
| 9   | Thanh toán             | Customer | Xử lý thanh toán       |
| 10  | Xem lịch sử đơn hàng   | Customer | Xem đơn hàng của mình  |
| 11  | Quản lý sản phẩm       | Admin    | CRUD sản phẩm          |
| 12  | Quản lý đơn hàng       | Admin    | Xem & cập nhật đơn     |
| 13  | Đánh giá sản phẩm      | Customer | Đánh giá sản phẩm      |
| 14  | Phê duyệt đánh giá     | Admin    | Duyệt/từ chối đánh giá |
| 15  | Yêu thích              | Customer | Lưu sản phẩm yêu thích |

---

**Ghi chú:**

-   All = Guest + Customer + Admin
-   Guest = Khách viếng thăm
-   Customer = Khách hàng thành viên
-   Admin = Quản trị viên
