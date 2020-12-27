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

use Mazarini\TestBundle\Tool\Folder;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

abstract class StepControllerAbstractTest extends UrlControllerAbstractTest
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * testUrls.
     *
     * @dataProvider getUrls
     *
     * @param array<string,mixed> $parameters
     */
    public function testUrls(string $url, int $response = 0, string $method = 'GET', array $parameters = []): void
    {
        $this->client->request($method, $url, $parameters);
        $response = 0 === $response ? Response::HTTP_OK : $response;

        $message = sprintf('The %s URL loads correctly.', $url);
        $this->assertSame(
            $response,
            $this->client->getResponse()->getStatusCode(),
            sprintf('The %s URL loads correctly.', $url)
        );
    }

    /**
     * getUrls.
     *
     * @return \Traversable<int,array>
     */
    public function getUrls(): \Traversable
    {
        $folder = new Folder();
        $steps = $folder->getSteps();
        foreach ($steps as $step => $dummy) {
            yield ['/step/'.$step.'/', Response::HTTP_MOVED_PERMANENTLY];
            $pages = $folder->getPages($steps[$step]);
            foreach ($pages as $page => $dummy) {
                yield ['/step/'.$step.'/'.$page.'.html'];
            }
        }
    }
}
