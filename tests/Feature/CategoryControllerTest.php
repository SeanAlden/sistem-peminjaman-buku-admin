<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    // /** @test */
    // public function it_can_list_categories(): void
    // {
    //     Category::factory()->create(['name' => 'Novel', 'description' => 'Buku cerita']);

    //     $response = $this->get('/admin/categories');

    //     $response->assertStatus(200);
    //     $response->assertSee('Novel');
    // }

    /** @test */
    public function it_can_list_categories(): void
    {
        // 1. Buat user admin
        $admin = \App\Models\User::factory()->create([
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Login sebagai admin
        $this->actingAs($admin);

        // 3. Buat kategori
        Category::factory()->create(['name' => 'Novel', 'description' => 'Buku cerita']);

        // 4. Hit endpoint
        $response = $this->get('/admin/categories');

        // 5. Assert
        $response->assertStatus(200);
        $response->assertSee('Novel');
    }

    /** @test */
    public function it_can_create_category()
    {
        // 1. Buat user admin
        $admin = \App\Models\User::factory()->create([
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Login sebagai admin
        $this->actingAs($admin);

        $response = $this->post('/admin/categories', [
            'name' => 'Komik',
            'description' => 'Buku gambar'
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Komik']);
    }

    /** @test */
    public function it_validates_when_creating_category()
    {
        // 1. Buat user admin
        $admin = \App\Models\User::factory()->create([
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Login sebagai admin
        $this->actingAs($admin);

        $response = $this->post('/admin/categories', [
            'name' => '',
            'description' => ''
        ]);


        $response->assertSessionHasErrors(['name', 'description']);
    }

    /** @test */
    public function it_can_update_category()
    {
        // 1. Buat user admin
        $admin = \App\Models\User::factory()->create([
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Login sebagai admin
        $this->actingAs($admin);

        $category = Category::factory()->create([
            'name' => 'Teknologi',
            'description' => 'Buku IT'
        ]);

        $response = $this->put("/admin/categories/{$category->id}", [
            'name' => 'Sains',
            'description' => 'Buku Sains'
        ]);

        $response->assertRedirect('/admin/categories');
        $this->assertDatabaseHas('categories', ['name' => 'Sains']);
    }

    /** @test */
    public function it_cannot_delete_category_if_it_has_books()
    {
        // 1. Buat user admin
        $admin = \App\Models\User::factory()->create([
            'usertype' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Login sebagai admin
        $this->actingAs($admin);

        $category = Category::factory()->create();

        // Simulasikan relasi ada buku
        // $category->books()->create([
        //     'title' => 'Buku A',
        //     'author' => 'Penulis',
        //     'published_at' => now()
        // ]);

        $category->books()->create([
            'title' => 'Buku A',
            'author' => 'Penulis',
            'description' => 'Deskripsi buku A', // tambahkan ini
            'created_at' => now()
        ]);

        $response = $this->delete("/admin/categories/{$category->id}");

        $response->assertRedirect('/admin/categories');
        $response->assertSessionHas('error', 'Kategori tidak dapat dihapus karena masih memiliki buku.');
    }
}
