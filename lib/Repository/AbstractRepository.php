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

namespace Mazarini\CrudBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\CountWalker;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Mazarini\CrudBundle\Pagination\Pagination;

abstract class AbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $class)
    {
        parent::__construct($registry, $class);
    }

    public function getPage(int $currentPage = 1, int $pageSize = 10): Pagination
    {
        $query = $this->createQueryBuilder('a')
            ->addSelect('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->setHint(CountWalker::HINT_DISTINCT, false)
            ->setMaxResults($pageSize)
        ;
        $paginator = new DoctrinePaginator($query, true);
        $totalCount = $paginator->count();
        if (0 === $totalCount) {
            return new Pagination(new \ArrayIterator([]), $currentPage, $totalCount, $pageSize);
        }
        $currentPage = Pagination::CURRENT_PAGE($currentPage, $pageSize, $totalCount);
        $query->setFirstResult(($currentPage - 1) * $pageSize);
        $result = $paginator->getIterator();

        return new Pagination($result, $currentPage, $totalCount, $pageSize);
    }
}
