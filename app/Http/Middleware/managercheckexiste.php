<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Auth;


class managercheckexiste
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && in_array(Auth::user()->user_type, ['2', '4'])) {
            return $next($request);
        } else {
            return redirect('manager-login');
        }
        
    }
}
