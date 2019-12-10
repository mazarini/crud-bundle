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

namespace App\Pagination;

 /*
  * manage data :
  *     - entities
  *     - counters :
  *         . total entities avalaible
  *         . total pages avalaible
  *         . total entities of page.
  */

use Mazarini\ToolsBundle\Entity\EntityInterface;

class Entities
{
    /**
     * @var \ArrayIterator<int,EntityInterface>
     */
    private $entities;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * @var int
     */
    private $pageSize;

    /**
     * __construct.
     *
     * @param \Traversable<mixed, mixed> $entities
     *
     * @return void
     */
    public function __construct(\Traversable $entities, int $totalCount, int $pageSize)
    {
        $this->entities = new \ArrayIterator();
        foreach ($entities as $entity) {
            $this->entities[] = $entity;
        }
        $this->totalCount = $totalCount;
        $this->pageSize = $pageSize;
    }

    /**
     * getEntities.
     *
     * @return ArrayIterator<int,EntityInterface>
     */

    /**
     * getEntities.
     *
     * @return \ArrayIterator<int,EntityInterface>
     */
    public function getEntities(): \ArrayIterator
    {
        return $this->entities;
    }

    /**
     * count.
     */
    public function count(): int
    {
        return \count($this->entities);
    }

    /**
     *  pagesCount.
     */
    protected static function PAGES_COUNT(int $pageSize, int $totalCount): int
    {
        return (int) ceil($totalCount / $pageSize);
    }

    protected function pagesCount(): int
    {
        return self::PAGES_COUNT($this->pageSize, $this->totalCount);
    }
}
