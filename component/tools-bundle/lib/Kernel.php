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

namespace Mazarini\ToolsBundle;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\RouteCollectionBuilder;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXTS = '.{php,xml,yaml,yml}';

    public function registerBundles(): iterable
    {
        $contents = require $this->getProjectDir().'/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    public static function isOlder(int $version): bool
    {
        return $version <= self::VERSION_ID;
    }

    /**
     * configureContainer.
     *
     * ContainerBuilder : 4.4 => 5.0
     * ContainerConfigurator : 5.1 => ?
     *
     * @param object $container
     */
    protected function configureContainer($container, ?LoaderInterface $loader = null): void
    {
        $confDir = $this->getProjectDir().'/config';
        if ($container instanceof ContainerBuilder) {
            /*
             * 4.4 and 5.0.
             */
            $container->addResource(new FileResource($this->getProjectDir().'/config/bundles.php'));
            $container->setParameter('container.dumper.inline_class_loader', true);
            $confDir = $this->getProjectDir().'/config';
            if (null !== $loader) {
                $loader->load($confDir.'/{packages}/*'.self::CONFIG_EXTS, 'glob');
                $loader->load($confDir.'/{packages}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, 'glob');
                $loader->load($confDir.'/{services}'.self::CONFIG_EXTS, 'glob');
                $loader->load($confDir.'/{services}_'.$this->environment.self::CONFIG_EXTS, 'glob');
            }
        } elseif (method_exists($container, 'import')) {
            /*
             * 5.1 and later
             */
            $container->import($confDir.'/{packages}/*.yaml');
            $container->import($confDir.'/{packages}/'.$this->environment.'/*.yaml');
            $container->import($confDir.'/{services}.yaml');
            $container->import($confDir.'/{services}_'.$this->environment.'.yaml');
        }
    }

    /**
     * configureRoutes.
     *
     * RouteCollectionBuilder : 4.4 => 5.0
     * RoutingConfigurator : 5.1 => ?
     *
     * @param object $routes
     */
    protected function configureRoutes($routes): void
    {
        if (method_exists($routes, 'import')) {
            if (self::isOlder(50100)) {
                /*
                 * 5.1 and later
                 */
                $routes->import('../config/{routes}/'.$this->environment.'/*.yaml');
                $routes->import('../config/{routes}/*.yaml');
                $routes->import('../config/{routes}.yaml');
            } else {
                /**
                 * 4.4 and 5.0.
                 */
                $confDir = $this->getProjectDir().'/config';
                $routes->import($confDir.'/{routes}/'.$this->environment.'/**/*'.self::CONFIG_EXTS, '/', 'glob');
                $routes->import($confDir.'/{routes}/*'.self::CONFIG_EXTS, '/', 'glob');
                $routes->import($confDir.'/{routes}'.self::CONFIG_EXTS, '/', 'glob');
            }
        }
    }
}
