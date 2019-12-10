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

namespace App\Tool;

/**
 * @template-extends \ArrayIterator<string, Link>
 */
class Links extends \ArrayIterator
{
    /**
     * @var string
     */
    protected $currentUrl = '';

    /**
     * @var Link
     */
    protected $current;
    /**
     * @var Link
     */
    protected $disable;

    public function __construct(string $name, string $url)
    {
        parent::__construct();
        $this->disable = new Link('#');
        $this->current = new Link('');
        $this->addLink($name, $url);
        $this->currentUrl = $url;
    }

    /**
     * addLink.
     *
     * @return self<string,Link>
     */
    public function setCurrentUrl(string $url): self
    {
        $this->currentUrl = $url;

        return $this;
    }

    /**
     * addLink.
     *
     * @return self<string,Link>
     */
    public function addLink(string $name, string $url = ''): self
    {
        $this[mb_strtolower($name)] = new Link($url);

        return $this;
    }

    /**
     * removeLink.
     *
     * @return self<string,Link>
     */
    public function removeLink(string $name): self
    {
        unset($this[mb_strtolower($name)]);

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
        if (!parent::offsetExists(mb_strtolower($offset))) {
            return $this->disable;
        }

        $link = parent::offsetGet(mb_strtolower($offset));

        if ($link->getUrl() === $this->currentUrl) {
            return $this->current;
        }

        return $link;
    }
}
