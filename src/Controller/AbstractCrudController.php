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

use App\Tool\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractCrudController extends AbstractPaginationController
{
    public function __construct(RequestStack $requestStack, UrlGeneratorInterface $router, string $baseRoute)
    {
        parent::__construct($requestStack, $router, $baseRoute);
    }

    /**
     * createEntityForm.
     *
     * Creates and returns a Form instance from the type of the form.
     *
     * @param array<int,mixed> $options
     */
    protected function createEntityForm(string $type, EntityInterface $entity = null, array $options = []): Form
    {
        return $this->container->get('form.factory')->createNamed('Entity', $type, $entity, $options);
    }

    protected function crudUrl(Data $data): AbstractController
    {
        if ($data->isSetEntity()) {
            $id = $data->getEntity()->getId();
            if (0 !== $id) {
                $parameters = ['id' => $id];
                foreach (['_edit', '_show', '_delete'] as $action) {
                    $data->addLink($action, $action, $parameters);
                }
            }
        }
        foreach (['_new', '_index'] as $action) {
            $data->addLink($action, $action);
        }

        return $this;
    }

    protected function initUrl(Data $data): AbstractController
    {
        $this->listUrl($data, ['_show', '_edit']);
        $this->paginationUrl($data);
        $this->crudUrl($data);

        return $this;
    }

    public function editAction(Request $request, EntityInterface $entity, string $formTypeClass): Response
    {
        $form = $this->createEntityForm($formTypeClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->valid($entity)) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($entity->isNew()) {
                $entityManager->persist($entity);
            }
            $entityManager->flush();

            return $this->redirectToRoute($this->data->getRoute('_show'), ['id' => $entity->getId()]);
        }

        $this->data->setEntity($entity);
        if ($entity->isNew()) {
            $twig = 'new.html.twig';
        } else {
            $twig = 'edit.html.twig';
        }

        return $this->dataRender($twig, [
            'form' => $form->createView(),
        ]);
    }

    public function DeleteAction(Request $request, EntityInterface $entity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entity);
            $entityManager->flush();
        }

        return $this->redirectToRoute($this->data->getRoute('_index'));
    }

    abstract protected function valid(EntityInterface $entity): bool;
}
