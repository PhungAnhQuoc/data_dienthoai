<?php

namespace App\Models;

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
        'cancelled_at'
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
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
        return $this->belongsTo(PaymentMethod::class);
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
