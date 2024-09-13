<?php

namespace App\Kernel\Routing;

use App\Kernel\Core\App;
use App\Kernel\Http\Request;
use Closure;

class RouteMiddlewarePipline
{

    private array $middlewares = [];

    public function build(array $middlewares): static
    {
        $routeMiddlewares = configs('route_middlewares');

        foreach ($middlewares as $middlewareKey) {
            if (!array_key_exists($middlewareKey, $routeMiddlewares)) {
                throw new \Exception("This $middlewareKey is not defined to route middlewares configs array.");
                break;
            }

            $this->middlewares[] = App::resolve($middlewareKey);
        }

        return $this;
    }

    public function handle(Request $request, Closure $mainHandler): bool
    {
        $pipline = array_reduce(
            array_reverse($this->middlewares),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            function($request) use ($mainHandler) {
                $mainHandler($request);
            }
        );

        return $pipline($request);
    }
}
