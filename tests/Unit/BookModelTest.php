<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $book = new Book();

        $this->assertEquals([
            'title',
            'image_url',
            'author',
            'stock',
            'description',
            'loan_duration',
            'category_id',
            'status',
        ], $book->getFillable());
    }

    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $book->category);
    }

    /** @test */
    public function it_has_many_loans()
    {
        $book = Book::factory()->create();
        Loan::factory()->count(2)->create(['book_id' => $book->id]);

        $this->assertCount(2, $book->loans);
    }
}
