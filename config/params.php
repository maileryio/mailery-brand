<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Brand\Middleware\BrandRequiredMiddleware;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    'yiisoft/yii-cycle' => [
        'annotated-entity-paths' => [
            '@vendor/maileryio/mailery-brand/src/Entity',
        ],
    ],

    'maileryio/mailery-menu-navbar' => [
        'items' => [
            'brands' => [
                'label' => static function () {
                    return 'My brands';
                },
                'url' => static function (UrlGeneratorInterface $urlGenerator) {
                    return $urlGenerator->generate('/brand/default/index');
                },
                'order' => 200,
            ],
        ],
    ],
    'maileryio/mailery-menu-sidebar' => [
        'items' => [
            'dashboard' => [
                'label' => static function () {
                    return 'Dashboard';
                },
                'icon' => 'dashboard',
                'url' => static function (UrlGeneratorInterface $urlGenerator) {
                    return $urlGenerator->generate('/default/index');
                },
                'order' => 100,
            ],
        ],
    ],

    'dispatcher' => [
        'middlewares' => [
            BrandRequiredMiddleware::class,
        ],
    ],
];
