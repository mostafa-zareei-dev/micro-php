<?php

namespace App\Kernel\Middlewares;

use App\Kernel\Http\Request;
use App\Kernel\Http\Response;
use Closure;

interface Middleware
{
    public function handle(Request $request, Closure $next): Response;
}
