<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get order with authorization check
     */
    private function getAuthorizedOrder($orderId)
    {
        $order = Order::with(['user', 'items.product', 'paymentMethod'])
            ->findOrFail($orderId);

        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order');
        }

        return $order;
    }

    /**
     * Get company data for invoice
     */
    private function getCompanyData()
    {
        return [
            'name' => config('app.name'),
            'address' => config('app.address', 'Hà Nội, Việt Nam'),
            'phone' => config('app.phone', '1900-xxxx'),
            'email' => config('app.email'),
        ];
    }

    /**
     * Export order invoice as PDF
     */
    public function exportPdf($orderId)
    {
        $order = $this->getAuthorizedOrder($orderId);

        $pdf = Pdf::loadView('invoices.pdf', [
            'order' => $order,
            'company' => $this->getCompanyData()
        ]);

        return $pdf->download('hoa-don-' . $order->order_number . '.pdf');
    }

    /**
     * View invoice in browser
     */
    public function view($orderId)
    {
        $order = $this->getAuthorizedOrder($orderId);

        return view('invoices.view', [
            'order' => $order,
            'company' => $this->getCompanyData()
        ]);
    }
}