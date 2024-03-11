<?php

declare(strict_types=1);

namespace App\Entities\Product;

use App\Entities\BaseEntity;
use App\ValueObjects\Id;
use App\ValueObjects\Product\Name;
use App\ValueObjects\Product\Slug;
use App\ValueObjects\Uuid;

class Product extends BaseEntity
{
    public function __construct(
        private Id $id,
        private Uuid $uuid,
        private Name $name,
        private Slug $slug,
    ) {
    }

    public function getId(): int
    {
        return (int) (string) $this->id;
    }

    public function getUuid(): string
    {
        return (string) $this->uuid;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function getSlug(): string
    {
        return (string) $this->slug;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'uuid' => $this->getUuid(),
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
        ];
    }

    public static function fromArray(array $data): static
    {
        return new self(
            new Id($data['id']),
            new Uuid($data['uuid']),
            new Name($data['name']),
            new Slug($data['slug']),
        );
    }
}
