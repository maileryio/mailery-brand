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
use Yiisoft\Router\Route;

return [
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
            Route::get('/brand/default/index', [DefaultController::class, 'index'])
                ->name('/brand/default/index'),
            Route::get('/brand/default/view/{id:\d+}', [DefaultController::class, 'view'])
                ->name('/brand/default/view'),
            Route::methods(['GET', 'POST'], '/brand/default/create', [DefaultController::class, 'create'])
                ->name('/brand/default/create'),
            Route::methods(['GET', 'POST'], '/brand/default/edit/{id:\d+}', [DefaultController::class, 'edit'])
                ->name('/brand/default/edit'),
            Route::delete('/brand/default/delete/{id:\d+}', [DefaultController::class, 'delete'])
                ->name('/brand/default/delete'),
        ],
    ],
];
