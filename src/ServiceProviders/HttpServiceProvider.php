<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Http\Request;

class HttpServiceProvider implements IServiceProvider {
    public function register(ServiceContainer $container): void
    {
        $container->bind(Request::class, Request::class);
    }

    public function boot(ServiceContainer $container): void {
        
    }
}