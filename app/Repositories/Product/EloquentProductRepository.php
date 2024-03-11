<?php

declare(strict_types=1);

namespace App\Repositories\Product;

use App\ValueObjects\Uuid;
use InvalidArgumentException;
use App\Entities\Product\Product;
use App\DTOs\Product\ProductFilters;
use App\Models\Product\Product as Model;
use Illuminate\Database\Eloquent\Builder;
use App\Exceptions\EntityNotFoundException;
use App\Collections\Product\ProductCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private Model $model,
    ) {
    }

    public function get(ProductFilters $filters): ProductCollection
    {
        $query = $this->model->newQuery();

        $this->applyFilters($query, $filters->toArray());

        $products = $query
            ->paginate($filters->perPage);

        return new ProductCollection(
            Product::arrayOf(
                array_map(fn (Model $item) => $item->toArray(), $products->items())
            ),
            $products->currentPage(),
            (int) ceil($products->total() / $products->perPage()),
            $products->total(),
        );
    }

    /**
     * @throws EntityNotFoundException
     * @throws InvalidArgumentException
     */
    public function getByUuid(Uuid $uuid): Product
    {
        try {
            $product = $this->model
                ->with(['category', 'restrictionType', 'productType'])
                ->where('uuid', (string) $uuid)->firstOrFail();

            return Product::fromArray($product->toArray());
        } catch (ModelNotFoundException) {
            throw new EntityNotFoundException(sprintf('Product with uuid %s was not found', (string) $uuid));
        }
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        if (!isset($filters['category_id'])) {
            return;
        }

        $query->where('category_id', $filters['category_id']);
    }
}
