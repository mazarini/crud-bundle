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

use App\Entity\Zero;
use App\Form\ZeroType;
use App\Repository\ZeroRepository;
use Mazarini\CrudBundle\Controller\CrudControllerAbstract;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/zero")
 */
class ZeroController extends CrudControllerAbstract
{
    /**
     * @Route("/", name="zero_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->indexAction();
    }

    /**
     * @Route("/page-{page<[1-9]\d*>}.html", name="zero_page", methods={"GET"})
     */
    public function page(ZeroRepository $ZeroRepository, int $page = 1): Response
    {
        return $this->PageAction($ZeroRepository, $page);
    }

    /**
     * @Route("/new.html", name="zero_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        return $this->editAction($request, new Zero(), ZeroType::class);
    }

    /**
     * @Route("/show-{id<[1-9]\d*>}.html", name="zero_show", methods={"GET"})
     */
    public function show(Zero $entity): Response
    {
        return $this->showAction($entity);
    }

    /**
     * @Route("/edit-{id<[1-9]\d*>}.html", name="zero_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Zero $entity): Response
    {
        return $this->editAction($request, $entity, ZeroType::class);
    }

    /**
     * delete.
     *
     * @Route("/delete-{id<[1-9]\d*>}.html", name="zero_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Zero $entity): Response
    {
        return $this->deleteAction($request, $entity);
    }
}
