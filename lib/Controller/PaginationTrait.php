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

use Mazarini\ToolsBundle\Data\Data;

trait PaginationTrait
{
    /**
     * getPageParameters.
     *
     * @return array<string,string>
     */
    protected function getPageParameters(): array
    {
        return [];
    }

    /**
     * getCrudAction.
     *
     * @return array<string,string>
     */
    protected function getCrudAction(): array
    {
        return ['_show' => 'Afficher'];
    }

    /**
     * getListAction.
     *
     * @return array<string,string>
     */
    protected function getListAction(): array
    {
        return ['_show' => 'Afficher'];
    }

    protected function setUrl(Data $data): void
    {
        $this->setCrudUrl($data);
        $this->setPageUrl($data);
        $this->setListUrl($data);
    }

    /**
     * setCrudUrl.
     */
    protected function setCrudUrl(Data $data): void
    {
        if ($data->isSetEntity()) {
            $entity = $data->getEntity();
            if (!$entity->Isnew()) {
                foreach ($this->getCrudAction() as $action => $label) {
                    $data->addLink(trim($action, '_'), $data->generateUrl($action, ['id' => $entity->getId()]), $label);
                }
            }
        }
    }

    protected function setPageUrl(Data $data): void
    {
        if ($data->isCrud()) {
            $this->AddPageUrl($data, 'index', true, 1, 'Retour');
        }
        if ($data->isSetEntities()) {
            $pagination = $data->getPagination();
            $this->AddPageUrl($data, 'first', $pagination->hasPreviousPage(), $pagination->getFirstPage(), '1');
            $this->AddPageUrl($data, 'previous', $pagination->hasPreviousPage(), $pagination->getPreviousPage(), 'Précédent');
            $this->AddPageUrl($data, 'next', $pagination->hasNextPage(), $pagination->getNextPage(), 'Suivant');
            $this->AddPageUrl($data, 'last', $pagination->hasNextPage(), $pagination->getLastPage(), (string) $pagination->getLastPage());

            for ($i = 1; $i <= $pagination->getLastPage(); ++$i) {
                $this->AddPageUrl($data, 'page-'.$i, true, $i, (string) $i);
            }
        }
    }

    /**
     * setListUrl.
     */
    protected function setListUrl(Data $data): void
    {
        if ($data->isSetEntities()) {
            foreach ($data->getEntities() as $entity) {
                $parameters = ['id' => $entity->getId()];
                foreach ($this->getListAction() as $action => $label) {
                    $data->addLink(trim($action, '_').'-'.$parameters['id'], $data->generateUrl($action, $parameters), $label);
                }
            }
        }
    }

    /**
     * AddPageUrl.
     */
    protected function AddPageUrl(Data $data, string $key, bool $active, int $page, string $label): void
    {
        $url = '#';
        if ($active) {
            $parameters = $this->getPageParameters();
            $parameters['page'] = $page;
            $url = $data->generateUrl('_page', $parameters);
        }
        $data->addLink($key, $url, $label);
    }
}
