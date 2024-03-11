<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects\Product;

use App\ValueObjects\Product\Slug;
use InvalidArgumentException;
use Tests\TestCase;

class SlugTest extends TestCase
{
    /**
     * @dataProvider validSlugsProvider
     */
    public function testValidSlug(string $value): void
    {
        $id = new Slug($value);

        $this->assertEquals($value, (string) $id);
    }

    public static function validSlugsProvider(): array
    {
        return [
            ['produto-1'],
            ['teste-1'],
            ['product'],
            ['product'],
        ];
    }

    /**
     * @dataProvider invalidSlugsProvider
     */
    public function testInvalidSlugs(string $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Slug is not valid'));

        new Slug($value);
    }

    public static function invalidSlugsProvider(): array
    {
        return [
            ['@t-the-sky'],
            ['at-the--sky'],
            ['-'],
            ['fly-'],
        ];
    }
}
