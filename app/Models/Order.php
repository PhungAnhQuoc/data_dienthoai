<?php

namespace App\Models;

use App\Events\OrderStatusChanged;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_cost',
        'tax_amount',
        'promotion_code',
        'discount_amount',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'shipping_phone',
        'shipping_name',
        'shipping_email',
        'notes',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'transaction_id',
        'payment_response'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'payment_response' => 'json',
    ];

    protected $dispatchesEvents = [
        'updated' => OrderStatusChanged::class,
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }

    // Generate order number
    public static function generateOrderNumber()
    {
        $year = date('Y');
        $month = date('m');
        $lastOrder = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();
        
        $num = $lastOrder ? (int)substr($lastOrder->order_number, -4) + 1 : 1;
        return 'ORD-' . $year . $month . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
