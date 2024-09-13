<?php

return [
    'providers' => [
        "App\Kernel\ServiceProviders\AppServiceProvider",
        "App\Kernel\ServiceProviders\HttpServiceProvider",
        "App\Kernel\ServiceProviders\RouteServiceProvider",
    ],
    'middlewares' => [],
    'route_middlewares' => [
        "auth" => "App\Middlewares\AuthMiddleware",
    ],
];
