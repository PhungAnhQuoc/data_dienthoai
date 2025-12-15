<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'original_price',
        'sale_price',
        'discount_percentage',
        'stock',
        'sold',
        'starts_at',
        'ends_at',
        'image',
        'color_badge',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: FlashSale belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Lấy các flash sale đang chạy hoặc sắp bắt đầu
     */
    public static function getActiveAndUpcoming()
    {
        $now = now();
        
        return self::where('is_active', true)
            ->where('ends_at', '>', $now)
            ->orderBy('starts_at', 'asc')
            ->get();
    }

    /**
     * Lấy các flash sale đang chạy ngay bây giờ
     */
    public static function getCurrentFlashSales()
    {
        $now = now();
        
        return self::where('is_active', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>', $now)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Kiểm tra xem flash sale còn hàng không
     */
    public function hasStock()
    {
        return $this->stock > $this->sold;
    }

    /**
     * Lấy số lượng hàng còn lại
     */
    public function getRemainingStock()
    {
        return max(0, $this->stock - $this->sold);
    }

    /**
     * Lấy phần trăm đã bán
     */
    public function getSoldPercentage()
    {
        if ($this->stock == 0) return 0;
        return round(($this->sold / $this->stock) * 100);
    }

    /**
     * Kiểm tra flash sale đã bắt đầu chưa
     */
    public function hasStarted()
    {
        return now()->gte($this->starts_at);
    }

    /**
     * Kiểm tra flash sale còn hoạt động không
     */
    public function isActive()
    {
        $now = now();
        return $this->is_active && 
               $now->gte($this->starts_at) && 
               $now->lte($this->ends_at);
    }

    /**
     * Lấy thời gian còn lại (seconds)
     */
    public function getTimeRemaining()
    {
        $remaining = $this->ends_at->diffInSeconds(now());
        return max(0, $remaining);
    }
}
