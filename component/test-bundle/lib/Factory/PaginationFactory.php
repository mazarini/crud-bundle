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

namespace Mazarini\TestBundle\Factory;

use Mazarini\PaginationBundle\Tool\Pagination;
use ReflectionProperty;

class PaginationFactory
{
    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    public function getPagination(int $currentPage, int $count = 10, int $totalCount = 0, int $pageSize = 10): Pagination
    {
        $pageSize = $pageSize < $count ? $count : $pageSize;
        $totalCount = $count > $totalCount ? $count : $totalCount;
        $totalCount = 0 === $count ? 0 : $totalCount;
        if (0 === $count) {
            return new pagination(new \ArrayIterator([]), 1, 0, $pageSize);
        }
        $current = Pagination::CURRENT_PAGE($currentPage, $pageSize, $totalCount);
        if ($current !== $currentPage) {
            $totalcount = $currentPage * $pageSize - $pageSize + $count;
        }
        $totalCount = $totalCount + ($currentPage - $current) * $pageSize;

        return new pagination(new \ArrayIterator($this->entityFactory->getEntities($count, 1)), $currentPage, $totalCount, $pageSize);
    }
}
