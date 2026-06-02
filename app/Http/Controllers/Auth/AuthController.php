<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            $user = auth()->user();

            if (! $user->email_verified_at && ! $user->hasRole('super_admin') && ! $user->hasRole('student')) {
                auth()->logout();
                return back()->withErrors(['email' => 'Please verify your email before logging in.']);
            }

            if ($user->forced_login) {
                $user->update(['forced_login' => false]);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function forceLogin(Request $request, User $user): RedirectResponse
    {
        if (! auth()->user()?->hasRole('super_admin'))
            abort(403);

        auth()->login($user);
        $user->update(['forced_login' => true]);
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }
}
