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
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class CrudControllerAbstract extends AbstractController
{
    use CrudTrait;

    protected function IndexAction(): Response
    {
        $parameters = $this->getPageParameters();
        $parameters['page'] = 1;

        return $this->redirect($this->data->generateUrl('_page', $parameters), Response::HTTP_MOVED_PERMANENTLY);
    }

    protected function PageAction(EntityRepositoryAbstract $EmptyRowRepository, int $page): Response
    {
        $this->data->setPagination($EmptyRowRepository->getPage($page));

        if ($page === $this->data->getPagination()->getCurrentPage()) {
            return $this->dataRender('index.html.twig');
        }

        $parameters = $this->getPageParameters();
        $parameters['page'] = $this->data->getPagination()->getCurrentPage();

        return $this->redirect($this->data->generateUrl('_page', $parameters));
    }

    protected function showAction(EntityInterface $entity): Response
    {
        $this->data->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
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

    public function editAction(Request $request, EntityInterface $entity, string $formTypeClass): Response
    {
        $form = $this->createEntityForm($formTypeClass, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->valid($entity, $form)) {
            $entityManager = $this->getDoctrine()->getManager();
            if ($entity->isNew()) {
                $entityManager->persist($entity);
            }
            $entityManager->flush();

            return $this->redirect($this->data->generateUrl('_show', ['id' => $entity->getId()]));
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

        return $this->redirect($this->data->generateUrl('_index'));
    }

    protected function valid(EntityInterface $entity, Form $form): bool
    {
        return true;
    }
}
