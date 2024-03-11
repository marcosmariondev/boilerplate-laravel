<?php

declare(strict_types=1);

namespace App\Collections;

class PaginatedCollection extends Collection
{
    public function __construct(
        array $items,
        private int $currentPage,
        private int $totalPages,
        private int $totalItems = 0
    ) {
        parent::__construct($items);

        $this->currentPage = $currentPage;
        $this->totalPages = $totalPages;
        $this->totalItems = $totalItems;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function getPreviousPage(): ?int
    {
        return $this->currentPage > 1 ? $this->currentPage - 1 : null;
    }

    public function getNextPage(): ?int
    {
        return $this->currentPage < $this->totalPages ? $this->currentPage + 1 : null;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function paginationInfo(): array
    {
        return [
            'meta' => [
                'page' => $this->getCurrentPage(),
                'next' => $this->getNextPage(),
                'previous' => $this->getPreviousPage(),
                'total' => $this->getTotalItems(),
            ],
        ];
    }
}
