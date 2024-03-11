<?php

declare(strict_types=1);

namespace App\DTOs\Product;

use App\DTOs\DataTransferObject;
use App\Traits\GettableTrait;

class ProductFilters extends DataTransferObject
{
    private const DEFAULT_PAGE = 1;
    private const DEFAULT_PER_PAGE = 15;

    use GettableTrait;

    public function __construct(
        private int $page,
        private int $perPage,
        private int|null $categoryId,
    ) {
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'category_id' => $this->categoryId,
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            page: $data['page'] ?? self::DEFAULT_PAGE,
            perPage: $data['per_page'] ?? self::DEFAULT_PER_PAGE,
            categoryId: isset($data['category_id']) ? (int) $data['category_id'] : null,
        );
    }
}
