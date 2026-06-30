<?php

namespace App\Http\Middleware;

use Closure;

class RemoveCSRFCheck
{
    public function handle($request, Closure $next)
    {
        // Check if the current route matches the route(s) where you want to remove CSRF protection.
        if ($request->is('test')) {
            // Disable CSRF protection for this route.
            return $next($request);
        }

        // Continue with the default CSRF protection for other routes.
        return $next($request);
    }
}
