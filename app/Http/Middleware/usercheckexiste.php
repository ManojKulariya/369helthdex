<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Auth;


class usercheckexiste
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
        if(Auth::check() && Auth::user()->user_type=='3'){
            return $next($request);            
        }else{
            Auth::logout();
           return redirect()->route('home');
        }
    }
}
