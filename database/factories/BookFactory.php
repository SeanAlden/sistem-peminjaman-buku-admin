<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title'        => $this->faker->sentence(3),
            'author'       => $this->faker->name,
            'description'  => $this->faker->paragraph,   // isi kolom wajib
            'created_at' => $this->faker->dateTimeThisDecade,
            'category_id'  => Category::factory(),       // relasi ke kategori
        ];
    }
}
