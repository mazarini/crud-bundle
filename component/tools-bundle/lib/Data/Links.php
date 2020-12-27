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
 * @template-extends \ArrayIterator<string, Link>
 */
class Links extends \ArrayIterator
{
    /**
     * @var string
     */
    private $currentUrl;

    public function __construct(string $currentUrl)
    {
        parent::__construct();
        $this->currentUrl = $currentUrl;
    }

    /**
     * Get the value of currentUrl.
     */
    public function getCurrentUrl(): string
    {
        return $this->currentUrl;
    }

    public function setCurrentUrl(string $currentUrl): self
    {
        $this->currentUrl = $currentUrl;

        return $this;
    }

    /**
     * addLink.
     *
     * @return self<string,Link>
     */
    public function addLink(Link $link): self
    {
        $this[$link->getName()] = $link;

        return $this;
    }

    /**
     * offsetExists.
     *
     * @param string $offset
     */
    public function offsetExists($offset): bool
    {
        return true;
    }

    /**
     * offsetGet.
     *
     * @param string $offset
     *
     * @return Link
     */
    public function offsetGet($offset)
    {
        if (parent::offsetExists($offset)) {
            $link = parent::offsetGet($offset);
            if ($link->getUrl() === $this->currentUrl) {
                $link = new Link($offset, '', $link->getLabel());
            }
        } elseif ('current' === $offset) {
            $link = new Link($offset, $this->currentUrl);
        } else {
            $link = new Link($offset, '#');
        }

        return $link;
    }

    /**
     * current.
     *
     * @return Link
     */
    public function current()
    {
        return $this->offsetGet($this->key());
    }
}
