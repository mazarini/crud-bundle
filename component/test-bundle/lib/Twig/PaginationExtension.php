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

namespace Mazarini\TestBundle\Twig;

use Mazarini\PaginationBundle\Tool\Pagination;
use Mazarini\TestBundle\Factory\PaginationFactory;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PaginationExtension extends AbstractExtension
{
    /**
     * @var PaginationFactory
     */
    protected $paginationFactory;

    /**
     * Constructor.
     */
    public function __construct(PaginationFactory $paginationFactory)
    {
        $this->paginationFactory = $paginationFactory;
    }

    /**
     * getFilters.
     *
     * @return array<int,TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('paginationFactory', [$this, 'getPaginationFactory']),
        ];
    }

    /**
     * getPaginationFactory.
     */
    public function getPaginationFactory(int $currentPage, int $count = 10, int $totalCount = 0, int $pageSize = 10): Pagination
    {
        return $this->paginationFactory->getPagination($currentPage, $count, $totalCount, $pageSize);
    }
}
