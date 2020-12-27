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

use Mazarini\TestBundle\Fake\Entity;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use ReflectionClass;
use ReflectionProperty;

class EntityFactory
{
    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    public function getEntity(int $id = 0): Entity
    {
        if (!isset($this->reflectionProperty)) {
            $reflectionClass = new ReflectionClass(Entity::class);
            $this->reflectionProperty = $reflectionClass->getProperty('id');
            $this->reflectionProperty->setAccessible(true);
        }
        $entity = new Entity();
        $this->reflectionProperty->setValue($entity, $id);
        if (method_exists($entity, 'init')) {
            $entity->init();
        }

        return $entity;
    }

    /**
     * getEntities.
     *
     * @return array<int,EntityInterface>
     */
    public function getEntities(int $count = 10, int $start = 1): array
    {
        $entities = [];
        $last = $start + $count - 1;
        for ($i = $start; $i <= $last; ++$i) {
            $entities[] = $this->getEntity($i);
        }

        return $entities;
    }
}
