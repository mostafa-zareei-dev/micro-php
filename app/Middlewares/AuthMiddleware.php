<?php

namespace App\Middlewares;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use App\Kernel\Middlewares\Middleware;
use Closure;

class AuthMiddleware implements Middleware
{
    public function handle(Request $request, Closure $next): Response
    {
        var_dump("Auth Middleware.");
        return $next($request);
    }
}
