<?php

declare(strict_types=1);

namespace App\Entities;

abstract class BaseEntity
{
    abstract public static function fromArray(array $data): static;

    abstract public function toArray(): array;

    /**
     * Create an array of Entities from $items
     *
     * @return array<int,static>
     */
    public static function arrayOf(array $items): array
    {
        return array_map(fn (array $item) => static::fromArray($item), $items);
    }
}
