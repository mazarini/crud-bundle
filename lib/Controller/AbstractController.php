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

namespace Mazarini\CrudBundle\Controller;

use Mazarini\CrudBundle\Tool\Data;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyControler;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractController extends SymfonyControler
{
    /**
     * @var string
     */
    protected $twigFolder = '';

    /**
     * @var Data
     */
    protected $data;

    /**
     * @var array<string,mixed>
     */
    protected $parameters;

    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router, string $baseRoute)
    {
        $base = '';
        $currentUrl = '';
        $current = '';
        $request = $requestStack->getMasterRequest();
        if (null !== $request) {
            $currentUrl = $request->getPathInfo();
            $current = $request->attributes->get('_route');
            if (mb_substr($current, 0, mb_strlen($baseRoute)) === $baseRoute) {
                $base = $baseRoute;
                $current = mb_substr($current, mb_strlen($baseRoute));
            }
        }

        $this->data = new Data($router, $base, $current, $currentUrl);
        $this->parameters['data'] = $this->data;
    }

    /**
     * DataRender.
     *
     * @param array<string,mixed> $parameters
     */
    protected function dataRender(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters = array_merge($this->parameters, $parameters);
        $this->initUrl($this->data);

        return $this->render($this->twigFolder.$view, $parameters, $response);
    }

    abstract protected function initUrl(Data $data): self;
}
