<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookPrediction extends Model
{
    protected $fillable = ['book_id', 'loan_count', 'predicted_popularity', 'des_prediction'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

