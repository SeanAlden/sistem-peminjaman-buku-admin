<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    //
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'name',
        'major',
        'email',
        'phone',
        'description',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
