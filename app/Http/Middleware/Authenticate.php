<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
        }

        $guard = $this->authenticateGuard();

        switch ($guard) {
            case 'admin':
                return route('admin.login');
            case 'web':
                return route('client.login');
            default:
                return route('login'); // Default fallback route
        }
    }

    protected function authenticateGuard(): string
    {
        $guards = array_keys(config('auth.guards'));

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $guard;
            }
        }

        return 'web'; // Default fallback guard
    }
}
