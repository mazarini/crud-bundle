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

namespace Mazarini\ToolsBundle\Twig;

use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LinkExtension extends AbstractExtension
{
    /**
     * @var UrlGeneratorInterface
     */
    protected $urlGenerator;

    /**
     * @var string
     */
    protected $currentUrl = '';

    /**
     * @var string
     */
    protected $baseRoute = '';

    /**
     * @var array<string,mixed>
     */
    protected $parentParameters = [];

    /**
     * Constructor.
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * getFunctions.
     *
     * @return array<int,TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('entityLink', [$this, 'getEntityLink']),
            new TwigFunction('indexLink', [$this, 'getIndexLink']),
            new TwigFunction('pageLink', [$this, 'getPageLink']),
            new TwigFunction('childLink', [$this, 'getChildLink']),
            new TwigFunction('disableLink', [$this, 'getDisableLink']),
            new TwigFunction('link', [$this, 'getLink']),
        ];
    }

    /**
     * getEntityLink.
     */
    public function getEntityLink(string $label, string $route, EntityInterface $entity): Link
    {
        return $this->getLink($label, $route, ['id' => $entity->getId()]);
    }

    /**
     * getIndexLink.
     */
    public function getIndexLink(string $label = '1'): Link
    {
        return $this->getPageLink(1, $label);
    }

    /**
     * getPageLink.
     */
    public function getPageLink(int $page, string $label = ''): Link
    {
        return $this->getChildLink($label, '_page', ['page' => $page]);
    }

    /**
     * getChildLink.
     *
     * @param array<string,mixed> $parameters
     */
    public function getChildLink(string $label, string $route, array $parameters = []): Link
    {
        $parameters = array_merge($parameters, $this->parentParameters);

        return $this->getLink($label, $route, $parameters);
    }

    /**
     * getLink.
     *
     * @param array<string,mixed> $parameters
     */
    public function getLink(string $label, string $route, array $parameters = []): Link
    {
        if ('/' === mb_substr($route, 0, 1) || '#' === $route) {
            $url = $route;
        } else {
            $url = $this->generateUrl($route, $parameters);
        }
        $name = mb_strtolower(str_replace(' ', '_', $label));

        return new Link($label, $url, $label);
    }

    /**
     * getDisableLink.
     */
    public function getDisableLink(string $label): Link
    {
        return $this->getLink($label, '#');
    }

    /**
     * generateUrl.
     *
     * @param array<string,mixed> $parameters
     */
    private function generateUrl(string $route, array $parameters = []): string
    {
        if ('_' === mb_substr($route, 0, 1)) {
            $route = $this->baseRoute.$route;
        }

        try {
            $url = $this->urlGenerator->generate($route, $parameters);
        } catch (\Exception $e) {
            $url = '#';
        }

        return $url === $this->currentUrl ? '' : $url;
    }

    /**
     * Set the value of Currenturl.
     */
    public function setCurrentUrl(string $currentUrl): self
    {
        $this->currentUrl = $currentUrl;

        return $this;
    }

    /**
     * Set the value of baseRoute.
     */
    public function setBaseRoute(string $baseRoute): self
    {
        $this->baseRoute = $baseRoute;

        return $this;
    }

    /**
     * Set the value of parentParameters.
     *
     * @param array<string,mixed>|int $parentParameters
     */
    public function setParentParameters($parentParameters): self
    {
        if (\is_array($parentParameters)) {
            $this->parentParameters = $parentParameters;
        } else {
            $this->parentParameters = ['id' => $parentParameters];
        }

        return $this;
    }
}
