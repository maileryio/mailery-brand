<?php

namespace Mailery\Brand\Provider;

use Yiisoft\Di\Container;
use Yiisoft\Di\Support\ServiceProvider;
use Yiisoft\Router\RouteCollectorInterface;
use Yiisoft\Router\Group;
use Yiisoft\Router\Route;
use Mailery\Brand\Controller\DefaultController;
use Mailery\Brand\Controller\SettingsController;
use Mailery\Brand\Middleware\AssetBundleMiddleware;

final class RouteCollectorServiceProvider extends ServiceProvider
{
    /**
     * @param Container $container
     * @return void
     */
    public function register(Container $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addRoute(
            Route::get('/brands', [DefaultController::class, 'index'])
                ->name('/brand/default/index')
                ->addMiddleware(AssetBundleMiddleware::class)
        );

        $collector->addGroup(
            Group::create(
                '/brand',
                [
                    Route::methods(['GET', 'POST'], '/new-brand', [DefaultController::class, 'create'])
                        ->name('/brand/default/create'),
                    Route::delete('/{id:\d+}/delete', [DefaultController::class, 'delete'])
                        ->name('/brand/default/delete'),
                ]
            )->addMiddleware(AssetBundleMiddleware::class)
        );

        $collector->addGroup(
            Group::create(
                '/brand/{brandId:\d+}',
                [
                    Route::methods(['GET', 'POST'], '/settings/basic', [SettingsController::class, 'basic'])
                        ->name('/brand/settings/basic'),
                ]
            )
        );
    }
}
