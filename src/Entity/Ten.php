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
 * @ORM\Entity(repositoryClass="App\Repository\TenRepository")
 */
class Ten implements EntityInterface
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
    private $col1 = '';

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $col2 = '';

    public function isNew(): bool
    {
        return 0 === $this->id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCol1(): string
    {
        return $this->col1;
    }

    public function setCol1(string $col1): self
    {
        $this->col1 = $col1;

        return $this;
    }

    public function getCol2(): string
    {
        return $this->col2;
    }

    public function setCol2(string $col2): self
    {
        $this->col2 = $col2;

        return $this;
    }
}
