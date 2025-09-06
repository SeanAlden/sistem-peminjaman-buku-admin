<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name','position','base_salary','email','phone'];

    public function payrolls() {
        return $this->hasMany(Payroll::class);
    }
}