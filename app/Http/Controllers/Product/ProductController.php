<?php

declare(strict_types=1);

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductListResource;
use App\Services\Product\Contracts\ProductServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function __construct(
        private ProductServiceInterface $service
    ) {
    }

    public function index(ProductRequest $request): JsonResource
    {
        $products = $this->service->get(
            filters: $request->toDto()
        );

        return ProductListResource::collection(
            $products->collection->toArray()
        )->additional(['meta' => $products->paginationInfo()]);
    }
}
