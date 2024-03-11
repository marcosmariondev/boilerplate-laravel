<?php

declare(strict_types=1);

namespace App\ValueObjects\Product;

use App\ValueObjects\ValueObject;
use InvalidArgumentException;

class Slug extends ValueObject
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $slug
    ) {
        $this->validate();
    }

    public function __toString(): string
    {
        return $this->slug;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (!$this->isValid()) {
            throw new InvalidArgumentException('Slug is not valid');
        }
    }

    public function isValid(): bool
    {
        return (bool) preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $this->slug);
    }
}
