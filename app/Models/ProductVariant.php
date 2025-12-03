<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_value',
        'sku',
        'stock',
        'price',
        'sale_price',
        'image'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? number_format($this->sale_price, 0, ',', '.') . 'đ' : null;
    }
}