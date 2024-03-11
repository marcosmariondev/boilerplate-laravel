<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\Product;

use App\ValueObjects\Product\Name;
use InvalidArgumentException;
use Tests\TestCase;

class NameTest extends TestCase
{
    /**
     * @dataProvider validNamesProvider
     */
    public function testValidName(string $value): void
    {
        $id = new Name($value);

        $this->assertEquals($value, (string) $id);
    }

    public static function validNamesProvider(): array
    {
        return [
            ['produto 1'],
            ['teste 1'],
            ['product'],
        ];
    }

    /**
     * @dataProvider invalidNamesProvider
     */
    public function testInvalidNames(string $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Name is not valid'));

        new Name($value);
    }

    public static function invalidNamesProvider(): array
    {
        return [
            ['0'],
            ['-1'],
            ['na'],
        ];
    }
}
