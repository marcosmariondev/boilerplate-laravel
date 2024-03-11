<?php

declare(strict_types=1);

namespace App\ValueObjects\Product;

use App\ValueObjects\ValueObject;
use InvalidArgumentException;

class Name extends ValueObject
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private string $name
    ) {
        $this->validate();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (!$this->isValid()) {
            throw new InvalidArgumentException('Name is not valid');
        }
    }

    public function isValid(): bool
    {
        return strlen($this->name) >= 3;
    }
}
