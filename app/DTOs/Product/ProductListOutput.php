<?php

declare(strict_types=1);

namespace App\DTOs\Product;

use App\Collections\Product\ProductCollection;
use App\DTOs\DataTransferObject;
use App\Traits\GettableTrait;

class ProductListOutput extends DataTransferObject
{
    use GettableTrait;

    public function __construct(
        public ProductCollection $collection,
    ) {
    }

    public function paginationInfo(): array
    {
        return [
            'page' => $this->collection->getCurrentPage(),
            'next' => $this->collection->getNextPage(),
            'previous' => $this->collection->getPreviousPage(),
        ];
    }

    public function toArray(): array
    {
        return [
            'collection' => $this->collection->toArray()
        ];
    }

    /**
     * @throws Exception
     */
    public static function fromArray(array $data): static
    {
        return new self(
            $data['products']
        );
    }
}
