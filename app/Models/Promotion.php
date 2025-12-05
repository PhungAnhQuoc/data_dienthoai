<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'code', 'discount_value', 
        'discount_type', 'start_date', 'end_date', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];
    
    /**
     * Calculate discount for given subtotal
     */
    public function calculateDiscount($subtotal = 0)
    {
        $discount = 0;
        
        if ($this->discount_type === 'percentage') {
            // For percentage, if discount_value >= 100, treat as free shipping
            if ($this->discount_value >= 100) {
                $discount = 30000; // Standard shipping cost
            } else {
                $discount = round($subtotal * ($this->discount_value / 100));
                // Cap discount at subtotal for percentage discounts
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            }
        } else {
            // For fixed amount
            if ($this->discount_value == 0) {
                // Free shipping
                $discount = 30000; // Standard shipping cost
            } else {
                $discount = (int)$this->discount_value;
                // Cap discount at subtotal for fixed discounts on product price
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            }
        }
        
        return $discount;
    }
    
    /**
     * Check if this is a shipping discount
     */
    public function isShippingDiscount()
    {
        return ($this->discount_type === 'percentage' && $this->discount_value >= 100) ||
               ($this->discount_type === 'fixed' && $this->discount_value == 0);
    }
}