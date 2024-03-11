<?php

declare(strict_types=1);

namespace App\Traits;

use BadMethodCallException;

trait GettableTrait 
{
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new BadMethodCallException(
            sprintf('Argument %s does not exist', $name)
        );
    }
}
