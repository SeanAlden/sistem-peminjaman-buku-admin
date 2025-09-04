<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use App\Models\Category;
use App\Models\Favorite;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_empty_favorites_for_new_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->getJson('/api/favorites');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => []
            ]);
    }

    /** @test */
    public function it_can_add_a_book_to_favorites()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        $response = $this->postJson('/api/favorites', [
            'book_id' => $book->id
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Buku ditambahkan ke favorit']);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }

    /** @test */
    public function it_does_not_duplicate_favorite_when_added_twice()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        // First add
        $this->postJson('/api/favorites', ['book_id' => $book->id]);
        // Second add
        $this->postJson('/api/favorites', ['book_id' => $book->id]);

        $this->assertDatabaseCount('favorites', 1);
    }

    /** @test */
    public function it_returns_user_favorites()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $category = Category::factory()->create();
        $book1 = Book::factory()->create(['category_id' => $category->id]);
        $book2 = Book::factory()->create(['category_id' => $category->id]);

        Favorite::create(['user_id' => $user->id, 'book_id' => $book1->id]);
        Favorite::create(['user_id' => $user->id, 'book_id' => $book2->id]);

        $response = $this->getJson('/api/favorites');

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $book1->id])
            ->assertJsonFragment(['id' => $book2->id]);
    }

    /** @test */
    public function it_can_remove_a_book_from_favorites()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $category = Category::factory()->create();
        $book = Book::factory()->create(['category_id' => $category->id]);

        Favorite::create(['user_id' => $user->id, 'book_id' => $book->id]);

        $response = $this->deleteJson('/api/favorites', ['book_id' => $book->id]);

        $response->assertStatus(200)
            ->assertJson(['success' => true, 'message' => 'Buku dihapus dari favorit']);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'book_id' => $book->id
        ]);
    }
}
