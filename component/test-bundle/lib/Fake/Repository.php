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

namespace Mazarini\TestBundle\Fake;

use Mazarini\PaginationBundle\Repository\ObjectRepositoryAbstract;
use Mazarini\PaginationBundle\Tool\PaginationInterface;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use ReflectionClass;
use ReflectionProperty;

class Repository extends ObjectRepositoryAbstract
{
    /**
     * @var int
     */
    protected $totalCount;

    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    public function __construct()
    {
    }

    public function getPage(int $currentPage = 1, int $totalCount = 60): PaginationInterface
    {
        $this->totalCount = $totalCount;

        return parent::getPage($currentPage, 10);
    }

    /**
     * find.
     *
     * @param int  $id
     * @param bool $lockMode
     * @param bool $lockVersion
     */
    public function find($id, $lockMode = null, $lockVersion = null): Entity
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

    /*
     * totalCount.
     */
    protected function totalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * getResult.
     *
     * @return array<int, EntityInterface>
     */
    protected function getResult(int $start, int $pageSize): array
    {
        $entities = [];
        for ($i = $start + 1; $i <= min($this->totalCount, $start + $pageSize); ++$i) {
            $entities[] = $this->find($i);
        }

        return $entities;
    }
}
