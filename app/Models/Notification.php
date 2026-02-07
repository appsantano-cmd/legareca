<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Loggable;

class Notification extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'user_id',
        'sender_id',
        'type',
        'title',
        'message',
        'data',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean'
    ];

    // Relasi ke user penerima
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke pengirim
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Scope untuk notifikasi belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk notifikasi sudah dibaca
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
