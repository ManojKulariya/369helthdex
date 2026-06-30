<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Auth;


class transportadmincheckexiste
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
        if(Auth::check()&&Auth::user()->user_type=='7'){
            return $next($request);            
        }else{
           return redirect('transport');
        }
    }
}
