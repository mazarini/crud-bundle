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

use Mazarini\PaginationBundle\Repository\EntityRepositoryAbstract;
use Mazarini\ToolsBundle\Controller\AbstractController;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Mazarini\ToolsBundle\Entity\ParentEntityInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class CrudControllerAbstract extends AbstractController
{
    protected function IndexAction(?ParentEntityInterface $parentEntity = null): Response
    {
        $this->setParentEntity($parentEntity);
        $url = $this->linkGenerator->getPageLink(1)->getUrl();

        return $this->redirect($url, Response::HTTP_MOVED_PERMANENTLY);
    }

    protected function PageAction(EntityRepositoryAbstract $repository, int $page, ?ParentEntityInterface $parentEntity = null): Response
    {
        $this->setParentEntity($parentEntity, $repository);
        $this->data->setPagination($repository->getPage($page));
        $currentPage = $this->data->getPagination()->getCurrentPage();
        if ($page === $currentPage) {
            return $this->dataRender('index.html.twig');
        }
        $url = $this->linkGenerator->getPageLink($currentPage)->getUrl();

        return $this->redirect($url);
    }

    protected function showAction(EntityInterface $entity): Response
    {
        $this->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
    }

    public function editAction(Request $request, EntityInterface $entity, string $formTypeClass): Response
    {
        $this->setEntity($entity);
        $form = $this->createEntityForm($formTypeClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->valid($entity, $form)) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($entity->isNew()) {
                $entityManager->persist($entity);
            }
            $entityManager->flush();
            $url = $this->linkGenerator->getEntityLink('', '_show', $entity)->getUrl();

            return $this->redirect($url);
        }

        $this->data->setFormView($form->createView());

        return $this->dataRender($entity->isNew() ? 'new.html.twig' : 'edit.html.twig');
    }

    public function DeleteAction(Request $request, EntityInterface $entity): Response
    {
        $this->setEntity($entity);
        if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entity);
            $entityManager->flush();
        }
        $url = $this->linkGenerator->getIndexLink()->getUrl();

        return $this->redirect($url);
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
        return $this->container
            ->get('form.factory')
            ->createNamed('Entity', $type, $entity, $options);
    }

    protected function valid(EntityInterface $entity, Form $form): bool
    {
        return true;
    }
}
