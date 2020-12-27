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

use Mazarini\TestBundle\Tool\Folder;
use Mazarini\ToolsBundle\Data\Link;
use Mazarini\ToolsBundle\Data\LinkTree;
use Mazarini\ToolsBundle\Twig\LinkExtension;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Annotation\Route;

class StepController extends AbstractController
{
    /**
     * @var Folder
     */
    protected $folder;

    /**
     * @var array<string,string>
     */
    protected $steps = [];

    /**
     * @var string
     */
    protected $step = '';

    /**
     * @var array<string,string>
     */
    protected $pages = [];

    /**
     * @var string
     */
    protected $page = '';

    /**
     * @Route("/", name="step_home")
     */
    public function home(): Response
    {
        $step = array_key_first($this->steps);
        if (null === $step) {
            throw $this->createNotFoundException('There is no step');
        }
        $this->addFlash('info', 'Redirect to first step');

        return $this->redirectToRoute('step_home_step', ['step' => $step], Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * @Route("/{step}", name="step_home_step")
     */
    public function homeStep(string $step): Response
    {
        if (!isset($this->steps[$step])) {
            $this->addFlash('danger', sprintf('Step "%s" unknown', $step));

            return $this->redirectToRoute('step_home', [], Response::HTTP_MOVED_PERMANENTLY);
        }
        $page = array_key_first($this->pages);
        if (null === $page) {
            throw $this->createNotFoundException(sprintf('There is no page for step "%s"', $step));
        }

        $this->addFlash('info', sprintf('Redirect to first page of step %s', $step));

        return $this->redirectToRoute('step_index', ['step' => $step, 'page' => $page], Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * @Route("/{step}/{page}.html", name="step_index")
     */
    public function index(string $step, string $page): Response
    {
        if (!isset($this->steps[$step]) || !isset($this->pages[$page])) {
            if (isset($this->steps[$step])) {
                $this->addFlash('danger', sprintf('The page "%s" of step "%s" don\'t exists', $page, $step));
            }

            return $this->redirectToRoute('step_home_step', ['step' => $step], Response::HTTP_MOVED_PERMANENTLY);
        }

        $parameters['step'] = $this->step = $step;
        $parameters['page'] = $this->page = $page;

        return $this->dataRender($this->steps[$step].'/'.$this->pages[$page], $parameters);
    }

    public function setMenu(LinkTree $menu): void
    {
        $this->parameters['menu'] = $menu;
        foreach (array_keys($this->steps) as $step) {
            $link = new LinkTree($step);
            $menu[$step] = $link;
            if ($step === $this->step) {
                $link->active();
                $pages = $this->pages;
            } else {
                $pages = $this->folder->getPages($this->steps[$step]);
            }
            foreach (array_keys($pages) as $page) {
                if (($page === $this->page) && ($step === $this->step)) {
                    $link[$page] = new Link($page, '');
                } else {
                    $link[$page] = new Link($page, $this->generateUrl('step_index', ['step' => $step, 'page' => $page]));
                }
            }
        }
    }

    public function setFolder(Folder $folder): void
    {
        $this->folder = $folder;
    }

    public function setLinkExtension(LinkExtension $linkExtension): void
    {
        parent::setLinkExtension($linkExtension);
        // Add a fake parent parameters to route
        $linkExtension->setParentParameters(['parent' => 12]);
    }

    /**
     * beforeAction.
     *
     * @param array<int,mixed> $arguments
     */
    public function beforeAction(string $method, array $arguments): void
    {
        parent::beforeAction($method, $arguments);
        $this->parameters['steps'] = $this->steps = $this->folder->getSteps();
        if ('home' !== $method) {
            $step = $arguments[0];
            if (isset($this->steps[$step])) {
                $this->parameters['pages'] = $this->pages = $this->folder->getPages($this->steps[$step]);
            }
        }
    }

    protected function beforeRender(): void
    {
        parent::beforeRender();
        $this->parameters['symfony']['version'] = Kernel::VERSION;
        $this->parameters['php']['version'] = PHP_VERSION;
        $this->parameters['php']['extensions'] = get_loaded_extensions();
    }
}
