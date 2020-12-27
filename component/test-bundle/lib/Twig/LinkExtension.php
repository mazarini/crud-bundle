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

use Mazarini\TestBundle\Factory\LinkFactory;
use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Data\Links;
use Mazarini\ToolsBundle\Data\LinkTree;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LinkExtension extends AbstractExtension
{
    /**
     * @var LinkFactory
     */
    protected $linkFactory;

    /**
     * Constructor.
     */
    public function __construct(LinkFactory $linkFactory)
    {
        $this->linkFactory = $linkFactory;
    }

    /**
     * getFunctions.
     *
     * @return array<int,TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('linkActive', [$this, 'getLinkActive']),
            new TwigFunction('linkDisable', [$this, 'getlinkDisable']),
            new TwigFunction('linkStandard', [$this, 'getlinkStandard']),
            new TwigFunction('linksSample', [$this, 'getLinksSample']),
            new TwigFunction('treeSample', [$this, 'getTreeSample']),
        ];
    }

    /**
     * getLinksSample.
     */
    public function getLinksSample(): Links
    {
        return $this->linkFactory->getLinksSample();
    }

    /**
     * getTreeSample.
     */
    public function getTreeSample(): LinkTree
    {
        return $this->linkFactory->getTreeSample();
    }

    /**
     * getLinkActive.
     */
    public function getLinkActive(string $label = 'Active'): Link
    {
        return new Link('active', '', $label);
    }

    /**
     * getLinkDisable.
     */
    public function getLinkDisable(string $label = 'Disable'): Link
    {
        return new Link('disable', '#', $label);
    }

    /**
     * getLinkStandard.
     */
    public function getLinkStandard(string $label = 'Standard'): Link
    {
        return new Link('standard', '/standard', $label);
    }
}
