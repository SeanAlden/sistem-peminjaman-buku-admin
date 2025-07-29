<?php

namespace App\Models;

use App\Enums\ReturnStatusNote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'loan_date',
        'return_date',
        'actual_returned_at',
        'status',
        'return_status_note',
        'late_days',
        'fine_amount',
    ];

    // protected $dates = ['loan_date', 'return_date'];
    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
        'actual_returned_at' => 'datetime',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
