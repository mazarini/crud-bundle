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

use Mazarini\ToolsBundle\Data\Data;
use Symfony\Component\HttpFoundation\Response;

abstract class ActionControllerAbstract extends RequestControllerAbstract
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var array<string,mixed>
     */
    protected $parameters = [];

    /**
     * @var string
     */
    protected $method = '';

    /**
     * beforeAction.
     *
     * @param array<int,mixed> $arguments
     */
    public function beforeAction(string $method, array $arguments): void
    {
        $this->data = new Data();
        $this->method = $method;
        $this->data->setCurrentAction($this->getAction());
    }

    protected function afterAction(): void
    {
    }

    protected function beforeRender(): void
    {
    }

    /**
     * DataRender.
     *
     * @param array<string,mixed> $parameters
     */
    protected function dataRender(string $view, array $parameters = [], Response $response = null): Response
    {
        /*
         * Finalize parameters
         */
        $this->parameters['data'] = $this->data;
        $this->parameters = array_merge($this->parameters, $parameters);
        /*
         * After an action and only this one if something planned.
         */
        if ('' !== $this->method) {
            $method = 'afterAction'.ucfirst($this->method);
            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
        /*
         * After all action if something planned
         */
        $this->afterAction();

        $this->beforeRender();

        return $this->render($this->getTwigFolder().$view, $this->parameters, $response);
    }
}
