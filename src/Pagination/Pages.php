<?php

/*
 * Copyright (C) 2019 Mazarini <mazarini@protonmail.com>.
 * This file is part of mazarini/crud-bundle.
 *
 * mazarini/crud-bundle is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.
 *
 * mazarini/crud-bundle is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
 * more details.
 *
 * You should have received a copy of the GNU General Public License
 */

namespace App\Pagination;

class Pages extends Entities
{
    /**
     * @var int
     */
    protected $currentPage;

    /**
     * __construct.
     *
     * @param \Traversable<mixed, mixed> $entities
     */
    public function __construct(\Traversable $entities, int $currentPage, int $totalCount, int $pageSize)
    {
        parent::__construct($entities, $totalCount, $pageSize);
        /*
         * Current page is between first and last page
         * Page #1 can be empty when there is no data
         */
        $this->currentPage = self::CURRENT_PAGE($currentPage, $pageSize, $totalCount);
    }

    public static function CURRENT_PAGE(int $currentPage, int $pageSize, int $totalCount): int
    {
        return max(1, min($currentPage, self::PAGES_COUNT($pageSize, $totalCount)));
    }

    public function getFirstPage(): int
    {
        return 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): int
    {
        return max(1, $this->pagesCount());
    }
}
