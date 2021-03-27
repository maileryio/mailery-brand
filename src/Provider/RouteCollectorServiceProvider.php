<?php

namespace Mailery\Brand\Provider;

use Psr\Container\ContainerInterface;
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
     * @param ContainerInterface $container
     * @return void
     */
    public function register(ContainerInterface $container): void
    {
        /** @var RouteCollectorInterface $collector */
        $collector = $container->get(RouteCollectorInterface::class);

        $collector->addRoute(
            Route::get('/brands')
                ->name('/brand/default/index')
                ->middleware(AssetBundleMiddleware::class)
                ->action([DefaultController::class, 'index'])
        );

        $collector->addGroup(
            Group::create('/brand')
                ->middleware(AssetBundleMiddleware::class)
                ->routes(
                    Route::methods(['GET', 'POST'], '/new-brand')
                        ->name('/brand/default/create')
                        ->action([DefaultController::class, 'create']),
                    Route::delete('/{id:\d+}/delete')
                        ->name('/brand/default/delete')
                        ->action([DefaultController::class, 'delete'])
                )
        );

        $collector->addGroup(
            Group::create('/brand/{brandId:\d+}')
                ->routes(
                    Route::methods(['GET', 'POST'], '/settings/basic')
                        ->action([SettingsController::class, 'basic'])
                        ->name('/brand/settings/basic')
                )
        );
    }
}
