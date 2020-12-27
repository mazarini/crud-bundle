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

class UrlGenerator extends UrlGeneratorOriginal
{
    /**
     * generate.
     *
     * @param string              $name
     * @param array<string,mixed> $parameters
     * @param int                 $referenceType
     *
     * @return string
     */
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        if ('FAKE_' === mb_substr($name, 0, 5)) {
            $url = '#'.$name;
            foreach ($parameters as $key => $value) {
                $url .= '-'.$key.'='.(string) $value;
            }

            return $url;
        }

        return parent::generate($name, $parameters, $referenceType);
    }
}
