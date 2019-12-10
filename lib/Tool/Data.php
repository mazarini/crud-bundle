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

use Mazarini\CrudBundle\Pagination\Pagination;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Data
{
    /**
     * @var UrlGeneratorInterface
     */
    private $router;
    /**
     * @var string
     */
    private $baseRoute;

    /**
     * @var string
     */
    private $currentRoute;

    /**
     * @var Pagination
     */
    private $pagination;

    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @var Links
     */
    private $links;

    public function __construct(UrlGeneratorInterface $router, string $baseRoute, string $currentRoute, string $currentUrl)
    {
        $this->router = $router;
        $this->baseRoute = $baseRoute;
        $this->currentRoute = $currentRoute;
        $this->links = new Links($currentRoute, $currentUrl);
    }

    public function isSetEntities(): bool
    {
        return isset($this->pagination);
    }

    /**
     * Get the value of entities.
     *
     * @return \ArrayIterator<int,EntityInterface>
     */
    public function getEntities(): \ArrayIterator
    {
        return $this->pagination->getEntities();
    }

    /**
     * Get the value of entities.
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * Set the value of pagination.
     */
    public function setPagination(Pagination $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * IsSet the value of entity ?
     */
    public function isSetEntity(): bool
    {
        return isset($this->entity);
    }

    /**
     * Get the value of entity.
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * Set the value of entity.
     */
    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get the value of links.
     */
    public function getLinks(): Links
    {
        return $this->links;
    }

    /**
     * addLink.
     *
     * @param array<string,mixed> $parameters
     */
    public function addLink(string $name, string $route, array $parameters = [], int $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH): self
    {
        if ('_' === mb_substr($route, 0, 1)) {
            $route = $this->baseRoute.$route;
        }
        $this->links->addLink(trim($name, '_'), $this->router->generate($route, $parameters, $referenceType));

        return $this;
    }

    /**
     * Get the value of currentRoute.
     */
    public function getCurrentRoute(): string
    {
        return trim($this->currentRoute, '_');
    }

    /**
     * Get the value of Route.
     */
    public function getRoute(string $route): string
    {
        return trim($this->baseRoute).$route;
    }
}
