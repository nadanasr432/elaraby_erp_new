<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    protected function redirectTo($request, array $guards)
    {
        if (!$request->expectsJson()) {
            switch (current($guards)) {
                case 'admin-web':
                    return route('admin.login');
                    break;
                case 'client-web':
                    return route('client.login');
                    break;
            }
        }
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request, $guards)
        );
    }
}
