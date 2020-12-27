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

namespace Mazarini\TestBundle\Factory;

use Mazarini\TestBundle\Fake\UrlGenerator;
use Mazarini\ToolsBundle\Data\Data;
use Mazarini\ToolsBundle\Twig\LinkExtension;
use ReflectionClass;
use ReflectionProperty;

class DataFactory
{
    /**
     * @var PaginationFactory
     */
    protected $paginationFactory;

    /**
     * @var EntityFactory
     */
    protected $entityFactory;

    /**
     * @var FormFactory
     */
    protected $formFactory;

    /**
     * @var LinkExtension
     */
    protected $linkExtension;

    /**
     * @var UrlGenerator
     */
    protected $urlGenerator;
    /**
     * @var ReflectionProperty
     */
    protected $reflectionProperty;

    public function __construct(FormFactory $formFactory, EntityFactory $entityFactory, PaginationFactory $paginationFactory, UrlGenerator $urlGenerator, LinkExtension $linkExtension)
    {
        $this->entityFactory = $entityFactory;
        $this->paginationFactory = $paginationFactory;
        $this->formFactory = $formFactory;
        $this->linkExtension = $linkExtension;
        $this->urlGenerator = $urlGenerator;
        $reflectionClass = new ReflectionClass(LinkExtension::class);
        $this->reflectionProperty = $reflectionClass->getProperty('urlGenerator');
        $this->reflectionProperty->setAccessible(true);
    }

    public function getDataPagination(int $currentPage, int $count = 10, int $totalCount = 0, int $pageSize = 10): Data
    {
        $data = $this->getData('page', '#FAKE_page-page='.(string) $currentPage);
        $data->setpagination($this->paginationFactory->getPagination($currentPage, $count, $totalCount, $pageSize));
        $data->setCurrentAction('page');

        return $data;
    }

    public function getDataCrud(string $action, int $id = 1): Data
    {
        if ('new' === $action) {
            $id = 0;
            $url = 'FAKE_new';
        } else {
            $url = 'FAKE_'.$action.'-id='.(string) $id;
        }
        $data = $this->getData($action, $url);
        $data->setEntity($this->entityFactory->getEntity($id));
        if ('edit' === $action || 'new' === $action) {
            $data->setFormView($this->formFactory->getFormView());
        }
        $data->setCurrentAction($action);

        return $data;
    }

    public function getData(string $action, string $url): Data
    {
        $data = new Data();
        $data->setCurrentAction($action);
        $this->reflectionProperty->setValue($this->linkExtension, $this->urlGenerator);
        $this->linkExtension->setBaseRoute('FAKE');
        $this->linkExtension->setCurrentUrl($url);

        return $data;
    }
}
