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
use Mailery\Brand\Service\BrandLocator;
use Mailery\Brand\Router\BrandUrlGenerator;
use Cycle\ORM\ORMInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Yiisoft\Router\UrlGeneratorInterface;

return [
    UrlGeneratorInterface::class => BrandUrlGenerator::class,
    BrandLocator::class => function (ContainerInterface $container) {
        $orm = $container->get(ORMInterface::class);

        return (new BrandLocator($orm))
            ->withRegexp('/^\/brand\/(?<brandId>\d+)\/?/');
    },
    BrandRequiredMiddleware::class => function (ContainerInterface $container) {
        $responseFactory = $container->get(ResponseFactoryInterface::class);
        $urlGenerator = $container->get(UrlGeneratorInterface::class);
        $brandLocator = $container->get(BrandLocator::class);

        return (new BrandRequiredMiddleware($responseFactory, $urlGenerator, $brandLocator))
            ->toRoute('/brand/default/index');
    },
];
