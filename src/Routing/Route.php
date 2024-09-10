<?php

namespace App\Kernel\Routing;

use App\Kernel\Core\App;
use Closure;

class Route
{
    private static array $methods = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTION'];

    public static function __callStatic(string $method, array $args)
    {
        $method = strtoupper($method);

        if (self::isInvalidMethod($method)) {
            throw new \Exception('The ' . strtolower($method) . ' is not supported.');
        }

        [$uri, $action] = $args;

        if (self::isInvalidUri($uri)) {
            throw new \Exception('The Uri parameter is in an invalid format.');
        }
        
        if (self::isInvalidAction($action)) {
            throw new \Exception('The action parameter is in an invalid format.');
        }

        $method = strtolower($method);

        $router = App::resolve(Router::class);
        call_user_func([$router, $method], $uri, $action);
    }

    private static function isInvalidMethod(string $method): bool
    {
        return !in_array($method, self::$methods);
    }

    private static function isInvalidUri(mixed $uri): bool
    {
        return !isset($uri) || !preg_match('/^\/[a-zA-Z0-9._\-\:\/]*$/', $uri);
    }

    private static function isInvalidAction(mixed $action): bool
    {
        $validActionTypes = ["string", "array", "object"];
        return !isset($action) || empty($action) || !in_array(gettype($action), $validActionTypes);
    }
}
