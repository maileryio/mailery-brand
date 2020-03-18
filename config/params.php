<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Brand\Controller\DefaultController;
use Mailery\Brand\Service\BrandLocator;
use Mailery\Brand\Middleware\BrandRequiredMiddleware;
use Mailery\Menu\MenuItem;
use Mailery\Web\Assets\AppAssetBundle;
use Mailery\Brand\Assets\BrandAssetBundle;
use Opis\Closure\SerializableClosure;
use Yiisoft\Router\Route;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    'assetManager' => [
        'bundles' => [
            AppAssetBundle::class => [
                'depends' => [
                    BrandAssetBundle::class,
                ],
            ],
        ],
    ],

    'cycle.common' => [
        'entityPaths' => [
            '@vendor/maileryio/mailery-brand/src/Entity',
        ],
    ],

    'session' => [
        'options' => [
            'cookie_secure' => 0,
        ],
    ],

    'router' => [
        'routes' => [
            '/brand/default/index' => Route::get('/brands', [DefaultController::class, 'index'])
                ->name('/brand/default/index'),
            '/brand/default/create' => Route::methods(['GET', 'POST'], '/brand/new-brand', [DefaultController::class, 'create'])
                ->name('/brand/default/create'),
            '/brand/default/edit' => Route::methods(['GET', 'POST'], '/brand/{id:\d+}/edit', [DefaultController::class, 'edit'])
                ->name('/brand/default/edit'),
            '/brand/default/delete' => Route::delete('/brand/{id:\d+}/delete', [DefaultController::class, 'delete'])
                ->name('/brand/default/delete'),
        ],
    ],

    'menu' => [
        'navbar' => [
            'items' => [
                'brands' => (new MenuItem())
                    ->withLabel('My brands')
                    ->withUrl(new SerializableClosure(function (UrlGeneratorInterface $urlGenerator) {
                        return $urlGenerator->generate('/brand/default/index');
                    })),
            ],
        ],
        'sidebar' => [
            'items' => [
                'dashboard' => (new MenuItem())
                    ->withLabel('Dashboard')
                    ->withIcon('dashboard')
                    ->withUrl(new SerializableClosure(function (UrlGeneratorInterface $urlGenerator, BrandLocator $brandLocator) {
                        return $urlGenerator->generate('/', ['brandId' => $brandLocator->getBrand()->getId()]);
                    })),
            ],
        ],
    ],

    'dispatcher' => [
        'middlewares' => [
            BrandRequiredMiddleware::class,
        ],
    ],
];
