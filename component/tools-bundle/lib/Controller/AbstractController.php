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

namespace Mazarini\ToolsBundle\Controller;

use Mazarini\PaginationBundle\Repository\EntityRepositoryAbstract;
use Mazarini\ToolsBundle\Entity\ChildEntityInterface;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\ParentEntityInterface;

abstract class AbstractController extends ActionControllerAbstract
{
    /**
     * @var array<string,mixed>
     */
    protected $parentParameters;

    protected function setEntity(EntityInterface $entity): void
    {
        $this->data->setEntity($entity);
        if ($entity instanceof ChildEntityInterface) {
            $this->setParentEntity($entity->getParent());
        }
    }

    protected function setParentEntity(?ParentEntityInterface $parentEntity, ?EntityRepositoryAbstract $repository = null): void
    {
        if ($parentEntity instanceof ParentEntityInterface) {
            $this->parentParameters = ['id' => $parentEntity->getId()];
            $this->linkGenerator->setParentParameters($this->parentParameters);
            $this->data->setParentEntity($parentEntity);
            if (null !== $repository) {
                if (method_exists($repository, 'setParentEntity')) {
                    $repository->setParentEntity($parentEntity);
                }
            }
        }
    }
}
