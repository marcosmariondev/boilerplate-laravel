<?php

declare(strict_types=1);

namespace App\Repositories\Product\Contracts;

use App\ValueObjects\Uuid;
use InvalidArgumentException;
use App\Entities\Product\Product;
use App\DTOs\Product\ProductFilters;
use App\Exceptions\EntityNotFoundException;
use App\Collections\Product\ProductCollection;

interface ProductRepositoryInterface
{
    public function get(ProductFilters $filters): ProductCollection;

    /**
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUuid(Uuid $uuid): Product;
}
