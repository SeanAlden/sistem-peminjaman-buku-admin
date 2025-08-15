<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'book_id', 'initial_quantity', 'quantity', 'purchase_date', 'total_price', 'notes'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

