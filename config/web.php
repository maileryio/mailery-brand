<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Menu\Sidebar\SidebarMenuInterface;
use Psr\Container\ContainerInterface;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    SidebarMenuInterface::class => [
        'setItems()' => [
            'items' => [
                'brands' => [
                    'label' => function () {
                        return 'Brands';
                    },
                    'icon' => 'brand',
                    'url' => function (ContainerInterface $container) {
                        return $container->get(UrlGeneratorInterface::class)
                            ->generate('/brand/default/index');
                    },
                ],
            ],
        ],
    ],
];
