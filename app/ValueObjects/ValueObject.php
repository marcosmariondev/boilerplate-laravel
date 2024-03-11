<?php

declare(strict_types=1);

namespace App\ValueObjects;

use ReflectionClass;
use ReflectionProperty;

abstract class ValueObject
{
    abstract public function __toString(): string;

    public function __invoke(): string
    {
        return $this->__toString();
    }

    final public function __set(string $name, $value): void
    {
        throw new \BadMethodCallException('Value Object are immutable.');
    }

    final public function __unset(string $name): void
    {
        throw new \BadMethodCallException('Value Object are immutable.');
    }

    public function equals(ValueObject $object): bool
    {
        return $this->hash() === $object->hash();
    }

    public function hash(): string
    {
        $reflectionClass = new ReflectionClass($this);
        $privateProperties = $reflectionClass->getProperties(ReflectionProperty::IS_PRIVATE);
        $objectString = '';
        
        foreach ($privateProperties as $attribute) {
            $attribute->setAccessible(true);
            $objectString .= $attribute->getValue($this);
            $attribute->setAccessible(false);
        }

        return md5($objectString);
    }
}
