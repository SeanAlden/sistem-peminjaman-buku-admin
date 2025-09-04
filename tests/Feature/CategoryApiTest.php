<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_category_list()
    {
        Category::factory()->create(['name' => 'Fiksi']);

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Fiksi']);
    }

    /** @test */
    public function it_returns_category_detail()
    {
        $category = Category::factory()->create(['name' => 'Non Fiksi']);

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => 'Non Fiksi']);
    }
}
