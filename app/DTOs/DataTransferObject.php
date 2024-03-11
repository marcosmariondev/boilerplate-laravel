<?php

declare(strict_types=1);

namespace App\DTOs;

abstract class DataTransferObject
{
    /**
     * @throws Exception
     */
    abstract public static function fromArray(array $data): static;

    abstract public function toArray(): array;
}
