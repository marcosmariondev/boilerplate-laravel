<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

class Id extends ValueObject
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(
        private int $id
    ) {
        $this->validate();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        if (!$this->isValid()) {
            throw new InvalidArgumentException('Id is not valid');
        }
    }

    public function isValid(): bool
    {
        return $this->id > 0;
    }
}
