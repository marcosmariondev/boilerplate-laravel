<?php

declare(strict_types=1);

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Uuid;
use InvalidArgumentException;
use Tests\TestCase;

class UuidTest extends TestCase
{
    /**
     * @dataProvider validUuidsProvider
     */
    public function testValidUuid(string $value): void
    {
        $id = new Uuid($value);

        $this->assertEquals($value, (string) $id);
    }

    public static function validUuidsProvider(): array
    {
        return [
            ['0f613148-ccee-46ae-aff7-e0243cc56ec9'],
            ['0ec56457-1fff-4168-904e-0fd2ef923ef2'],
        ];
    }

    /**
     * @dataProvider invalidUuidsProvider
     */
    public function testInvalidUuid(string $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Uuid is not valid'));

        new Uuid($value);
    }

    public static function invalidUuidsProvider(): array
    {
        return [
            ['0'],
            ['-1'],
            ['false'],
            ['0ec564571fff4168904e0fd2ef923ef2'],
        ];
    }
}
