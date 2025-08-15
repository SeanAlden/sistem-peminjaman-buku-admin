<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExitBook extends Model
{
    protected $fillable = [
        'book_id',
        'supplier_id',
        'stock_before',
        'stock_out',
        'stock_after',
        'reason',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

