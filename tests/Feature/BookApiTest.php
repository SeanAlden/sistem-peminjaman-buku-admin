<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_list_of_active_books()
    {
        $admin = User::factory()->create(['usertype' => 'user']);
        $this->actingAs($admin);

        $category = Category::factory()->create();
        $book = Book::factory()->create(['status' => 'active', 'category_id' => $category->id]);

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $book->title]);
    }

    /** @test */
    public function it_returns_single_book_detail()
    {
        $admin = User::factory()->create(['usertype' => 'user']);
        $this->actingAs($admin);

        $book = Book::factory()->create();

        $response = $this->getJson("/api/book-details/{$book->id}");

        // $response->assertStatus(200)
        //     ->assertJsonFragment(['title' => $book->title]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $book->id,
                    'title' => $book->title,
                ],
            ]);
    }

    /** @test */
    public function it_returns_404_if_book_not_found()
    {
        $admin = User::factory()->create(['usertype' => 'user']);
        $this->actingAs($admin);

        // $response = $this->getJson("/api/books/999");

        // $response->assertStatus(404)
        //     ->assertJson(['success' => false, 'message' => 'Buku tidak ditemukan']);

        $response = $this->getJson("/api/book-details/999");

        $response->assertStatus(404);
            // ->assertJson([
            //     'success' => false,
            //     'message' => 'No query results for model [App\\Models\\Book] 999'
            // ]);
    }

    /** @test */
    public function it_sets_borrowed_flag_if_user_has_active_loan()
    {
        $admin = User::factory()->create(['usertype' => 'user']);
        $this->actingAs($admin);

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $book = Book::factory()->create();

        // Belum ada loan → false
        // $response = $this->getJson("/api/books/{$book->id}");
        // $response->assertJsonFragment(['is_borrowed_by_user' => false]);

        $response = $this->getJson("/api/book-details/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $book->id,
                    'is_borrowed_by_user' => false,
                    'has_active_reservation_by_user' => false,
                    'active_reservation_id' => null,
                    'active_reservation_status' => null,
                ],
            ]);
    }
}
