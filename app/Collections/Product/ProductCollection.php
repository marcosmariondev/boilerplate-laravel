<?php

declare(strict_types=1);

namespace App\Collections\Product;

use App\Collections\PaginatedCollection;
use App\Entities\Product\Product;

class ProductCollection extends PaginatedCollection
{
    protected string $allowedType = Product::class;
}
