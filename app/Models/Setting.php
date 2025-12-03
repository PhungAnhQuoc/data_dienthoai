<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['maintenance_enabled', 'maintenance_message', 'maintenance_ends_at'];

    protected $casts = [
        'maintenance_enabled' => 'boolean',
        'maintenance_ends_at' => 'datetime',
    ];

    // Return the single settings row (convenience)
    public static function instance()
    {
        return static::first();
    }
}
