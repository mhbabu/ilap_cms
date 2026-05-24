<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class Role
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        if (! $request->user())
            return redirect()->route('login');

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role) || $request->user()->hasRole('super_admin')) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard')->with('error', 'You are not authorized for this action.');
    }
}
