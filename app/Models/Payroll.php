<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','basic_salary','bonus','deduction','net_salary','payment_date', 'status'];

    public function employee() {
        return $this->belongsTo(Employee::class);
    }
}

