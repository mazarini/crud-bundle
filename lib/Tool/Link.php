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

namespace Mazarini\CrudBundle\Tool;

class Link
{
    /**
     * @var string
     */
    protected $url = '';

    public function __construct(string $url = '#')
    {
        $this->url = $url;
    }

    public function setUrl(string $url = ''): self
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setCurrent(): self
    {
        $this->url = '';

        return $this;
    }

    public function isCurrent(): bool
    {
        return '' === $this->url;
    }

    public function disable(): self
    {
        return $this->setUrl('#');
    }

    public function isAble(): bool
    {
        return '#' !== $this->url;
    }

    public function getClass(): string
    {
        if ($this->isCurrent()) {
            return ' active';
        }
        if ($this->isAble()) {
            return '';
        }

        return ' disabled';
    }
}
