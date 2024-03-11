<?php

declare(strict_types=1);

namespace Tests\Unit\Collections;

use App\Collections\Collection;
use ArrayIterator;
use InvalidArgumentException;
use Tests\TestCase;


class CollectionTest extends TestCase
{
    public function testShouldGetFirstElementFromCollection(): void
    {
        $collection = new Collection([2, 1, 3]);

        $this->assertEquals(2, $collection->first());
    }

    public function testWillReturnNullWhenNotHasFirstElement(): void
    {
        $collection = new Collection();

        $this->assertNull($collection->first());
    }

    public function testShouldGetLastElementFromCollection(): void
    {
        $collection = new Collection([2, 1, 3]);

        $this->assertEquals(3, $collection->last());
    }

    public function testWillReturnNullWhenDoesNotHaveAnyElement(): void
    {
        $collection = new Collection();

        $this->assertNull($collection->last());
    }

    public function testShouldCheckIfKeyFromCollectionExists(): void
    {
        $collection = new Collection([
            'two' => 2,
            2 => 1,
        ]);

        $this->assertTrue($collection->exists('two'));
        $this->assertTrue($collection->exists(2));
    }

    public function testShouldGetItemFromPositionOnCollection(): void
    {
        $collection = Collection::make([1, 2, 3]);

        $this->assertEquals(3, $collection->at(2));
    }

    public function testWillReturnNullWhenGetItemFromNotExistedPosition(): void
    {
        $collection = Collection::make([1, 2]);

        $this->assertNull($collection->at(2));
    }

    public function testShouldTransformCollectionInArray(): void
    {
        $collection = Collection::make([1, 2, 3]);

        $collectionAsArray = $collection->toArray();

        $this->assertNotEquals($collectionAsArray, $collection);
        $this->assertIsArray($collectionAsArray);
        $this->assertEquals([1, 2, 3], $collectionAsArray);
    }

    public function testShouldCreateCollectionFromEmpty(): void
    {
        $collection = Collection::make();

        $this->assertTrue($collection->isEmpty());
    }

    public function testShouldAccessCollectionAsArray(): void
    {
        $collection = Collection::make([1, 2]);

        $this->assertEquals(1, $collection[0]);
        $this->assertEquals(2, $collection[1]);
    }

    public function testShouldUnsetCollectionItemAsArray(): void
    {
        $collection = Collection::make([1, 2]);

        unset($collection[0]);

        $this->assertArrayNotHasKey(0, $collection);
        $this->assertCount(1, $collection);
        $this->assertEquals(2, $collection->first());
    }

    public function testShouldSetItemOnCollectionAsArray(): void
    {
        $collection = Collection::make();

        $collection[] = 1;
        $collection[3] = 4;

        $this->assertCount(2, $collection);
        $this->assertEquals(1, $collection->first());
        $this->assertEquals(4, $collection->at(3));
    }

    public function testShouldCheckIfKeyExistsAsArray(): void
    {
        $collection = Collection::make();

        $this->assertFalse(isset($collection[0]));
        $this->assertEmpty($collection[0]);
    }

    public function testShouldGenerateIteratorFromItems(): void
    {
        $collection = Collection::make([1, 2, 3]);

        $iterator = $collection->getIterator();

        $this->assertInstanceOf(ArrayIterator::class, $iterator);
    }

    public function testShouldAddItemToCollectionBeginning(): void
    {
        $collection = Collection::make([1, 2, 3]);
        $collection->prepend(0);

        $this->assertEquals([0, 1, 2, 3], $collection->all());
        $this->assertEquals(0, $collection->first());

        $collection = Collection::make(['aa', 'bb', 'cc']);
        $collection->prepend('ddd');

        $this->assertEquals(['ddd', 'aa', 'bb', 'cc'], $collection->all());
        $this->assertEquals('ddd', $collection->first());
    }

    public function testShouldAddItemToCollectionEnding(): void
    {
        $collection = Collection::make([1, 2, 3]);
        $collection->add(0);

        $this->assertEquals([1, 2, 3, 0], $collection->all());
        $this->assertEquals(1, $collection->first());

        $collection = Collection::make(['aa', 'bb', 'cc']);
        $collection->add('dd');

        $this->assertEquals(['aa', 'bb', 'cc', 'dd'], $collection->all());
        $this->assertEquals('aa', $collection->first());
    }

    public function testShouldAddItemToBeginningInEmptyCollection(): void
    {
        $collection = new Collection();

        $collection->prepend(1);

        $this->assertEquals(1, $collection->first());
        $this->assertEquals([1], $collection->all());
    }

    public function testShouldThrowExceptionWhenCreatingObjectIfTypeIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid item type, expected Tests\Unit\Collections\App\Collections\Collection, given integer');

        new class([1, 2, 3]) extends Collection
        {

            protected string $allowedType = App\Collections\Collection::class;
        };
    }

    public function testShouldThrowExceptionWhenAddingItemIfTypeIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid item type, expected Tests\Unit\Collections\App\Collections\Collection, given integer');

        $object = new class([]) extends Collection
        {

            protected string $allowedType = App\Collections\Collection::class;
        };

        $object->add(1);
    }

    public function testShouldThrowExceptionWhenPrependingItemIfTypeIsInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid item type, expected Tests\Unit\Collections\App\Collections\Collection, given integer');

        $object = new class([]) extends Collection
        {

            protected string $allowedType = App\Collections\Collection::class;
        };

        $object->prepend(1);
    }

    public function testShouldNotThrowExceptionWhenItemTypeIsValid(): void
    {
        $object = new class([new Collection([])]) extends Collection
        {

            protected string $allowedType = \App\Collections\Collection::class;
        };

        $this->assertInstanceOf(Collection::class, $object->first());
    }

    public function testShouldMapCollectionCorrectly(): void
    {
        $collection = new Collection([1, 2, 3]);

        $collection = $collection->map(fn($item) => $item * 2);

        $this->assertEquals(new Collection([2, 4, 6]), $collection);
    }

    public function testShouldFilterCollectionCorrectly(): void
    {
        $collection = new Collection([1, 2, 3]);

        $collection = $collection->filter(fn($item) => $item > 1);

        $this->assertEquals(new Collection([1 => 2, 2 => 3]), $collection);
    }
}
