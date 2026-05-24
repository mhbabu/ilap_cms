<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class LogLastActivity
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user()) {
            \Illuminate\Support\Facades\Auth::user()->update(['last_login_at' => now()]);
        }
        return $next($request);
    }
}
