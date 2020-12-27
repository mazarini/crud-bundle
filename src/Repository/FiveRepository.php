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

namespace App\Repository;

use App\Entity\Five;
use Doctrine\Persistence\ManagerRegistry;
use Mazarini\PaginationBundle\Repository\EntityRepositoryAbstract;

/**
 * @method Five|null find($id, $lockMode = null, $lockVersion = null)
 * @method Five|null findOneBy(array $criteria, array $orderBy = null)
 * @method Five[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiveRepository extends EntityRepositoryAbstract
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Five::class);
    }
}
