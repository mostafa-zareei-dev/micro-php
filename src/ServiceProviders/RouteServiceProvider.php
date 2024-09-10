<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Routing\IRouteCollection;
use App\Kernel\Routing\RouteCollection;
use App\Kernel\Routing\Router;
use App\Kernel\Routing\RouteURI;

class RouteServiceProvider implements IServiceProvider
{
    public function register(ServiceContainer $container): void
    {
        $container->singleton(IRouteCollection::class, RouteCollection::class);
        $container->bind(RouteURI::class, RouteURI::class);
        $container->singleton(Router::class, Router::class);
    }

    public function boot(ServiceContainer $container): void
    {
        include ROOT_PATH . "routes/web.php";
    }
}
