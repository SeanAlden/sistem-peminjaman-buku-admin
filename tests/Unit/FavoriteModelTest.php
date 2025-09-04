<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function favorite_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(User::class, $favorite->user);
        $this->assertEquals($user->id, $favorite->user->id);
    }

    /** @test */
    public function favorite_belongs_to_a_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $this->assertInstanceOf(Book::class, $favorite->book);
        $this->assertEquals($book->id, $favorite->book->id);
    }
}
