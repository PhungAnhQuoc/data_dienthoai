<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'image',
        'stock',
        'is_active'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_accessory', 'accessory_id', 'product_id');
    }
}
