<?php

namespace Tests\Unit;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryModelTest extends TestCase
{
    /** @test */
    public function it_has_fillable_attributes(): void
    {
        $category = new Category();

        $this->assertEquals(['name', 'description'], $category->getFillable());
    }
}
