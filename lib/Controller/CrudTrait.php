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

trait CrudTrait
{
    use PaginationTrait;

    /**
     * getCrudAction.
     *
     * @return array<string,string>
     */
    protected function getCrudAction(): array
    {
        return ['_edit' => 'Modifier', '_show' => 'Afficher', '_delete' => 'Supprimer'];
    }

    /**
     * getListAction.
     *
     * @return array<string,string>
     */
    protected function getListAction(): array
    {
        return ['_edit' => 'Modifier', '_show' => 'Afficher'];
    }

    protected function setUrl(Data $data): void
    {
        $this->setCrudUrl($data);
        $this->setPageUrl($data);
        $this->setListUrl($data);
        $this->setNewUrl($data);
    }

    protected function setNewUrl(Data $data): void
    {
        if ($data->isCrud()) {
            $data->addLink('new', $data->generateUrl('_new', $this->getPageParameters()), 'Ajouter');
        }
    }
}
