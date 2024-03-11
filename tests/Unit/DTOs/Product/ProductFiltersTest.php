<?php

declare(strict_types=1);

namespace Tests\Unit\DTOs\Product;

use App\DTOs\Product\ProductFilters;
use Tests\TestCase;

class ProductFiltersTest extends TestCase
{
    public function testShouldReturnArrayCorrectly(): void
    {
        $filters = new ProductFilters(2, 20, 1);

        $this->assertCount(3, $filters->toArray());
        $this->assertEquals([
            'page' => 2,
            'per_page' => 20,
            'category_id' => 1,
        ], $filters->toArray());
    }

    public function testShouldInstantiateFromArrayCorrectly(): void
    {
        $filters = ProductFilters::fromArray([
            'page' => 2,
            'per_page' => 20,
            'category_id' => 1,
        ]);

        $this->assertEquals(new ProductFilters(2, 20, 1), $filters);
    }

    public function testShouldInstantiateFromArrayCorrectlyWhenPageParamsAreNotGiven(): void
    {
        $filters = ProductFilters::fromArray([
            'category_id' => 1,
        ]);

        $this->assertEquals(new ProductFilters(1, 15, 1), $filters);
    }
}
