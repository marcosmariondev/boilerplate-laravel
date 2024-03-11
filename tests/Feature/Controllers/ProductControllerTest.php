<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use App\Collections\Product\ProductCollection;
use App\DTOs\Product\ProductListOutput;
use App\Entities\Product\Product;
use App\Services\Product\Contracts\ProductServiceInterface;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    protected $connectionsToTransact = ['mysql'];


    public function testShouldReturnListOfProducts(): void
    {
        $productMock = $this->mock(Product::class);
        $productMock->shouldReceive('getUuid')->andReturn('a');
        $productMock->shouldReceive('getName')->andReturn('Fake name');
        $productMock->shouldReceive('getSlug')->andReturn('fake-name');

        $productCollectionMock = $this->mock(ProductCollection::class);
        $productCollectionMock->shouldReceive('toArray')
            ->once()
            ->andReturn([$productMock]);

        $productCollectionMock->shouldReceive('getCurrentPage')
            ->once()
            ->andReturn(1);

        $productCollectionMock->shouldReceive('getNextPage')
            ->once()
            ->andReturn(null);

        $productCollectionMock->shouldReceive('getPreviousPage')
            ->once()
            ->andReturn(null);

        $productListMock = ProductListOutput::fromArray([
            'products' => $productCollectionMock
        ]);

        $service = $this->mock(ProductServiceInterface::class);
        $service->shouldReceive('get')
            ->once()
            ->andReturn($productListMock);

        $this->app->bind(ProductServiceInterface::class, function () use ($service) {
            return $service;
        });

        $response = $this->get(route('products'));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' =>  [
                [
                    'uuid' => 'a',
                    'name' => 'Fake name',
                    'slug' => 'fake-name',
                ],
            ],
            'meta' => [
                'page' => 1,
                'next' => null,
                'previous' => null,
            ],
        ]);
    }
}
