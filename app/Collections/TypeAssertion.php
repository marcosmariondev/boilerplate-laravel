<?php

declare(strict_types=1);

namespace App\Collections;

trait TypeAssertion
{
    protected function assertValidTypes(...$values): void
    {
        foreach ($values as $value) {
            $this->assertValidType($value);
        }
    }

    protected function assertValidType($value): void
    {
        if ($value instanceof $this->allowedType) {
            return;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Invalid item type, expected %s, given %s',
                $this->allowedType,
                is_object($value) ? get_class($value) : gettype($value)
            )
        );
    }
}
