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

namespace Mazarini\ToolsBundle\Controller;

use Mazarini\ToolsBundle\Twig\LinkExtension;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

abstract class RequestControllerAbstract extends AbstractController
{
    /**
     * @var ?string
     */
    private $twigFolder = null;

    /**
     * @var ?string
     */
    private $baseRoute = null;

    /**
     * @var ?string
     */
    private $action = null;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var LinkExtension
     */
    protected $linkGenerator;

    /**
     * @var string
     */
    protected $method = '';

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function setLinkExtension(LinkExtension $linkExtension): void
    {
        $this->linkGenerator = $linkExtension;
        $linkExtension->setBaseRoute($this->getBaseRoute());
        $linkExtension->setCurrentUrl($this->request->getPathInfo());
    }

    protected function getAction(): string
    {
        if (null === $this->action) {
            $this->action = mb_substr($this->request->attributes->get('_route'), mb_strlen($this->getBaseRoute()) + 1);
        }

        return $this->action;
    }

    protected function getBaseRoute(): string
    {
        if (null === $this->baseRoute) {
            $this->baseRoute = explode('_', $this->request->attributes->get('_route'))[0];
        }

        return $this->baseRoute;
    }

    protected function getRoute(string $action): string
    {
        return trim($this->getBaseRoute().'_'.trim($action, '_'), '_');
    }

    protected function getTwigFolder(): string
    {
        if (null === $this->twigFolder) {
            $this->twigFolder = $this->getBaseRoute().'/';
        }

        return $this->twigFolder;
    }
}
