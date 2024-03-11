<?php

declare(strict_types=1);

namespace App\Collections;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements IteratorAggregate, Countable, ArrayAccess, Arrayable
{
    use TypeAssertion;

    protected string $allowedType = '';

    public function __construct(protected array $items = [])
    {
        if ('' !== $this->allowedType) {
            $this->assertValidTypes(...$items);
        }

        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }

    public function add($item): void
    {
        if ('' !== $this->allowedType) {
            $this->assertValidType($item);
        }

        $this->items[] = $item;
    }

    public function size(): int
    {
        return count($this->items);
    }

    public function first()
    {
        if ($this->isEmpty()) {
            return null;
        }

        if ($this->offsetExists(0)) {
            return $this->at(0);
        }

        return $this->at(array_key_first($this->items));
    }

    public function last()
    {
        if ($this->isEmpty()) {
            return null;
        }

        return $this->at(array_key_last($this->items));
    }

    public function exists(int|string $index): bool
    {
        return array_key_exists($index, $this->items);
    }

    public function at(int|string $index)
    {
        if ($this->exists($index)) {
            return $this->items[$index];
        }

        return null;
    }

    public function isEmpty(): bool
    {
        return $this->size() === 0;
    }

    public function count(): int
    {
        return $this->size();
    }

    public function getIterator(): \Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    public function toArray(): array
    {
        return $this->all();
    }

    public static function make(array $items = []): self
    {
        return new self($items);
    }

    public function prepend($value): self
    {
        if ('' !== $this->allowedType) {
            $this->assertValidType($value);
        }

        array_unshift($this->items, $value);

        return $this;
    }

    public function map(callable $function): self
    {
        $items = array_map($function, $this->items);

        return new self($items);
    }

    public function filter(callable $function, $mode = 0): self
    {
        $items = array_filter($this->items, $function, $mode);

        return new self($items);
    }
}
