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

namespace Mazarini\TestBundle\Test\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class HomeControllerAbstractTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @var int
     */
    protected $default;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->default = Response::HTTP_FOUND;
    }

    /**
     * testUrls.
     *
     * @dataProvider getUrls
     */
    public function testUrls(string $url): void
    {
        $this->client->request('GET', $url);

        $this->assertTrue(
            \in_array($this->client->getResponse()->getStatusCode(), [301, 302], true),
            sprintf('The "%s" URL redirect correctly', $url)
        );
    }

    /**
     * testUrls.
     *
     * @dataProvider getUrls
     */
    public function testSlashUrls(string $url): void
    {
        $url .= '/';
        $this->client->request('GET', $url);

        $this->assertTrue(
            \in_array($this->client->getResponse()->getStatusCode(), [301, 302], true),
            sprintf('The "%s" URL redirect correctly', $url)
        );
    }

    /**
     * getUrls.
     *
     * @return \Traversable<array>
     */
    abstract public function getUrls(): \Traversable;
}
