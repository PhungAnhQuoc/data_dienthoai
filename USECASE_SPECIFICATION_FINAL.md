# ĐẶC TẢ USE CASE CHÍNH - MOBILE SHOP

---

## USE CASE 2.2.1: Đăng Ký

**Tóm tắt:** Khách hàng viếng thăm sử dụng use case "Đăng ký" để tạo tài khoản cho mình trên website

**Actor:** Khách hàng viếng thăm

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Trước khi bắt đầu thực hiện Use-case không cần điều kiện gì

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Trên giao diện màn hình chính, khách hàng viếng thăm chọn đăng ký |
| B2 | Hệ thống sẽ hiển thị giao diện đăng ký và khách hàng viếng thăm nhập thông tin vào giao diện để lưu vào cơ sở dữ liệu |
| B3 | Kết thúc Use case |

**Trạng thái hệ thống sau khi thực hiện Use-case:** 
- **Thành công:** Hệ thống sẽ đưa khách hàng tới trang người dùng
- **Lỗi:** Hệ thống hiển thị thông báo lỗi tương ứng (ví dụ: email đã tồn tại, mật khẩu không hợp lệ, thông tin thiếu...). Người dùng được yêu cầu nhập lại thông tin cho đúng

**Điểm mở rộng:** Không có

---

## USE CASE 2.2.2: Thêm Giỏ Hàng

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Thêm giỏ hàng" để đặt những sản phẩm mình cần mua vào không gian lưu trữ tạm thời trên web

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Sau khi khách hàng xem danh sách sản phẩm hoặc chi tiết sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Trên giao diện màn hình chính hoặc màn hình chi tiết sản phẩm, khách hàng chọn "Thêm giỏ hàng" |
| B2 | Hệ thống sẽ lưu trữ thông tin sản phẩm mà khách hàng muốn đưa vào giỏ |
| B3 | Kết thúc Use case |

**Trạng thái hệ thống sau khi thực hiện Use-case:** 
Sau khi thực hiện Use-case hệ thống sẽ xuất thông tin của sản phẩm ra giao diện giỏ hàng

**Điểm mở rộng:** 
Tại giao diện giỏ hàng sẽ có các chức năng:
- Cập nhật số lượng cho sản phẩm đã đặt
- Xóa 1 hoặc nhiều sản phẩm

---

## USE CASE 2.2.3: Đăng Nhập

**Tóm tắt:** Khách hàng viếng thăm sử dụng use case "Đăng nhập" để tham gia mua hàng trực tuyến

**Actor:** Khách hàng viếng thăm

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** Trước khi thực hiện Use-case yêu cầu khách hàng phải đăng ký

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Trên giao diện màn hình chính khách hàng chọn "Đăng nhập" |
| B2 | Hệ thống sẽ hiển thị giao diện đăng nhập và khách hàng nhập thông tin vào giao diện để kiểm tra xem tài khoản đã có hay chưa |
| B3 | Kết thúc Use case |

**Trạng thái hệ thống sau khi thực hiện Use-case:** 
Sau khi thực hiện Use-case hệ thống sẽ đưa vào trang người dùng hiển thị tài khoản người dùng

**Điểm mở rộng:** 
Khách hàng thành viên có thể chọn đăng xuất bất cứ khi nào (yêu cầu trước đó là đã đăng nhập thành công)

---

## USE CASE 2.2.4: Đặt Mua

**Tóm tắt:** Khách hàng thành viên sử dụng use case "đặt mua" để tham gia mua hàng trực tuyến

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập vào hệ thống
- Trong giỏ hàng phải có tối thiểu 1 sản phẩm

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Trên giao diện giỏ hàng, khách hàng chọn "Đặt mua" |
| B2 | Hệ thống sẽ hiển thị giao diện chứa thông tin khách hàng và danh sách các sản phẩm mà khách hàng đặt mua. Sau khi nhập đầy đủ thông tin thì khách hàng xác nhận đặt mua |
| B3 | Kết thúc Use case |

**Trạng thái hệ thống sau khi thực hiện Use-case:** 
Sau khi thực hiện Use-case hệ thống sẽ thông báo đặt hàng thành công hay chưa

**Điểm mở rộng:** 
Khách hàng thành viên có thể chọn đăng xuất bất cứ khi nào (yêu cầu trước đó là đã đăng nhập thành công)

---

## USE CASE 2.2.5: Tra Cứu Đơn Hàng

**Tóm tắt:** Use case mô tả quá trình khách hàng nhập mã đơn hàng theo email đặt hàng để xem tình trạng đơn bao gồm: Mã đơn hàng, thông tin giao hàng, thông tin thanh toán, tổng tiền, trạng thái giao hàng, ngày đặt, các thông tin liên quan

**Actor:** Khách hàng thành viên, Quản trị

**Trạng thái hệ thống bắt đầu thực hiện Use-Case:** 
Hệ thống hoạt động bình thường, dữ liệu đơn hàng đã có trong database (phải tồn tại để tra cứu), người dùng truy cập giao diện tra cứu

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Actor truy cập vào trang "Tra cứu đơn hàng" |
| B2 | Hệ thống hiển thị ô nhập thông tin (mã đơn hàng, email của người đặt hàng) |
| B3 | Actor nhập mã đơn hàng rồi tra cứu |
| B4 | Hệ thống kiểm tra và hiển thị kết quả: thông tin đơn hàng, danh sách sản phẩm, tổng giá trị đơn hàng, trạng thái đơn hàng |

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Nếu tra cứu thành công:** Hệ thống hiển thị đầy đủ thông tin đơn hàng:
  - Mã đơn hàng
  - Thông tin giao hàng
  - Thông tin thanh toán
  - Tổng tiền
  - Trạng thái giao hàng
  - Ngày đặt
  - Danh sách sản phẩm
  
- **Nếu tra cứu thất bại:** Hiển thị thông báo: "Không tìm thấy đơn hàng. Vui lòng kiểm tra mã đơn và email"

---

## USE CASE 2.2.6: Đánh Giá Sản Phẩm

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Đánh giá" để đánh giá sản phẩm đã mua, giúp các khách hàng khác có thông tin tham khảo

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập vào hệ thống
- Khách hàng đã mua sản phẩm
- Sản phẩm tồn tại trong hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng truy cập trang chi tiết sản phẩm hoặc trang lịch sử đơn hàng |
| B2 | Khách hàng chọn "Viết đánh giá" hoặc "Đánh giá sản phẩm" |
| B3 | Hệ thống hiển thị form đánh giá, khách hàng nhập: số sao (1-5), nội dung đánh giá, có thể tải ảnh |
| B4 | Khách hàng xác nhận và gửi đánh giá |
| B5 | Hệ thống lưu đánh giá vào database (chờ phê duyệt từ Admin) |
| B6 | Kết thúc Use case |

**Thông tin nhập liệu:**
- Số sao đánh giá (1-5 sao)
- Nội dung đánh giá (tối thiểu 10 ký tự)
- Hình ảnh (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Thành công:** Đánh giá được lưu, hiển thị "Đánh giá của bạn đã được gửi. Đang chờ Admin phê duyệt", đánh giá chờ phê duyệt từ Admin
- **Lỗi:** Nếu nội dung < 10 ký tự: "Nội dung đánh giá phải tối thiểu 10 ký tự"

**Điểm mở rộng:** 
Admin sẽ phê duyệt hoặc từ chối đánh giá. Nếu phê duyệt, đánh giá sẽ hiển thị công khai trên trang sản phẩm

---

## USE CASE 2.2.7: Gửi Liên Hệ

**Tóm tắt:** Khách hàng (viếng thăm hoặc thành viên) sử dụng use case "Gửi liên hệ" để liên lạc với cửa hàng về các vấn đề, hỏi đáp, phàn nàn hoặc đề xuất

**Actor:** Khách hàng viếng thăm, Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
Ứng dụng đang hoạt động bình thường, trang liên hệ có sẵn trên website

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng truy cập trang "Liên hệ" |
| B2 | Hệ thống hiển thị form liên hệ với các trường: tên, email, số điện thoại, tiêu đề, nội dung |
| B3 | Khách hàng điền đầy đủ thông tin vào form |
| B4 | Khách hàng nhấn nút "Gửi liên hệ" |
| B5 | Hệ thống xác thực dữ liệu và lưu vào database |
| B6 | Gửi email xác nhận đến khách hàng |
| B7 | Kết thúc Use case |

**Thông tin nhập liệu:**
- Tên khách hàng (bắt buộc)
- Email (bắt buộc)
- Số điện thoại (bắt buộc)
- Tiêu đề liên hệ (bắt buộc)
- Nội dung liên hệ (bắt buộc, tối thiểu 20 ký tự)

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Thành công:** 
  - Tin nhắn được lưu trong hệ thống
  - Hiển thị thông báo "Liên hệ của bạn đã được gửi thành công. Chúng tôi sẽ phản hồi sớm nhất"
  - Gửi email xác nhận đến email khách hàng
  - Admin sẽ nhận được thông báo để xử lý

- **Lỗi:** Hiển thị thông báo lỗi tương ứng:
  - "Vui lòng điền đầy đủ thông tin" (nếu thiếu trường bắt buộc)
  - "Email không hợp lệ" (nếu email sai format)
  - "Số điện thoại không hợp lệ" (nếu số điện thoại sai format)
  - "Nội dung liên hệ phải tối thiểu 20 ký tự" (nếu nội dung quá ngắn)

**Điểm mở rộng:** 
Admin sẽ xem danh sách liên hệ, có thể trả lời trực tiếp qua email. Khách hàng có thể xem danh sách liên hệ của mình (nếu đã đăng nhập)

---

## USE CASE 2.2.8: Xem & Quản Lý Yêu Thích

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Yêu thích" để lưu các sản phẩm mình quan tâm để xem lại sau

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập vào hệ thống
- Có sản phẩm trong hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng xem chi tiết sản phẩm |
| B2 | Khách hàng nhấn nút "Yêu thích" (biểu tượng trái tim) |
| B3 | Hệ thống lưu sản phẩm vào danh sách yêu thích |
| B4 | Nút yêu thích chuyển sang màu đỏ, hiển thị "Đã thích" |
| B5 | Khách hàng có thể xem danh sách yêu thích từ tài khoản cá nhân |
| B6 | Kết thúc Use case |

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Thành công:** Sản phẩm được thêm vào danh sách yêu thích, hiển thị thông báo "Đã thêm vào yêu thích"
- **Nếu xóa khỏi yêu thích:** Sản phẩm được loại bỏ, nút quay về màu xám

**Điểm mở rộng:** 
- Khách hàng có thể xem danh sách yêu thích
- Khách hàng có thể xóa sản phẩm khỏi yêu thích
- Từ danh sách yêu thích có thể thêm trực tiếp vào giỏ hàng

---

## USE CASE 2.2.9: Kiểm Tra Mã Giảm Giá

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Kiểm tra mã giảm giá" để áp dụng mã khuyến mãi vào đơn hàng và nhận được giảm giá

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập
- Giỏ hàng có tối thiểu 1 sản phẩm
- Đang ở trang thanh toán

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng ở trang thanh toán/giỏ hàng |
| B2 | Khách hàng tìm thấy ô "Nhập mã giảm giá" hoặc "Mã khuyến mãi" |
| B3 | Khách hàng nhập mã giảm giá vào ô |
| B4 | Hệ thống kiểm tra tính hợp lệ của mã: kiểm tra tồn tại, hết hạn, điều kiện áp dụng |
| B5 | Hệ thống hiển thị kết quả |
| B6 | Kết thúc Use case |

**Thông tin nhập liệu:**
- Mã giảm giá (bắt buộc)

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Mã hợp lệ:** 
  - Tính toán số tiền giảm
  - Cập nhật tổng tiền mới
  - Hiển thị: "Áp dụng mã thành công. Bạn được giảm X đồng"
  
- **Mã không hợp lệ:**
  - "Mã không tồn tại"
  - "Mã đã hết hạn"
  - "Mã chỉ áp dụng cho đơn tối thiểu X đồng"
  - "Bạn đã dùng mã này rồi"

**Điểm mở rộng:** 
Khách hàng có thể xóa mã giảm giá đã áp dụng

---

## USE CASE 2.2.10: Quản Lý Tài Khoản Cá Nhân

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Quản lý tài khoản" để xem và cập nhật thông tin cá nhân

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
Khách hàng đã đăng nhập vào hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng truy cập "Tài khoản cá nhân" hoặc "Hồ sơ" |
| B2 | Hệ thống hiển thị thông tin cá nhân: tên, email, số điện thoại, địa chỉ, ngày đăng ký |
| B3 | Khách hàng chọn "Sửa thông tin" |
| B4 | Hệ thống hiển thị form chỉnh sửa |
| B5 | Khách hàng cập nhật thông tin cần thay đổi |
| B6 | Nhấn "Lưu" |
| B7 | Hệ thống xác thực dữ liệu và cập nhật database |
| B8 | Kết thúc Use case |

**Thông tin có thể cập nhật:**
- Tên đầy đủ
- Số điện thoại
- Địa chỉ
- Mật khẩu (nếu muốn)

**Trạng thái hệ thsistem sau khi thực hiện Use-case:**
- **Thành công:** Thông tin được cập nhật, hiển thị "Cập nhật thông tin thành công"
- **Lỗi:** 
  - "Số điện thoại không hợp lệ"
  - "Địa chỉ không được để trống"
  - "Mật khẩu mới phải khác với mật khẩu cũ"

**Điểm mở rộng:** 
- Khách hàng có thể đổi mật khẩu
- Khách hàng có thể xem lịch sử mua hàng
- Khách hàng có thể xem danh sách yêu thích

---

## USE CASE 2.2.11: Hủy Đơn Hàng

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Hủy đơn hàng" để hủy đơn hàng đã đặt khi chưa được xác nhận giao hàng

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập vào hệ thống
- Khách hàng có đơn hàng với trạng thái "Chờ xác nhận" hoặc "Chờ giao"
- Đơn hàng chưa được giao cho khách hàng

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng truy cập "Lịch sử đơn hàng" trong tài khoản cá nhân |
| B2 | Hệ thống hiển thị danh sách đơn hàng của khách hàng |
| B3 | Khách hàng chọn đơn hàng cần hủy |
| B4 | Xem chi tiết đơn hàng (có nút "Hủy đơn") |
| B5 | Khách hàng nhấn nút "Hủy đơn" |
| B6 | Hệ thống yêu cầu khách hàng xác nhận lý do hủy (tùy chọn: lý do khác, không muốn mua nữa, sản phẩm quá đắt, ...) |
| B7 | Khách hàng xác nhận hủy |
| B8 | Hệ thống xử lý: cập nhật trạng thái đơn hàng thành "Đã hủy", hoàn lại tiền (nếu đã thanh toán), gửi email xác nhận |
| B9 | Kết thúc Use case |

**Thông tin nhập liệu:**
- Lý do hủy (tùy chọn)

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Thành công:** 
  - Đơn hàng chuyển sang trạng thái "Đã hủy"
  - Gửi email xác nhận hủy đơn cho khách hàng
  - Nếu đã thanh toán: xử lý hoàn tiền (hiển thị "Sẽ hoàn tiền trong 3-5 ngày làm việc")
  - Hiển thị thông báo "Đơn hàng đã được hủy thành công"
  
- **Không thể hủy:**
  - "Không thể hủy đơn hàng vì đơn đang được giao"
  - "Không thể hủy đơn hàng đã giao"

**Điểm mở rộng:** 
- Admin sẽ nhận được thông báo về đơn bị hủy
- Khách hàng có thể xem lý do hủy trong chi tiết đơn hàng
- Có thể thiết lập thời gian tối đa để hủy đơn (ví dụ: trong 1 giờ sau khi đặt)

---

## USE CASE 2.2.12: Quản Lý Sản Phẩm (Admin)

**Tóm tắt:** Quản trị viên sử dụng use case "Quản lý sản phẩm" để thêm, sửa, xóa sản phẩm trong hệ thống

**Actor:** Quản trị viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
Admin đã đăng nhập vào hệ thống với quyền quản lý

**Các dòng sự kiện chính (Thêm sản phẩm):**

| Bước | Diễn Tả |
|---|---|
| B1 | Admin truy cập "Quản lý sản phẩm" |
| B2 | Hệ thống hiển thị danh sách sản phẩm |
| B3 | Admin chọn "Thêm sản phẩm mới" |
| B4 | Hệ thống hiển thị form nhập liệu |
| B5 | Admin nhập thông tin: tên, giá, giá gốc, mô tả, hình ảnh, danh mục, thương hiệu, hàng tồn kho, trạng thái |
| B6 | Admin nhấn "Lưu" |
| B7 | Hệ thống xác thực và lưu vào database |
| B8 | Kết thúc Use case |

**Các dòng sự kiện chính (Sửa sản phẩm):**

| Bước | Diễn Tả |
|---|---|
| B1 | Admin xem danh sách sản phẩm |
| B2 | Chọn sản phẩm cần sửa |
| B3 | Hệ thống hiển thị form với thông tin hiện tại |
| B4 | Admin cập nhật các trường cần thay đổi |
| B5 | Admin nhấn "Lưu" |
| B6 | Hệ thống cập nhật database |
| B7 | Kết thúc Use case |

**Các dòng sự kiện chính (Xóa sản phẩm):**

| Bước | Diễn Tả |
|---|---|
| B1 | Admin xem danh sách sản phẩm |
| B2 | Chọn sản phẩm cần xóa |
| B3 | Admin nhấn "Xóa" |
| B4 | Hệ thống yêu cầu xác nhận |
| B5 | Admin xác nhận |
| B6 | Hệ thống xóa sản phẩm khỏi database |
| B7 | Kết thúc Use case |

**Thông tin nhập liệu (Thêm/Sửa):**
- Tên sản phẩm (bắt buộc)
- Giá tiền (bắt buộc)
- Giá gốc (tùy chọn)
- Mô tả chi tiết (bắt buộc)
- Hình ảnh (bắt buộc, có thể upload nhiều ảnh)
- Danh mục (bắt buộc)
- Thương hiệu (bắt buộc)
- Hàng tồn kho (bắt buộc)
- Trạng thái (Hoạt động/Tạm ẩn)

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Thêm thành công:** Sản phẩm được tạo, hiển thị "Sản phẩm mới được thêm thành công"
- **Sửa thành công:** Sản phẩm được cập nhật, hiển thị "Cập nhật sản phẩm thành công"
- **Xóa thành công:** Sản phẩm bị xóa, hiển thị "Xóa sản phẩm thành công"
- **Lỗi:** Hiển thị thông báo lỗi (tên trùng, dữ liệu không hợp lệ, ...)

**Điểm mở rộng:**
- Admin có thể lọc/tìm kiếm sản phẩm
- Admin có thể xuất danh sách sản phẩm
- Admin có thể cập nhật giá hàng loạt
- Admin có thể thay đổi trạng thái hàng loạt

---

## USE CASE 2.2.13: Quản Lý Đơn Hàng (Admin)

**Tóm tắt:** Quản trị viên sử dụng use case "Quản lý đơn hàng" để xem, theo dõi và cập nhật trạng thái đơn hàng của khách hàng

**Actor:** Quản trị viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Admin đã đăng nhập vào hệ thống
- Có đơn hàng trong database

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Admin truy cập "Quản lý đơn hàng" |
| B2 | Hệ thống hiển thị danh sách đơn hàng với các bộ lọc (theo trạng thái, ngày, khách hàng) |
| B3 | Admin có thể tìm kiếm đơn hàng theo mã hoặc tên khách |
| B4 | Admin chọn một đơn hàng để xem chi tiết |
| B5 | Hệ thống hiển thị: thông tin khách hàng, danh sách sản phẩm, tổng tiền, địa chỉ giao, phương thức thanh toán, trạng thái |
| B6 | Admin cập nhật trạng thái: "Chờ xác nhận" → "Đang giao" → "Đã giao" → "Hoàn thành" |
| B7 | Admin nhấn "Lưu" |
| B8 | Hệ thống gửi email thông báo đến khách hàng |
| B9 | Kết thúc Use case |

**Thông tin hiển thị:**
- Mã đơn hàng
- Tên khách hàng, email, số điện thoại
- Ngày đặt hàng
- Danh sách sản phẩm (tên, số lượng, giá)
- Tổng tiền, tiền giảm giá, tiền thanh toán
- Địa chỉ giao hàng
- Phương thức thanh toán
- Ghi chú
- Trạng thái hiện tại

**Trạng thái đơn hàng:**
- Chờ xác nhận
- Đang giao
- Đã giao
- Hoàn thành
- Đã hủy

**Trạng thái hệ thống sau khi thực hiện Use-case:**
- **Cập nhật thành công:** 
  - Trạng thái đơn hàng được cập nhật
  - Email thông báo gửi đến khách hàng
  - Hiển thị "Cập nhật trạng thái đơn hàng thành công"
  
- **Lỗi:**
  - "Không thể cập nhật đơn hàng đã hoàn thành"
  - "Không thể cập nhật đơn hàng đã hủy"

**Các chức năng bổ sung:**

| Chức năng | Mô tả |
|---|---|
| Tìm kiếm | Tìm theo mã đơn hoặc tên khách |
| Lọc | Lọc theo trạng thái, ngày, khách hàng |
| In đơn hàng | In hóa đơn để giao hàng |
| Gửi email | Gửi email thông báo đến khách |
| Xuất file | Xuất danh sách đơn hàng |
| Thống kê | Xem doanh thu, số đơn hàng |

**Điểm mở rộng:**
- Admin có thể xem lịch sử thay đổi trạng thái
- Admin có thể thêm ghi chú cho đơn hàng
- Admin có thể hủy đơn hàng (trong trường hợp đặc biệt)
- Admin có thể tạo đơn hàng thủ công (qua điện thoại)

---

## USE CASE 2.2.14: Nhập Mã Giảm Giá

**Tóm tắt:** Khách hàng thành viên sử dụng use case "Nhập mã giảm giá" để áp dụng mã khuyến mãi vào đơn hàng và nhận được giảm giá

**Actor:** Khách hàng thành viên

**Trạng thái hệ thống bắt đầu thực hiện Use-case:** 
- Khách hàng đã đăng nhập vào hệ thống
- Giỏ hàng có tối thiểu 1 sản phẩm
- Đang ở trang giỏ hàng hoặc trang thanh toán
- Có mã giảm giá hợp lệ trong hệ thống

**Các dòng sự kiện chính:**

| Bước | Diễn Tả |
|---|---|
| B1 | Khách hàng ở trang giỏ hàng hoặc thanh toán |
| B2 | Tìm thấy section "Nhập mã giảm giá" hoặc "Mã khuyến mãi" |
| B3 | Hệ thống hiển thị ô nhập liệu và nút "Áp dụng" |
| B4 | Khách hàng nhập mã giảm giá vào ô |
| B5 | Nhấn nút "Áp dụng" hoặc "Kiểm tra" |
| B6 | Hệ thống kiểm tra mã: kiểm tra tồn tại, chưa hết hạn, đủ điều kiện áp dụng |
| B7 | Hệ thống tính toán và cập nhật giá |
| B8 | Kết thúc Use case |

**Thông tin nhập liệu:**
- Mã giảm giá (bắt buộc, không phân biệt hoa/thường)

**Trạng thái hệ thống sau khi thực hiện Use-case:**

**Trường hợp 1 - Mã hợp lệ:**
- Hiển thị chi tiết giảm giá:
  - "Mã: [MÃ]"
  - "Giảm: X%" hoặc "Giảm: X đồng"
  - "Số tiền giảm: XX.XXX đồng"
- Cập nhật tổng tiền: Tổng cũ - Tiền giảm = Tổng mới
- Hiển thị nút "Xóa mã" nếu muốn bỏ áp dụng
- Hiển thị thông báo xanh: "Áp dụng mã thành công"

**Trường hợp 2 - Mã không hợp lệ:**

| Lỗi | Thông báo |
|---|---|
| Mã không tồn tại | "Mã không hợp lệ. Vui lòng kiểm tra lại" |
| Mã đã hết hạn | "Mã này đã hết hạn. Không thể sử dụng" |
| Đơn hàng < giá trị tối thiểu | "Mã chỉ áp dụng cho đơn hàng từ X đồng trở lên" |
| Mã đã dùng rồi | "Bạn đã dùng mã này rồi. Không thể sử dụng lại" |
| Vượt quá số lần dùng | "Mã này đã hết lượt sử dụng" |
| Không thuộc danh mục | "Mã không áp dụng cho sản phẩm trong giỏ hàng" |
| Trường hợp khác | "Không thể áp dụng mã này. Liên hệ hỗ trợ để biết thêm" |

**Thông tin mã giảm giá:**
- Mã code
- Loại giảm (% hoặc tiền cố định)
- Giá trị giảm
- Ngày bắt đầu/kết thúc
- Số lần có thể dùng
- Giá trị đơn hàng tối thiểu
- Danh mục sản phẩm áp dụng (nếu có)
- Số lần dùng còn lại

**Điểm mở rộng:**
- Khách hàng có thể xóa mã giảm giá đã áp dụng
- Khách hàng có thể nhập nhiều mã (nếu hệ thống cho phép)
- Admin có thể tạo/quản lý mã giảm giá
- Hiển thị danh sách mã giảm giá có sẵn (tùy chọn)
- Tự động áp dụng mã tốt nhất nếu khách hàng có nhiều mã

---

## TÓMO TẮT 14 USE CASE CHÍNH

| UC | Tên | Actor | Mục Đích |
|---|---|---|---|
| 2.2.1 | Đăng ký | Khách viếng thăm | Tạo tài khoản |
| 2.2.2 | Thêm giỏ hàng | Khách thành viên | Thêm sản phẩm vào giỏ |
| 2.2.3 | Đăng nhập | Khách viếng thăm | Xác thực người dùng |
| 2.2.4 | Đặt mua | Khách thành viên | Tạo đơn hàng |
| 2.2.5 | Tra cứu đơn | Khách & Admin | Kiểm tra trạng thái đơn |
| 2.2.6 | Đánh giá sản phẩm | Khách thành viên | Đánh giá sản phẩm đã mua |
| 2.2.7 | Gửi liên hệ | Khách (all) | Liên lạc với cửa hàng |
| 2.2.8 | Yêu thích | Khách thành viên | Lưu sản phẩm yêu thích |
| 2.2.9 | Kiểm tra mã giảm giá | Khách thành viên | Áp dụng khuyến mãi |
| 2.2.10 | Quản lý tài khoản | Khách thành viên | Cập nhật thông tin cá nhân |
| 2.2.11 | Hủy đơn hàng | Khách thành viên | Hủy đơn hàng chưa giao |
| 2.2.12 | Quản lý sản phẩm | Admin | CRUD sản phẩm |
| 2.2.13 | Quản lý đơn hàng | Admin | Xem & cập nhật trạng thái đơn |
| 2.2.14 | Nhập mã giảm giá | Khách thành viên | Áp dụng mã khuyến mãi chi tiết |

---

**Ghi chú:**
- Khách viếng thăm = Khách hàng chưa đăng nhập
- Khách thành viên = Khách hàng đã đăng nhập
- Khách (all) = Cả khách viếng thăm và khách thành viên
- Admin = Quản trị viên
- Tất cả các Use Case đều có phần "Trạng thái hệ thống bắt đầu" và "Trạng thái hệ thống sau khi thực hiện"
