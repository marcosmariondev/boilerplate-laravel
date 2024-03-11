<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Product;

use App\Collections\Product\ProductCollection;
use App\DTOs\Product\ProductFilters;
use App\DTOs\Product\ProductListOutput;
use App\Exceptions\EntityNotFoundException;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use App\Services\Product\ProductService;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    private MockInterface $repositoryMock;
    private ProductService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->repositoryMock = $this->mock(ProductRepositoryInterface::class);
        $this->service = app(ProductService::class);
    }

    public function testShouldThrowExceptionWhenRepositoryThrowsOne(): void
    {
        $this->expectException(EntityNotFoundException::class);

        $filterMock = new ProductFilters(
            1,
            5,
            null,
        );
        $this->repositoryMock->shouldReceive('get')
            ->once()
            ->andThrow(new EntityNotFoundException());

        $this->service->get($filterMock);
    }

    public function testShouldReturnCorrectProductListOutputDto(): void
    {
        $filterMock = new ProductFilters(
            1,
            5,
            null,
        );

        $collectionMock = new ProductCollection([], 1, 1, 5);

        $this->repositoryMock->shouldReceive('get')
            ->once()
            ->andReturn($collectionMock);

        $this->assertInstanceOf(ProductListOutput::class, $this->service->get($filterMock));
    }
}
