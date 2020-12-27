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

namespace Mazarini\ToolsBundle\Data;

use Mazarini\PaginationBundle\Tool\PaginationInterface;
use Mazarini\ToolsBundle\Entity\ChildEntityInterface;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\ParentEntityInterface;
use Symfony\Component\Form\FormView;

class Data
{
    /**
     * @var string
     */
    private $currentAction;

    /**
     * @var FormView
     */
    private $FormView;

    /**
     * @var ParentEntityInterface
     */
    private $parentEntity;

    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @var PaginationInterface
     */
    private $pagination;

    /**
     * Get the value of currentAction.
     */
    public function getCurrentAction(): string
    {
        return $this->currentAction;
    }

    /**
     * Set the value of currentAction.
     */
    public function setCurrentAction(string $currentAction): self
    {
        $this->currentAction = $currentAction;

        return $this;
    }

    /**
     * IsSet the value of entity ?
     */
    public function isSetEntity(): bool
    {
        return isset($this->entity);
    }

    public function isSetEntities(): bool
    {
        return isset($this->pagination);
    }

    /**
     * Get the value of entities.
     *
     * @return \ArrayIterator<int,EntityInterface>
     */
    public function getEntities(): \ArrayIterator
    {
        return $this->pagination->getEntities();
    }

    /**
     * Get the value of entities.
     */
    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }

    /**
     * Set the value of pagination.
     */
    public function setPagination(PaginationInterface $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * Get the value of entity.
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * Set the value of entity.
     */
    public function setEntity(EntityInterface $entity): self
    {
        $this->entity = $entity;
        if ($entity instanceof ChildEntityInterface) {
            $this->parentEntity = $entity->getParent();
        }

        return $this;
    }

    /**
     * Get the value of entity.
     */
    public function getParentEntity(): ParentEntityInterface
    {
        return $this->parentEntity;
    }

    /**
     * Set the value of entity.
     */
    public function setParentEntity(ParentEntityInterface $parentEntity): self
    {
        $this->parentEntity = $parentEntity;

        return $this;
    }

    /**
     * Get the value of FormView.
     */
    public function isSetFormView(): bool
    {
        return isset($this->FormView);
    }

    /**
     * Get the value of FormView.
     */
    public function getFormView(): FormView
    {
        return $this->FormView;
    }

    /**
     * Set the value of FormView.
     */
    public function setFormView(FormView $FormView): self
    {
        $this->FormView = $FormView;

        return $this;
    }
}
