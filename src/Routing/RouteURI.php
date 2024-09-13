<?php

namespace App\Kernel\Routing;

use Closure;

class RouteURI
{
    private string $uri;
    private string $method;
    private Closure | array | string $action;
    private array $middlewares = [];

    public function setUri(string $uri): static
    {
        $this->uri = $uri;
        return $this;
    }

    public function setMethod(string $method): static
    {
        $this->method = $method;
        return $this;
    }

    public function setAction(Closure | array | string $action): static
    {
        $this->action = $action;
        return $this;
    }

    public function setMiddleware(string $middleware): static
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function setMiddlewares(array $middlewares): static
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function action(): Closure | array | string
    {
        return $this->action;
    }

    public function middlewares(): array
    {
        return $this->middlewares;
    }
}
