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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HomepageSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $homePage;

    /**
     * @var string
     */
    private $homeAdmin;

    public function __construct(string $homePage, string $homeAdmin)
    {
        $this->homePage = $homePage;
        $this->homeAdmin = $homeAdmin;
    }

    /**
     * getSubscribedEvents.
     *
     * @return array<string,string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getThrowable() instanceof NotFoundHttpException && \in_array(trim($event->getRequest()->getPathInfo(), '/'), ['', 'admin'], true)) {
            if ('/' === $event->getRequest()->getPathInfo()) {
                $this->redirectHome($event);
            } else {
                $this->redirectAdmin($event);
            }
        }
    }

    private function redirectAdmin(ExceptionEvent $event): void
    {
        if ('admin' !== trim($this->homeAdmin, '/')) {
            $event->setResponse(new RedirectResponse($this->homeAdmin, Response::HTTP_MOVED_PERMANENTLY));
        }
    }

    private function redirectHome(ExceptionEvent $event): void
    {
        if ('/' !== $this->homePage) {
            $event->setResponse(new RedirectResponse($this->homePage, Response::HTTP_MOVED_PERMANENTLY));
        }
    }
}
