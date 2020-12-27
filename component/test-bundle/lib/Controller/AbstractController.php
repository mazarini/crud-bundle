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

namespace Mazarini\TestBundle\Controller;

use Mazarini\ToolsBundle\Controller\AbstractController as ToolsControllerAbstract;
use Mazarini\ToolsBundle\Twig\LinkExtension;

class AbstractController extends ToolsControllerAbstract
{
    /**
     * @var LinkExtension
     */
    protected $linkExtension;

    public function setLinkExtension(LinkExtension $linkExtension): void
    {
        $this->parameters['linkExtension'] = $this->linkExtension = $linkExtension;
        $linkExtension->setBaseRoute($this->getBaseRoute());
        $linkExtension->setParentParameters(['parent' => 12]);
    }
}
