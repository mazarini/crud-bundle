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

namespace Mazarini\ToolsBundle\Data;

/**
 * @template-extends \ArrayIterator<string, LinkInterface>
 */
class LinkTree extends \ArrayIterator implements LinkInterface
{
    use LinkTrait;

    /**
     * @var bool
     */
    protected $active = false;

    /**
     * @var bool
     */
    protected $disable = false;

    public function __construct(string $name, string $label = '')
    {
        $this->name = $name;
        $this->url = '#';
        if ('' === $label) {
            $this->label = ucfirst($name);
        } else {
            $this->label = $label;
        }
    }

    public function active(): self
    {
        $this->active = true;
        $this->disable = false;

        return $this;
    }

    public function disable(): self
    {
        $this->active = false;
        $this->disable = true;

        return $this;
    }

    public function getClass(): string
    {
        if ($this->active) {
            return ' active';
        }
        if ($this->disable) {
            return ' disabled';
        }

        return '';
    }

    /**
     * addLink.
     *
     * @return self<string,LinkInterface>
     */
    public function addLink(LinkInterface $link): self
    {
        $this[$link->getName()] = $link;

        return $this;
    }
}
