<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class RouteDispatchController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user  = $request->user();
        $role  = $user?->role;

        return match ($role) {
            'super_admin'    => redirect()->route('dashboard'),
            'hq_admin'       => redirect()->route('dashboard'),
            'campus_admin'   => redirect()->route('dashboard'),
            'campus_manager' => redirect()->route('dashboard'),
            'handler'        => redirect()->route('dashboard'),
            'student'        => redirect()->route('dashboard'),
            'parent'         => redirect()->route('dashboard'),
            default          => redirect()->route('login'),
        };
    }
}
