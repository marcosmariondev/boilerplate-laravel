<?php

declare(strict_types=1);

namespace Tests\Unit\Collections;

use App\Collections\PaginatedCollection;
use Tests\TestCase;

class PaginatedCollectionTest extends TestCase
{
    public function testShouldGetNullForPreviousPageOnFirstPage(): void
    {
        $paginatedCollection = new PaginatedCollection(
            [1, 2],
            1,
            1,
            2
        );

        $this->assertEquals(null, $paginatedCollection->getPreviousPage());
    }

    public function testShouldGetValidPreviousPage(): void
    {
        $paginatedCollection = new PaginatedCollection(
            [1, 2],
            2,
            2,
            2
        );

        $this->assertEquals(1, $paginatedCollection->getPreviousPage());
    }

    public function testShouldGetNullForNextPageOnTheLastPage(): void
    {
        $paginatedCollection = new PaginatedCollection(
            [1, 2],
            1,
            1,
            2
        );

        $this->assertEquals(null, $paginatedCollection->getNextPage());
    }

    public function testShouldReturnValidNextPage(): void
    {
        $paginatedCollection = new PaginatedCollection(
            [1, 2],
            1,
            2,
            2
        );

        $this->assertEquals(2, $paginatedCollection->getNextPage());
    }

    public function testShouldGetCorrectParams(): void
    {
        $paginatedCollection = new PaginatedCollection(
            [1, 2],
            1,
            2,
            2
        );

        $this->assertEquals(1, $paginatedCollection->getCurrentPage());
        $this->assertEquals(2, $paginatedCollection->getTotalPages());
        $this->assertEquals(2, $paginatedCollection->getTotalItems());
        $this->assertEquals([
            'meta' => [
                'page' => 1,
                'next' => 2,
                'previous' => null,
                'total' => 2,
            ],
        ], $paginatedCollection->paginationInfo());
    }
}
