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

use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\EntityTrait;

/**
 * @template-extends \ArrayIterator<int,mixed>
 */
class Entity extends \ArrayIterator implements EntityInterface
{
    use EntityTrait;

    public function __construct(?int $id = null)
    {
        if (null !== $id) {
            $this->id = $id;
        }
        $array = [];
        for ($i = 1; $i <= 9; ++$i) {
            $array[$i] = $this->get($i);
        }
        parent::__construct($array);
    }

    /**
     * offsetGet.
     *
     * @param string|int $offset
     *
     * @return string|int
     */
    public function offsetGet($offset)
    {
        if ('id' === $offset) {
            return $this->id;
        }

        return parent::offsetGet($offset);
    }

    public function init(): self
    {
        for ($i = 1; $i <= 9; ++$i) {
            $this[$i] = $this->get($i);
        }

        return $this;
    }

    public function getCol1(): string
    {
        return $this->get(1);
    }

    public function getCol2(): string
    {
        return $this->get(2);
    }

    public function getCol3(): string
    {
        return $this->get(3);
    }

    public function getCol4(): string
    {
        return $this->get(4);
    }

    public function getCol5(): string
    {
        return $this->get(5);
    }

    public function getCol6(): string
    {
        return $this->get(6);
    }

    public function getCol7(): string
    {
        return $this->get(7);
    }

    public function getCol8(): string
    {
        return $this->get(8);
    }

    public function getCol9(): string
    {
        return $this->get(9);
    }

    protected function get(int $i): string
    {
        return sprintf('row %02d / col %02d', $this->id, $i);
    }
}
