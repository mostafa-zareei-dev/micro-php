<?php

namespace App\Kernel\Core;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Http\Request;
use App\Kernel\Routing\Router;

class App
{
    private static ServiceContainer $container;

    public function __construct()
    {
        self::$container = new ServiceContainer();
        $this->registerServiceProviders();
        $this->bootServiceProviders();
    }

    public static function bind(string $key, string $resolver): void
    {
        self::$container->bind($key, $resolver);
    }

    public static function singleton(string $key, string $resolver): void
    {
        self::$container->singleton($key, $resolver);
    }

    public static function resolve(string $key)
    {
        return self::$container->resolve($key);
    }

    public function handle()
    {
        $router = self::$container->resolve(Router::class);
        $request = self::$container->resolve(Request::class);

        $router->routing($request);
    }

    private function registerServiceProviders()
    {
        $providers = configs('app.providers');

        foreach ($providers as $provider) {
            self::$container->register(new $provider());
        }
    }

    private function bootServiceProviders()
    {
        self::$container->boot();
    }
}
