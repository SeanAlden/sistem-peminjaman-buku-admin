<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class JournalEntry extends Model
// {
//     protected $fillable = ['transaction_id', 'coa_id', 'debit', 'credit'];

//     public function transaction()
//     {
//         return $this->belongsTo(Transaction::class);
//     }

//     public function account()
//     {
//         return $this->belongsTo(ChartOfAccount::class, 'coa_id');
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','coa_id','debit','credit'];

    protected $casts = [
        'debit' => 'decimal:2',
        'credit' => 'decimal:2',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'coa_id');
    }
}

