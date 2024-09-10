<?php

namespace App\Kernel\Routing;

interface IRouteCollection
{
    public function add(RouteURI $route): void;
    public function update(RouteURI $route): void;
    public function filter(RouteURI $route): RouteURI | false;
    public function routes(): array;
};

class RouteCollection implements IRouteCollection
{
    private array $routes = [];

    public function add(RouteURI $route): void
    {
        $this->routes[] = $route;
    }

    public function update(RouteURI $route): void {}

    public function filter(RouteURI $route): RouteURI | false
    {
        $filteredRoute = array_filter(
            $this->routes,
            fn($routeItem) => $routeItem->method() === $route->method() && $routeItem->uri() === $route->uri()
        );

        if (empty($filteredRoute)) {
            return false;
        }

        return array_shift($filteredRoute);
    }

    public function routes(): array
    {
        return $this->routes;
    }
}
