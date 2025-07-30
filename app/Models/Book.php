<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title', 'image_url', 'author', 'stock', 'description', 'loan_duration', 'category_id'];

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

}
