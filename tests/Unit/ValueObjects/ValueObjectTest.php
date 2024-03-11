<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\ValueObject;
use BadMethodCallException;
use Tests\TestCase;

class ValueObjectTest extends TestCase
{
    private $valueObject;
    private $valueObject2;
    private $valueObject3;

    public function setUp(): void
    {
        $this->valueObject = new class ('a') extends ValueObject {
            private string $a;

            public function __construct(string $a)
            {
                $this->a = $a;
            }

            public function __toString(): string
            {
                return (string) $this->a;
            }
        };

        $this->valueObject2 = new class ('a') extends ValueObject {
            private string $a;

            public function __construct(string $a)
            {
                $this->a = $a;
            }

            public function __toString(): string
            {
                return (string) $this->a;
            }
        };

        $this->valueObject3 = new class ('b') extends ValueObject {
            private string $a;

            public function __construct(string $a)
            {
                $this->a = $a;
            }

            public function __toString(): string
            {
                return (string) $this->a;
            }
        };
    }

    public function testItemsShouldBeEqual(): void
    {
        $this->assertTrue($this->valueObject->equals($this->valueObject2));
    }

    public function testItemsShouldBeDifferent(): void
    {
        $this->assertFalse($this->valueObject->equals($this->valueObject3));
    }

    public function testShouldThrowExceptionWhenSettingProperty(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Value Object are immutable.');

        $this->valueObject->a = 1;
    }

    public function testShouldThrowExceptionWhenUnSettingProperty(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Value Object are immutable.');

        unset($this->valueObject->a);
    }

    public function testShouldCallToString(): void
    {
        $valueObject = $this->valueObject;
        $this->assertEquals('a', $valueObject());
    }
}
