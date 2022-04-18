<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Cycle\ORM\ORMInterface;
use Mailery\Brand\BrandLocator;
use Mailery\Brand\BrandLocatorInterface;
use Psr\Container\ContainerInterface;
use Mailery\Menu\Menu;
use Mailery\Menu\Decorator\Normalizer;
use Mailery\Menu\Decorator\Instantiator;
use Mailery\Menu\Decorator\Sorter;
use Mailery\Brand\Menu\SettingsMenu;
use Yiisoft\Injector\Injector;
use Mailery\Brand\Middleware\BrandMiddleware;

return [
    BrandMiddleware::class => [
        'class' => BrandMiddleware::class,
        'withRoute()' => ['/brand/default/index'],
    ],
    BrandLocatorInterface::class => BrandLocator::class,
    BrandLocator::class => function (ContainerInterface $container) {
        $orm = $container->get(ORMInterface::class);

        return (new BrandLocator($orm))
            ->withRegexp('/^\/brand\/(?<brandId>\d+)\/?/');
    },
    SettingsMenu::class => static function (Injector $injector) use($params) {
        return new SettingsMenu(
            (new Menu($params['maileryio/mailery-brand']['settings-menu']['items']))
                ->withNormalizer(new Normalizer($injector))
                ->withInstantiator(new Instantiator($injector))
                ->withSorter(new Sorter())
        );
    },
];
