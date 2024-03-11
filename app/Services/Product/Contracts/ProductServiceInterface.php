<?php

declare(strict_types=1);

namespace App\Services\Product\Contracts;

use App\DTOs\Product\ProductFilters;
use App\DTOs\Product\ProductListOutput;
use App\Entities\Product\Product;

interface ProductServiceInterface 
{
    public function get(ProductFilters $filters): ProductListOutput;
} 
