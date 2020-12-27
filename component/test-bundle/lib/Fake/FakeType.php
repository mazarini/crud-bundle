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

namespace Mazarini\TestBundle\Fake;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class FakeType extends AbstractType
{
    /**
     * buildForm.
     *
     * @param FormBuilderInterface<int,string|FormBuilderInterface> $builder
     * @param array<string,mixed>                                   $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('text', textType::class,
            [
                'label' => 'Text :',
            ]
        )
        ->add('text', textareaType::class,
            [
                'label' => 'Textarea :',
            ]
        )
        ->add('choice', ChoiceType::class,
            [
                'label' => 'Choice :',
                'choices' => [
                    'Maybe' => null,
                    'Yes' => true,
                    'No' => false,
                ],
            ]
        )
        ->add('day', DateType::class,
            [
                'label' => 'Date :',
                'format' => 'dd/MM/yyyy',
            ]
        )
        ->add(
            'amount', MoneyType::class,
                    [
                        'label' => 'Amount :',
                        'divisor' => 100,
                        'currency' => '€',
                    ]
            )
        ;
    }
}
