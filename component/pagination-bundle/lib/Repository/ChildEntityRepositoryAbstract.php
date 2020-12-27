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
use Mazarini\ToolsBundle\Entity\ParentEntityInterface;

abstract class ChildEntityRepositoryAbstract extends EntityRepositoryAbstract
{
    /**
     * @var ParentEntityInterface
     */
    protected $parentEntity;

    protected function getPageQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.parentEntity = :parentEntity')
            ->setParameter('parentEntity', $this->parentEntity)
        ;
    }

    /**
     * Set the value of parentEntity.
     */
    public function setParentEntity(ParentEntityInterface $parentEntity): self
    {
        $this->parentEntity = $parentEntity;

        return $this;
    }
}
