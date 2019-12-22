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

use App\Entity\Ten;
use App\Repository\TenRepository;
use Mazarini\PaginationBundle\Controller\AbstractPaginationController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/")
 */
class TenPaginationController extends AbstractPaginationController
{
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router)
    {
        parent::__construct($requestStack, $router, 'ten_page');
        $this->twigFolder = 'ten/';
    }

    /**
     * @Route("/", name="ten_page_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->indexAction();
    }

    /**
     * @Route("/page-{page<[1-9]\d*>}.html", name="ten_page_page", methods={"GET"})
     */
    public function page(TenRepository $TenRepository, int $page = 1): Response
    {
        return $this->PageAction($TenRepository, $page);
    }

    /**
     * @Route("/show-{id<[1-9]\d*>}.html", name="ten_page_show", methods={"GET"})
     */
    public function show(Ten $entity): Response
    {
        return $this->showAction($entity);
    }
}
