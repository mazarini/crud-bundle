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

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomeControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser;
     */
    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider getUrls
     */
    public function testUrls(string $url, string $method = 'GET', int $response = 0): void
    {
        $response = 0 === $response ? Response::HTTP_MOVED_PERMANENTLY : $response;

        $this->client->request($method, $url);

        $this->assertSame(
            $response,
            $this->client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly with status %d (really %d)', $url, $response, $this->client->getResponse()->getStatusCode())
        );

        $url .= '/';
        $this->client->request($method, $url);

        $this->assertSame(
            $response,
            $this->client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly with status %d (really %d)', $url, $response, $this->client->getResponse()->getStatusCode())
        );
    }

    /**
     * getUrls.
     *
     * @return \Traversable<array>
     */
    public function getUrls(): \Traversable
    {
        yield [''];
        yield ['/admin'];
        yield ['/admin/zero'];
        yield ['/five'];
        yield ['/ten'];
    }
}
