<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Payment extends Model
// {
//     protected $fillable = ['employee_id', 'supplier_id', 'amount', 'payment_date', 'method', 'notes'];

//     public function employee()
//     {
//         return $this->belongsTo(Employee::class);
//     }

//     public function supplier()
//     {
//         return $this->belongsTo(Supplier::class);
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'supplier_id',
        'amount',
        'payment_date',
        'method',
        'notes',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

