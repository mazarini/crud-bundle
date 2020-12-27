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

namespace Mazarini\TestBundle\Tool;

class Folder
{
    /**
     * @var string
     */
    private $stepDir = '';

    /**
     * __construct.
     */
    public function __construct(string $stepDir = '')
    {
        if ('' === $stepDir) {
            if (false === mb_strpos(__DIR__, implode(\DIRECTORY_SEPARATOR, ['vendor', 'mazarini', 'test-bundle', 'lib', 'Tool']))) {
                $stepDir = \dirname(__DIR__, 2);
            } else {
                $stepDir = \dirname(__DIR__, 5);
            }
            $stepDir .= '/templates/step';
        }
        $this->stepDir = $stepDir;
    }

    /**
     * getSteps.
     *
     * @return array<string,string>
     */
    public function getSteps(): array
    {
        $dirs = glob($this->stepDir.'/??-*');
        $steps = [];
        if (\is_array($dirs)) {
            foreach ($dirs as $dir) {
                $step = basename($dir);
                $steps[mb_substr($step, 3)] = $step;
            }
        }

        return $steps;
    }

    /**
     * getPages.
     *
     * @return array<string,string>
     */
    public function getPages(string $step): array
    {
        $dirs = glob($this->stepDir.'/'.$step.'/??-*\.html\.twig');
        $pages = [];
        if (\is_array($dirs)) {
            foreach ($dirs as $dir) {
                $pages[mb_substr(basename($dir, '.html.twig'), 3)] = basename($dir);
            }
        }

        return $pages;
    }
}
