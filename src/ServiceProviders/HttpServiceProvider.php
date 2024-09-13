<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Http\Request;
use App\Kernel\Http\Response;

class HttpServiceProvider implements IServiceProvider {
    public function register(ServiceContainer $container): void
    {
        $container->bind(Request::class, Request::class);
        $container->bind(Response::class, Response::class);
    }

    public function boot(ServiceContainer $container): void {
        
    }
}