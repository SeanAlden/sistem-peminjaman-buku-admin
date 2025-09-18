<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = ['code', 'name', 'type', 'description'];

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'coa_id');
    }
}
