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

namespace Mazarini\ToolsBundle\EventSubscriber;

use Mazarini\ToolsBundle\Data\LinkTree;
use Mazarini\ToolsBundle\Twig\LinkExtension;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerSubscriber implements EventSubscriberInterface
{
    /**
     * @var LinkExtension
     */
    private $linkExtension;

    /**
     * @var LinkTree
     */
    private $menu;

    public function __construct(LinkExtension $linkExtension, ?LinkTree $menu = null)
    {
        $this->linkExtension = $linkExtension;
        if (null === $menu) {
            $this->menu = new LinkTree('main', 'Menu');
        } else {
            $this->menu = $menu;
        }
    }

    /**
     * getSubscribedEvents.
     *
     * @return array<string,string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
            KernelEvents::CONTROLLER_ARGUMENTS => 'onControllerArguments',
        ];
    }

    /**
     * onKernelController.
     *
     * see KernelEvent => ($kernel, $request, $requestType)
     * and ControllerEvent => ($controller)
     */
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (\is_array($controller)) {
            $controller = $controller[0];
        }
        if (method_exists($controller, 'setRequest')) {
            $controller->setRequest($event->getRequest());
        }
        if (method_exists($controller, 'setLinkExtension')) {
            $controller->setLinkExtension($this->linkExtension);
        }
    }

    /**
     * onControllerArguments.
     *
     * see KernelEvent => ($kernel, $request, $requestType)
     * and ControllerEvent => ($controller,$arguments)
     */
    public function onControllerArguments(ControllerArgumentsEvent $event): void
    {
        $arguments = $event->getArguments();
        $controller = $event->getController();
        if (\is_array($controller) && isset($controller[0])) {
            $method = $controller[1];
            $controller = $controller[0];
        } else {
            $method = '';
        }
        if (method_exists($controller, 'beforeAction')) {
            $controller->beforeAction($method, $arguments);
        }
        $before = 'beforeAction'.$method;
        if ('' !== $method && method_exists($controller, 'beforeAction'.$method)) {
            $controller->beforeAction($method, $arguments);
        }
        if (method_exists($controller, 'setMenu')) {
            $controller->setMenu($this->menu);
        }
    }
}
