<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use App\DTOs\Product\ProductFilters;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    const DEFAULT_LIMIT_PER_PAGE = 25;
    const DEFAULT_PAGE = 1;

    public function rules(): array
    {
        return [
            'page' => ['nullable', 'integer'],
            'per_page' => ['nullable', 'integer'],
        ];
    }

    public function toDto(): ProductFilters
    {
        $data = $this->validated();

        return ProductFilters::fromArray([
            'per_page' => intval($data['per_page'] ?? self::DEFAULT_LIMIT_PER_PAGE),
            'page' => intval($data['page'] ?? self::DEFAULT_PAGE),
        ] + $data);
    }
}
