<?php

namespace App\Kernel\Routing;

use App\Kernel\Core\App;
use App\Kernel\Controllers\Controller;
use App\Kernel\Http\Request;
use BadMethodCallException;
use Closure;
use Exception;

class Router
{
    private IRouteCollection $routeCollection;

    const GET_METHOD = 'GET';
    const POST_METHOD = 'POST';
    const DELETE_METHOD = 'DELETE';
    const PUT_METHOD = 'PUT';
    const PATCH_METHOD = 'PATCH';

    public function __construct(IRouteCollection $routeCollection)
    {
        $this->routeCollection = $routeCollection;
    }

    public function get(string $uri, Closure | array | string $action): static
    {
        $this->addRoute(self::GET_METHOD, $uri, $action);
        return $this;
    }

    public function post(string $uri, Closure | array | string $action): static
    {
        $this->addRoute(self::POST_METHOD, $uri, $action);
        return $this;
    }

    public function put(string $uri, Closure | array | string $action): static
    {
        $this->addRoute(self::PUT_METHOD, $uri, $action);
        return $this;
    }

    public function patch(string $uri, Closure | array | string $action): static
    {
        $this->addRoute(self::PATCH_METHOD, $uri, $action);
        return $this;
    }

    public function delete(string $uri, Closure | array | string $action): static
    {
        $this->addRoute(self::DELETE_METHOD, $uri, $action);
        return $this;
    }

    public function addRoute(string $method, string $uri, Closure | array | string $action): void
    {

        $route = App::resolve(RouteURI::class)->setMethod($method)->setUri($uri)->setAction($action);
        $this->routeCollection->add(
            $route
        );
    }

    public function routing(Request $request): void
    {
        $path = $request->path();
        $method = strtoupper($request->method());

        $requestRoute = App::resolve(RouteURI::class)->setMethod($method)->setUri($path);
        $route = $this->routeCollection->filter($requestRoute);

        if (!$route) {
            $this->abort();
        }

        $this->dispatch($route);
    }

    private function dispatch(RouteURI $route): void
    {
        if (is_callable($route->action())) {
            call_user_func($route->action());
            die();
        }

        if (is_array($route->action()) || is_string($route->action())) {
            $this->dispatchToController($route);
        }

        throw new Exception("Not Defined Handler for this route.");
    }

    private function dispatchToController(RouteURI $route): void
    {
        $action = $this->parseAction($route);

        if (empty($action)) {
            throw new Exception("Not Defined Handler for this route.");
        }

        [$controller, $method] = $action;

        App::bind($controller, $controller);
        $controllerInstance = App::resolve($controller);

        if (!($controllerInstance instanceof Controller)) {
            $baseController = Controller::class;
            throw new Exception("Controller: $controller is not instance of $baseController.");
        }

        if (!method_exists($controllerInstance, $method)) {
            throw new BadMethodCallException("Method: $method not defined in $controller.");
        }

        call_user_func([$controllerInstance, $method]);
        die();
    }

    private function parseAction(RouteURI $route): array
    {
        $action = [];

        if (is_string($route->action())) {
            [$controller, $method] = explode("@", $route->action());
            $controller = "App\\Controllers\\" . $controller;

            array_push($action, $controller, $method);
        } else if (is_array($route->action())) {
            [$controller, $method] = $route->action();

            array_push($action, $controller, $method);
        }

        return $action;
    }

    private function abort(int $statusCode = 404): void
    {
        http_response_code($statusCode);
        die("Route Not Found!");
    }
}
