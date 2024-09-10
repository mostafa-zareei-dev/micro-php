<?php

namespace App\Kernel\Core;

use App\Kernel\Container\ServiceContainer;

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

    private function registerServiceProviders()
    {
        $configs = include ROOT_PATH . "config/app.php";

        $providers = $configs['providers'];

        foreach ($providers as $provider) {
            self::$container->register(new $provider());
        }
    }

    private function bootServiceProviders()
    {
        self::$container->boot();
    }
}
