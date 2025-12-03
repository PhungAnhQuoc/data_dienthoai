<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'subject', 'message', 'status', 'admin_reply', 'replied_at', 'user_id'];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Get the user that sent this message
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
