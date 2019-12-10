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

namespace App\Controller;

use App\Entity\Five;
use App\Form\FiveType;
use App\Repository\FiveRepository;
use Mazarini\CrudBundle\Controller\AbstractCrudController;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/five")
 */
class FiveController extends AbstractCrudController
{
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router)
    {
        parent::__construct($requestStack, $router, 'five');
        $this->twigFolder = 'five/';
    }

    /**
     * @Route("/", name="five_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->indexAction();
    }

    /**
     * @Route("/page-{page<[1-9]\d*>}.html", name="five_page", methods={"GET"})
     */
    public function page(FiveRepository $FiveRepository, int $page = 1): Response
    {
        return $this->PageAction($FiveRepository, $page);
    }

    /**
     * @Route("/new.html", name="five_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        return $this->editAction($request, new Five(), FiveType::class);
    }

    /**
     * @Route("/show-{id<[1-9]\d*>}.html", name="five_show", methods={"GET"})
     */
    public function show(Five $entity): Response
    {
        return $this->showAction($entity);
    }

    /**
     * @Route("/edit-{id<[1-9]\d*>}.html", name="five_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Five $entity): Response
    {
        return $this->editAction($request, $entity, FiveType::class);
    }

    /**
     * delete.
     *
     * @Route("/delete-{id<[1-9]\d*>}.html", name="five_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Five $entity): Response
    {
        return $this->deleteAction($request, $entity);
    }

    protected function valid(EntityInterface $entity): bool
    {
        return true;
    }
}
