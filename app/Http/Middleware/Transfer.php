<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Transfer
{
    // route middleware used after users login — dispatches to correct dashboard
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }
}
