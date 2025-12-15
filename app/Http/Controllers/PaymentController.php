<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\VNPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $vnpay;

    public function __construct(VNPayService $vnpay)
    {
        $this->vnpay = $vnpay;
        $this->middleware('auth');
    }

    /**
     * Redirect to VNPay payment gateway
     */
    public function redirectToVNPay($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Verify that the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order');
        }

        // Check if order is already paid
        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $orderId)
                ->with('warning', 'Đơn hàng này đã được thanh toán');
        }

        try {
            $paymentUrl = $this->vnpay->createPaymentUrl(
                $order->total_amount,
                'Thanh toan don hang ' . $order->order_number,
                $order->id
            );

            Log::info('VNPay Payment URL created', ['url' => $paymentUrl, 'orderId' => $order->id, 'amount' => $order->total_amount]);

            return redirect($paymentUrl);
        } catch (\Exception $e) {
            Log::error('VNPay payment URL creation error: ' . $e->getMessage(), ['orderId' => $orderId, 'trace' => $e->getTraceAsString()]);
            return redirect()->route('checkout.success', $orderId)
                ->with('error', 'Có lỗi xảy ra khi tạo link thanh toán: ' . $e->getMessage());
        }
    }

    /**
     * Handle VNPay payment callback (IPN)
     */
    public function vnpayIpn(Request $request)
    {
        $inputData = $request->all();

        $vnp_SecureHash = isset($inputData['vnp_SecureHash']) ? $inputData['vnp_SecureHash'] : '';
        $orderId = isset($inputData['vnp_TxnRef']) ? (int)$inputData['vnp_TxnRef'] : null;

        Log::info('VNPay IPN received', ['orderId' => $orderId, 'data' => $inputData]);

        $resp = array(
            "RspCode" => "99",
            "Message" => "Fail"
        );

        try {
            // Verify payment response
            $verifyResult = $this->vnpay->verifyPaymentResponse($inputData);

            if ($verifyResult['success']) {
                // Find the order
                $order = Order::find($orderId);
                
                if ($order) {
                    $oldStatus = $order->status;
                    
                    // Update order payment status
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'confirmed',
                        'payment_response' => json_encode($inputData),
                        'transaction_id' => $inputData['vnp_TransactionNo'] ?? null,
                    ]);

                    $resp = array(
                        "RspCode" => "00",
                        "Message" => "Success"
                    );

                    Log::info('VNPay payment confirmed', ['orderId' => $orderId]);
                } else {
                    Log::warning('Order not found in VNPay IPN', ['orderId' => $orderId]);
                }
            } else {
                // Payment failed
                $order = Order::find($orderId);
                if ($order) {
                    $order->update([
                        'payment_status' => 'failed',
                        'payment_response' => json_encode($inputData),
                    ]);

                    Log::warning('VNPay payment failed', ['orderId' => $orderId, 'reason' => $verifyResult['message']]);
                }

                $resp = array(
                    "RspCode" => "01",
                    "Message" => "Payment failed"
                );
            }
        } catch (\Exception $e) {
            Log::error('VNPay IPN error: ' . $e->getMessage());
            $resp = array(
                "RspCode" => "99",
                "Message" => "Error"
            );
        }

        return response()->json($resp);
    }

    /**
     * Handle VNPay return from payment gateway
     */
    public function vnpayReturn(Request $request)
    {
        $inputData = $request->all();
        $orderId = isset($inputData['vnp_TxnRef']) ? (int)$inputData['vnp_TxnRef'] : null;

        Log::info('VNPay return received', ['orderId' => $orderId, 'responseCode' => $inputData['vnp_ResponseCode'] ?? null]);

        if (!$orderId) {
            return redirect()->route('home')
                ->with('error', 'Không tìm thấy đơn hàng');
        }

        $order = Order::findOrFail($orderId);

        // Verify that the order belongs to the current user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order');
        }

        try {
            $verifyResult = $this->vnpay->verifyPaymentResponse($inputData);

            if ($verifyResult['success'] && $order->payment_status === 'paid') {
                return redirect()->route('checkout.success', $orderId)
                    ->with('success', 'Thanh toán thành công');
            } else {
                return redirect()->route('checkout.success', $orderId)
                    ->with('error', 'Thanh toán không thành công: ' . $verifyResult['message']);
            }
        } catch (\Exception $e) {
            Log::error('VNPay return error: ' . $e->getMessage());
            return redirect()->route('checkout.success', $orderId)
                ->with('error', 'Có lỗi xảy ra khi xử lý kết quả thanh toán');
        }
    }

    /**
     * Retry payment for failed order
     */
    public function retryPayment($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $orderId)
                ->with('warning', 'Đơn hàng đã được thanh toán');
        }

        return $this->redirectToVNPay($orderId);
    }
}
