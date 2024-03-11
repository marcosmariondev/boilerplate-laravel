<?php

declare(strict_types=1);

namespace App\Services\Product;

use App\DTOs\Product\ProductFilters;
use App\DTOs\Product\ProductListOutput;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;
use App\Services\Product\Contracts\ProductServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {
    }

    public function get(ProductFilters $filters): ProductListOutput
    {
        $products = $this->repository->get($filters);
        return new ProductListOutput($products);
    }
}
