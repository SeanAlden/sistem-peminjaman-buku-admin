<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntryBook extends Model
{
    protected $fillable = [
        'book_id', 'purchase_id', 'stock_before', 'stock_in', 'stock_after'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
