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

use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class UrlGeneratorOriginal implements UrlGeneratorInterface, ConfigurableRequirementsInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $original;

    public function __construct(UrlGeneratorInterface $original)
    {
        $this->original = $original;
    }

    /**
     * setContext.
     *
     * @return void
     */
    public function setContext(RequestContext $context)
    {
        $this->original->setContext($context);
    }

    /**
     * getContext.
     *
     * @return RequestContext
     */
    public function getContext()
    {
        return $this->original->getContext();
    }

    /**
     * setStrictRequirements.
     *
     * @param bool|null $enabled
     *
     * @return void
     */
    public function setStrictRequirements($enabled)
    {
        if (method_exists($this->original, 'setStrictRequirements')) {
            $this->original->setStrictRequirements($enabled);
        }
    }

    public function isStrictRequirements(): ?bool
    {
        if (method_exists($this->original, 'isStrictRequirements')) {
            return $this->original->isStrictRequirements();
        }

        return null;
    }

    /**
     * generate.
     *
     * @param string              $name
     * @param array<string,mixed> $parameters
     * @param int                 $referenceType
     *
     * @return string
     */
    public function generate($name, $parameters = [], $referenceType = UrlGenerator::ABSOLUTE_PATH)
    {
        return $this->original->generate($name, $parameters, $referenceType);
    }

    /**
     * getRelativePath.
     *
     * @param string $basePath   The base path
     * @param string $targetPath The target path
     *
     * @return string The relative target path
     */
    public static function getRelativePath(string $basePath, string $targetPath)
    {
        return UrlGenerator::getRelativePath($basePath, $targetPath);
    }
}
