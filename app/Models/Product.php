<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'description', 
        'specifications', 'price', 'sale_price', 'stock', 'main_image',
        'is_featured', 'is_new', 'is_bestseller', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function accessories()
    {
        return $this->belongsToMany(Accessory::class, 'product_accessory', 'product_id', 'accessory_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true)->latest();
    }

    public function getAverageRatingAttribute()
    {
        $reviews = $this->reviews()->get();
        if ($reviews->count() === 0) {
            return 0;
        }
        return round($reviews->avg('rating'), 1);
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