<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Views\IView;
use App\Kernel\Views\TwigView;

class AppServiceProvider implements IServiceProvider {
    public function register(ServiceContainer $container): void
    {
        $container->singleton(IView::class, TwigView::class);
    }

    public function boot(ServiceContainer $container): void {
        
    }
}