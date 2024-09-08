<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;

interface IServiceProvider {
    public function register(ServiceContainer $container): void;
    public function boot(ServiceContainer $container): void;
}