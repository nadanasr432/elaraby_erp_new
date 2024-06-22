<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch ($guard) {
                case 'admin-web':
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                case 'client-web':
                    return redirect(RouteServiceProvider::CLIENT_HOME);
            }
        }
        return $next($request);
    }
}
