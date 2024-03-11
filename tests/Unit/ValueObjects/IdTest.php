<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Id;
use InvalidArgumentException;
use Tests\TestCase;

class IdTest extends TestCase
{
    public function testValidId(): void
    {
        $idVO = new Id(1);
        $this->assertInstanceOf(Id::class, $idVO);
        $this->assertEquals(1, (string) $idVO);

        $idVO = new Id(100);
        $this->assertInstanceOf(Id::class, $idVO);
        $this->assertEquals(100, (string) $idVO);
    }

    public function testInvalidId(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Id is not valid');
        new Id(-1);
    }
}
