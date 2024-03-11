<?php

declare(strict_types=1);

namespace App\Http\Resources\Product;

use App\Entities\Product\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    /** @property Product $resource */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->resource->getUuid(),
            'name' => $this->resource->getName(),
            'slug' => $this->resource->getSlug(),
        ];
    }
}
