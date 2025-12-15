<?php

namespace App\Services;

class VNPayService
{
    private $vnp_TmnCode;
    private $vnp_HashSecret;
    private $vnp_Url;
    private $vnp_ReturnUrl;

    public function __construct()
    {
        $this->vnp_TmnCode = config('payment.vnpay.tmncode');
        $this->vnp_HashSecret = config('payment.vnpay.hashsecret');
        $this->vnp_Url = "https://sandbox.vnpayment.vn/paymentgate/vpcpay";
        $this->vnp_ReturnUrl = route('payment.vnpay-return');
    }

    /**
     * Create VNPay payment URL
     * @param int $orderAmount Amount in VND (must be in units of 100)
     * @param string $orderInfo Order information
     * @param string $orderId Order ID
     * @return string Payment URL
     */
    public function createPaymentUrl($orderAmount, $orderInfo, $orderId)
    {
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $this->vnp_TmnCode,
            "vnp_Amount" => $orderAmount * 100, // VNPay requires amount in units of 100
            "vnp_Curr_Code" => "VND",
            "vnp_TxnRef" => $orderId,
            "vnp_OrderInfo" => $orderInfo,
            "vnp_OrderType" => "other",
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => $this->vnp_ReturnUrl,
            "vnp_IpAddr" => $this->getIpAddress(),
            "vnp_CreateDate" => date('YmdHis'),
        );

        if (isset($orderId)) {
            if (is_numeric($orderId)) {
                $inputData['vnp_TxnRef'] = $orderId;
            }
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= "&" . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->vnp_Url . "?" . $query;
        if (isset($this->vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }

    /**
     * Verify VNPay callback response
     * @param array $vnp_Params VNPay response parameters
     * @return array Result with status and message
     */
    public function verifyPaymentResponse($vnp_Params)
    {
        $vnp_SecureHash = isset($vnp_Params['vnp_SecureHash']) ? $vnp_Params['vnp_SecureHash'] : '';
        unset($vnp_Params['vnp_SecureHash']);

        ksort($vnp_Params);

        $hashdata = "";
        $i = 0;
        foreach ($vnp_Params as $key => $value) {
            if ($i == 1) {
                $hashdata .= "&" . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->vnp_HashSecret);
        
        if ($vnp_SecureHash === $vnp_SecureHash) {
            if ($vnp_Params["vnp_ResponseCode"] == "00") {
                return [
                    'success' => true,
                    'message' => 'Thanh toán thành công',
                    'transactionNo' => $vnp_Params['vnp_TransactionNo'] ?? null,
                    'transactionDate' => $vnp_Params['vnp_PayDate'] ?? null,
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Thanh toán không thành công. Mã lỗi: ' . $vnp_Params["vnp_ResponseCode"],
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Chữ ký xác thực không hợp lệ',
            ];
        }
    }

    /**
     * Get IP Address
     */
    private function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
