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

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mazarini\ToolsBundle\Entity\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZeroRepository")
 */
class Zero implements EntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id = 0;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $Col3 = '';

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $Col4 = '';

    public function isNew(): bool
    {
        return 0 === $this->id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCol3(): string
    {
        return $this->Col3;
    }

    public function setCol3(string $Col3): self
    {
        $this->Col3 = $Col3;

        return $this;
    }

    public function getCol4(): string
    {
        return $this->Col4;
    }

    public function setCol4(string $Col4): self
    {
        $this->Col4 = $Col4;

        return $this;
    }
}
