<?php

declare(strict_types=1);

namespace Tests\Unit\DTOs\Traits;

use App\Traits\GettableTrait;
use BadMethodCallException;
use Tests\TestCase;

class GettableTraitTest extends TestCase
{
    public function testShouldReturnParameterIfItExists(): void
    {
        $object = new class()
        {

            use GettableTrait;

            private int $id = 1;
        };

        $this->assertEquals(1, $object->id);
    }

    public function testShouldThrowExceptionIfParameterDoesNotExist(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Argument a does not exist');

        $object = new class()
        {

            use GettableTrait;

            private int $id = 1;
        };

        $object->a;
    }
}
