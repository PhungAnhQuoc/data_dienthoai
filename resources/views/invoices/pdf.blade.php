<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-info h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .company-info p {
            font-size: 12px;
            color: #666;
            margin: 3px 0;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h2 {
            font-size: 20px;
            color: #007bff;
            margin-bottom: 10px;
        }
        .invoice-info p {
            font-size: 12px;
            margin: 3px 0;
        }
        .section-title {
            background-color: #f0f0f0;
            padding: 8px 12px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .customer-info, .shipping-info {
            display: inline-block;
            width: 48%;
            vertical-align: top;
            font-size: 12px;
        }
        .customer-info {
            margin-right: 4%;
        }
        .info-label {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 3px;
        }
        .info-content {
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }
        th {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .summary {
            margin-top: 20px;
            font-size: 12px;
        }
        .summary-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 8px;
        }
        .summary-label {
            width: 200px;
            text-align: right;
            padding-right: 20px;
        }
        .summary-value {
            width: 100px;
            text-align: right;
            border-bottom: 1px solid #ddd;
            padding-right: 10px;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 14px;
            color: #007bff;
        }
        .total-label {
            width: 200px;
            text-align: right;
            padding-right: 20px;
        }
        .total-value {
            width: 100px;
            text-align: right;
            padding-right: 10px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        .note {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 10px;
            margin-top: 20px;
            font-size: 11px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>{{ $company['name'] }}</h1>
                <p><strong>Địa chỉ:</strong> {{ $company['address'] }}</p>
                <p><strong>Điện thoại:</strong> {{ $company['phone'] }}</p>
                <p><strong>Email:</strong> {{ $company['email'] }}</p>
            </div>
            <div class="invoice-info">
                <h2>HÓA ĐƠN</h2>
                <p><strong>Mã đơn hàng:</strong> {{ $order->order_number }}</p>
                <p><strong>Ngày lập:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                @if($order->payment_status === 'paid')
                    <p><strong>Trạng thái:</strong> <span style="color: green;">✓ Đã thanh toán</span></p>
                @else
                    <p><strong>Trạng thái:</strong> <span style="color: orange;">⏳ Chờ thanh toán</span></p>
                @endif
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div>
            <div class="customer-info">
                <div class="info-label">THÔNG TIN KHÁCH HÀNG</div>
                <div class="info-content">
                    <div><strong>{{ $order->user->name }}</strong></div>
                    <div>{{ $order->user->email }}</div>
                    <div>{{ $order->user->phone ?? 'Không có' }}</div>
                </div>
            </div>

            <div class="shipping-info">
                <div class="info-label">ĐỊA CHỈ GIAO HÀNG</div>
                <div class="info-content">
                    <div><strong>{{ $order->shipping_name }}</strong></div>
                    <div>{{ $order->shipping_phone }}</div>
                    <div>{{ $order->shipping_address }}</div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 50%;">Sản phẩm</th>
                    <th style="width: 15%; text-align: center;">Số lượng</th>
                    <th style="width: 18%; text-align: right;">Đơn giá</th>
                    <th style="width: 17%; text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 0, ',', '.') }}₫</td>
                    <td class="text-right">{{ number_format($item->total_price, 0, ',', '.') }}₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <div class="summary-label">Tạm tính:</div>
                <div class="summary-value">{{ number_format($order->total_amount - $order->shipping_cost - $order->tax_amount + $order->discount_amount, 0, ',', '.') }}₫</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Phí vận chuyển:</div>
                <div class="summary-value">{{ number_format($order->shipping_cost, 0, ',', '.') }}₫</div>
            </div>
            <div class="summary-row">
                <div class="summary-label">Thuế VAT (10%):</div>
                <div class="summary-value">{{ number_format($order->tax_amount, 0, ',', '.') }}₫</div>
            </div>
            @if($order->discount_amount > 0)
            <div class="summary-row">
                <div class="summary-label">Giảm giá ({{ $order->promotion_code }}):</div>
                <div class="summary-value" style="border-bottom: none; color: green;">-{{ number_format($order->discount_amount, 0, ',', '.') }}₫</div>
            </div>
            @endif
            <div class="total-row">
                <div class="total-label">TỔNG CỘNG:</div>
                <div class="total-value">{{ number_format($order->total_amount, 0, ',', '.') }}₫</div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="note">
            <strong>Phương thức thanh toán:</strong> {{ $order->paymentMethod->display_name ?? 'Không xác định' }}<br>
            @if($order->notes)
            <strong>Ghi chú:</strong> {{ $order->notes }}
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Cảm ơn bạn đã mua hàng! Vui lòng liên hệ với chúng tôi nếu có bất kỳ câu hỏi nào.</p>
            <p>Tài liệu này được phát hành vào ngày {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>
</body>
</html>
