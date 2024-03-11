<?php

declare(strict_types=1);

namespace Tests\Unit\Entities;

use App\Entities\BaseEntity;
use App\ValueObjects\ValueObject;
use BadMethodCallException;
use Tests\TestCase;

class BaseEntityTest extends TestCase
{
    private $baseEntity;

    public function setUp(): void
    {
        $this->baseEntity = new class('a') extends BaseEntity
        {

            private string $a;

            public function __construct(string $a)
            {
                $this->a = $a;
            }

            public function toArray(): array
            {
                return ['a' => $this->a];
            }

            public static function fromArray(array $data): static
            {
                return new static(
                    $data['a']
                );
            }
        };
    }

    public function testShouldCreateArrayOfEntitiesCorrectly(): void
    {
        $array = [
            ['a' => '1'],
            ['a' => '2'],
            ['a' => '3'],
        ];
        $this->assertEquals(
            $this->baseEntity::arrayOf($array),
            [
                new $this->baseEntity('1'),
                new $this->baseEntity('2'),
                new $this->baseEntity('3'),
            ]
        );
    }
}
