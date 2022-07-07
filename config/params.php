<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Entity\BrandChannel;
use Mailery\Brand\ViewInjection\BrandLocatorViewInjection;
use Yiisoft\Definitions\DynamicReference;
use Yiisoft\Router\UrlGeneratorInterface;
use Yiisoft\Definitions\Reference;

return [
    'yiisoft/yii-cycle' => [
        'entity-paths' => [
            '@vendor/maileryio/mailery-brand/src/Entity',
        ],
    ],

    'maileryio/mailery-activity-log' => [
        'entity-groups' => [
            'brand' => [
                'label' => DynamicReference::to(static fn () => 'Brand'),
                'entities' => [
                    Brand::class,
                    BrandChannel::class,
                ],
            ],
        ],
    ],

    'maileryio/mailery-menu-navbar' => [
        'items' => [
            'brands' => [
                'label' => static function () {
                    return 'My brands';
                },
                'url' => static function (UrlGeneratorInterface $urlGenerator) {
                    return strtok($urlGenerator->generate('/brand/default/index'), '?');
                },
            ],
        ],
    ],

    'maileryio/mailery-menu-sidebar' => [
        'items' => [
            'settings' => [
                'label' => static function () {
                    return 'Settings';
                },
                'icon' => 'settings',
                'url' => static function (UrlGeneratorInterface $urlGenerator) {
                    return $urlGenerator->generate('/brand/settings/basic');
                },
                'activeRouteNames' => [
                    '/brand/settings/basic',
                ],
            ],
        ],
    ],

    'maileryio/mailery-brand' => [
        'settings-menu' => [
            'items' => [
                'general' => [
                    'label' => static function () {
                        return 'General';
                    },
                    'url' => static function (UrlGeneratorInterface $urlGenerator) {
                        return $urlGenerator->generate('/brand/settings/basic');
                    },
                ],
            ],
        ],
    ],

    'yiisoft/yii-view' => [
        'injections' => [
            Reference::to(BrandLocatorViewInjection::class),
        ],
    ],
];
