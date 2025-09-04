<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function admin_can_create_a_book()
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $this->actingAs($admin);

        $category = Category::factory()->create();

        $response = $this->post(route('books.store'), [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'stock' => 10,
            'description' => 'Deskripsi buku test',
            'loan_duration' => 7,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'Test Book']);
    }

    /** @test */
    public function admin_can_update_a_book()
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $this->actingAs($admin);

        $book = Book::factory()->create();

        $response = $this->put(route('books.update', $book->id), [
            'title' => 'Updated Book',
            'author' => 'Updated Author',
            'stock' => 5,
            'description' => 'Updated description',
            'loan_duration' => 10,
            'category_id' => $book->category_id,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'Updated Book']);
    }

    /** @test */
    public function admin_can_soft_delete_a_book()
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $this->actingAs($admin);

        $book = Book::factory()->create();

        $response = $this->delete(route('books.destroy', $book->id));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['id' => $book->id, 'status' => 'inactive']);
    }

    /** @test */
    public function it_shows_active_books_in_index()
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $this->actingAs($admin);

        $book = Book::factory()->create(['status' => 'active']);

        $response = $this->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }

    /** @test */
    public function it_shows_single_book_detail()
    {
        $admin = User::factory()->create(['usertype' => 'admin']);
        $this->actingAs($admin);
        
        $book = Book::factory()->create();

        $response = $this->get(route('books.show', $book->id));

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }
}
