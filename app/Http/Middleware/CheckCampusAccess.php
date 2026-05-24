<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CheckCampusAccess
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = $request->user();

        if (! $user)
            return redirect()->route('login');

        if ($user->hasRole('super_admin') || $user->hasRole('hq_admin'))
            return $next($request);

        $campusId = $request->route('campus_id') ?? $request->user()->campus_id;

        if ($user->campus_id && $user->campus_id != $campusId)
            return redirect()->route('dashboard')->with('error', 'Access denied to this campus.');

        return $next($request);
    }
}
