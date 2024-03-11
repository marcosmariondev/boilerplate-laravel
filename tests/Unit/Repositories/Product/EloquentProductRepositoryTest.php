<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Product;

use App\Collections\Product\ProductCollection;
use App\DTOs\Product\ProductFilters;
use App\Entities\Product\Product;
use App\Exceptions\EntityNotFoundException;
use App\Models\Product\Product as Model;
use App\Repositories\Product\EloquentProductRepository;
use App\ValueObjects\Uuid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Tests\TestCase;

class EloquentProductRepositoryTest extends TestCase
{
    private $productModelMock;
    private EloquentProductRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->productModelMock = $this->mock(Model::class);
        $this->repository = app(EloquentProductRepository::class);
    }

    public function testShouldThrowExceptionIfNoProductIsFound(): void
    {
        $this->expectException(EntityNotFoundException::class);

        $this->productModelMock->shouldReceive('with->where->firstOrFail')
            ->once()
            ->andThrow(ModelNotFoundException::class);

        $this->repository->getByUuid($this->mock(Uuid::class));
    }

    public function testShouldReturnProductCorrectly(): void
    {
        $this->productModelMock->shouldReceive('toArray')
            ->once()
            ->andReturn([
                'id' => 1,
                'uuid' =>  'b0c6b6ea-0758-4293-a409-b2064c582802',
                'name' => 'Fake name',
                'slug' => 'fake-slug',
            ]);

        $this->productModelMock->shouldReceive('with->where->firstOrFail')
            ->once()
            ->andReturn($this->productModelMock);

        $this->assertInstanceOf(Product::class, $this->repository->getByUuid($this->mock(Uuid::class)));
    }

    public function testShouldReturnCollectionWhenThereIsCategoryFilter(): void
    {
        $filter = new ProductFilters(
            1,
            1,
            1,
        );

        $paginatorMock = $this->mock(LengthAwarePaginator::class);

        $builderMock = $this->mock(Builder::class);

        $builderMock->shouldReceive('where')
            ->with('category_id', 1)
            ->once()
            ->andReturn($paginatorMock);

        $this->productModelMock->shouldReceive('newQuery')
            ->once()
            ->andReturn($builderMock);

        $this->productModelMock->shouldReceive('toArray')
            ->once()
            ->andReturn([
                'id' => 1,
                'uuid' =>  'b0c6b6ea-0758-4293-a409-b2064c582802',
                'name' => 'Fake name',
                'slug' => 'fake-slug',
            ]);

        $paginatorMock->shouldReceive('items')
            ->once()
            ->andReturn([$this->productModelMock]);

        $paginatorMock->shouldReceive('total')
            ->twice()
            ->andReturn(1);

        $paginatorMock->shouldReceive('perPage')
            ->once()
            ->andReturn(1);

        $paginatorMock->shouldReceive('currentPage')
            ->once()
            ->andReturn(1);

        $builderMock->shouldReceive('with->paginate')
            ->once()
            ->andReturn($paginatorMock);

        $result = $this->repository->get($filter);
        $this->assertInstanceOf(ProductCollection::class, $result);
        $this->assertEquals(1, $result->getTotalPages());
    }

    public function testShouldReturnCollectionWhenThereIsNoFilter(): void
    {
        $filter = new ProductFilters(
            1,
            1,
            null,
        );

        $paginatorMock = $this->mock(LengthAwarePaginator::class);

        $builderMock = $this->mock(Builder::class);

        $this->productModelMock->shouldReceive('newQuery')
            ->once()
            ->andReturn($builderMock);

        $this->productModelMock->shouldReceive('toArray')
            ->once()
            ->andReturn([
                'id' => 1,
                'uuid' =>  'b0c6b6ea-0758-4293-a409-b2064c582802',
                'name' => 'Fake name',
                'slug' => 'fake-slug',
            ]);

        $paginatorMock->shouldReceive('items')
            ->once()
            ->andReturn([$this->productModelMock]);

        $paginatorMock->shouldReceive('total')
            ->twice()
            ->andReturn(1);

        $paginatorMock->shouldReceive('perPage')
            ->once()
            ->andReturn(1);

        $paginatorMock->shouldReceive('currentPage')
            ->once()
            ->andReturn(1);

        $builderMock->shouldReceive('with->paginate')
            ->once()
            ->andReturn($paginatorMock);

        $builderMock->shouldReceive('where')
            ->never()
            ->andReturn($paginatorMock);


        $this->assertInstanceOf(ProductCollection::class, $this->repository->get($filter));
    }
}
