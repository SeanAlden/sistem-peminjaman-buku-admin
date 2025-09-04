<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    
    use HasFactory;

    protected $fillable = ['title', 'image_url', 'author', 'stock', 'description', 'loan_duration', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function favoritedBy()
    {
        return $this->hasMany(Favorite::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

}
