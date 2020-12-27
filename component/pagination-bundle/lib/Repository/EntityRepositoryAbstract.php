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

namespace Mazarini\PaginationBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Mazarini\ToolsBundle\Entity\EntityInterface;

abstract class EntityRepositoryAbstract extends ObjectRepositoryAbstract
{
    /**
     * @var string
     */
    protected $orderColumn = 'e.id';

    /**
     * @var string
     */
    protected $orderDirection = 'ASC';

    protected function totalCount(): int
    {
        return $this->getPageQueryBuilder()
                ->select('count(e.id)')
                ->getQuery()
                ->getSingleScalarResult();
    }

    /**
     * getResult.
     *
     * @return array<int, EntityInterface>
     */
    protected function getResult(int $start, int $pageSize): array
    {
        $result = $this->getPageQueryBuilder()
                ->orderBy($this->orderColumn, $this->orderDirection)
                ->setFirstResult($start)
                ->setMaxResults($pageSize)
                ->getQuery()
                ->getResult();

        return $result;
    }

    protected function getPageQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('e');
    }
}
