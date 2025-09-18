<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Transaction extends Model
// {
//     protected $fillable = ['reference', 'description', 'transaction_date'];

//     public function journalEntries()
//     {
//         return $this->hasMany(JournalEntry::class);
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference','description','transaction_date',
        'created_by','is_reversal','reversal_of_id','status'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'is_reversal' => 'boolean',
    ];

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function reversalOf()
    {
        return $this->belongsTo(Transaction::class, 'reversal_of_id');
    }
}
