<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'queue_position',
        'status',
        'notified_at',
        'expires_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Mendapatkan user yang melakukan reservasi.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan buku yang direservasi.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}