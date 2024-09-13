<?php

namespace App\Kernel\Routing;

interface IRouteCollection
{
    public function add(RouteURI $route): void;
    public function update(RouteURI $route): void;
    public function filter(RouteURI $route): RouteURI | false;
    public function routes(): array;
    public function addMiddleware(RouteURI $route, string | array $middleware): void;
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
            fn($routeItem) => $this->isRequestedRoute($routeItem, $route)
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

    public function addMiddleware(RouteURI $route, string | array $middleware): void
    {
        $this->routes = array_map(function ($routeItem) use ($route, $middleware) {
            return $this->mapRouteMiddlewares($routeItem, $route, $middleware);
        }, $this->routes());
    }

    private function mapRouteMiddlewares(RouteURI $routeItem, RouteURI $route, string | array $middleware): RouteURI
    {
        if ($this->isRequestedRoute($routeItem, $route)) {
            is_string($middleware) ? $routeItem->setMiddleware($middleware) : $routeItem->setMiddlewares($middleware);
        }

        return $routeItem;
    }

    private function isRequestedRoute(RouteURI $routeItem, RouteURI $route): bool
    {
        return $routeItem->method() === $route->method() && $routeItem->uri() === $route->uri();
    }
}
