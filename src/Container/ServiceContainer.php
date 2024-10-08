<?php

namespace App\Kernel\Container;

use Closure;
use ReflectionClass;
use ReflectionType;
use App\Kernel\ServiceProviders\IServiceProvider;

class ServiceContainer
{
    private array $bindings = [];
    private array $providers = [];

    public function bind(string $key, string $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function singleton(string $key, string $resolver): void
    {
        $this->bindings[$key] = function ($container) use ($resolver) {
            static $instance;

            if (is_null($instance)) {
                $instance = $container->build($resolver);
            }

            return $instance;
        };
    }

    public function resolve(string $key)
    {
        if (isset($this->bindings[$key])) {
            $resolver = $this->bindings[$key];

            if ($resolver instanceof Closure) {
                $object = $resolver($this);
            } else {
                $object = $this->build($resolver);
            }

            return $object;
        }
    }

    public function register(IServiceProvider $provider)
    {
        $provider->register($this);
        $this->providers[] = $provider;
    }

    public function boot()
    {
        foreach ($this->providers as $provider) {
            $provider->boot($this);
        }
    }

    private function build($resolver)
    {
        $reflection = new ReflectionClass($resolver);

        if (!$reflection->isInstantiable()) {
            throw new \Exception("Cannot instantiate {$resolver}");
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $resolver();
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if ($dependency instanceof ReflectionType) {
                $dependencies[] = $this->resolve($dependency->getName());
            } else {
                throw new \Exception("Cannot resolve dependency {$parameter->name}");
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
