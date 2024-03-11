<?php

declare(strict_types=1);

namespace Tests\Unit\Entities\Product;

use App\Entities\Product\Category;
use App\Entities\Product\Product;
use App\Entities\Product\RestrictionType;
use App\ValueObjects\Id;
use App\ValueObjects\Product\Name;
use App\ValueObjects\Product\Slug;
use App\ValueObjects\Uuid;
use Tests\TestCase;

class ProductTest extends TestCase
{
    private Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = new Product(
            new Id(1),
            new Uuid('5c322047-5e04-4173-965c-1fe7996c27ed'),
            new Name('Product Test'),
            new Slug('product-test'),
        );
    }

    public function testShouldCallFromArrayCorrectly(): void
    {
        $this->assertEquals(Product::fromArray([
            'id' => 1,
            'uuid' => '5c322047-5e04-4173-965c-1fe7996c27ed',
            'name' => 'Product Test',
            'slug' => 'product-test',
        ]), new Product(
            id: new Id(1),
            uuid: new Uuid('5c322047-5e04-4173-965c-1fe7996c27ed'),
            name: new Name('Product Test'),
            slug: new Slug('product-test'),
        ));
    }

    public function testShouldCallToArrayCorrectly(): void
    {

        $data = $this->product->toArray();
        $this->assertCount(4, $data);
        $this->assertEquals([
            'id' => 1,
            'uuid' => '5c322047-5e04-4173-965c-1fe7996c27ed',
            'name' => 'Product Test',
            'slug' => 'product-test',
        ], $data);
    }
}
