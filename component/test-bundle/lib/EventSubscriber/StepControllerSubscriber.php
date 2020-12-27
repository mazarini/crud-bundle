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

namespace Mazarini\TestBundle\EventSubscriber;

use Mazarini\TestBundle\Tool\Folder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class StepControllerSubscriber implements EventSubscriberInterface
{
    /**
     * @var Folder
     */
    protected $folder;

    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
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
        if (\is_array($controller) && isset($controller[0])) {
            $controller = $controller[0];
        }
        if (method_exists($controller, 'setFolder')) {
            $controller->setFolder($this->folder);
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
    }
}
