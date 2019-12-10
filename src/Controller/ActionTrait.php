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

use App\Repository\AbstractRepository;
use App\Tool\Data;
use Mazarini\ToolsBundle\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait ActionTrait
{
    /**
     * @var Data
     */
    protected $data;

    /**
     * @var array<string,mixed>
     */
    protected $parameters;

    public function IndexAction(): Response
    {
        return $this->redirectToRoute($this->data->getRoute('_page'), ['page' => 1]);
    }

    public function PageAction(AbstractRepository $EmptyRowRepository, int $page = 1): Response
    {
        $this->data->setPagination($EmptyRowRepository->getPage($page));

        return $this->dataRender('index.html.twig');
    }

    public function showAction(EntityInterface $entity): Response
    {
        $this->data->setEntity($entity);

        return $this->dataRender('show.html.twig', []);
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

            return $this->redirectToRoute('empty_row_show', ['id' => $entity->getId()]);
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
}
