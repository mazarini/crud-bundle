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

use Mazarini\TestBundle\Factory\DataFactory;
use Mazarini\ToolsBundle\Data\Data;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DataExtension extends AbstractExtension
{
    /**
     * @var DataFactory
     */
    protected $dataFactory;

    /**
     * Constructor.
     */
    public function __construct(DataFactory $dataFactory)
    {
        $this->dataFactory = $dataFactory;
    }

    /**
     * getFunctions.
     *
     * @return array<int,TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('dataCrud', [$this, 'getDataCrud']),
            new TwigFunction('dataPagination', [$this, 'getDataPagination']),
        ];
    }

    /**
     * getLinksSample.
     */
    public function getDataPagination(int $currentPage, int $count = 10, int $totalCount = 0, int $pageSize = 10): Data
    {
        return $this->dataFactory->getDataPagination($currentPage, $count, $totalCount, $pageSize);
    }

    /**
     * getLinksSample.
     */
    public function getDataCrud(string $action, int $id = 1): Data
    {
        return $this->dataFactory->getDataCrud($action, $id);
    }
}
