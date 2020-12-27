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

use Mazarini\TestBundle\Factory\EntityFactory;
use Mazarini\TestBundle\Fake\Entity;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityExtension extends AbstractExtension
{
    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * Constructor.
     */
    public function __construct(EntityFactory $entityFactory)
    {
        $this->entityFactory = $entityFactory;
    }

    /**
     * getFilters.
     *
     * @return array<int,TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('entityFactory', [$this, 'getEntityFactory']),
            new TwigFunction('entitiesFactory', [$this, 'getEntitiesFactory']),
        ];
    }

    /**
     * getEntityFactory.
     */
    public function getEntityFactory(int $id = 0): Entity
    {
        return $this->entityFactory->getEntity($id);
    }

    /**
     * getEntitiesFactory.
     *
     * @return array<int,EntityInterface>
     */
    public function getEntitiesFactory(int $count = 0, int $start = 1): array
    {
        return $this->entityFactory->getEntities($count, $start);
    }
}
