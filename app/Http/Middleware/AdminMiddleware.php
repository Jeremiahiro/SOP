<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role=='admin' || Auth::user()->role=='super admin')
        {
           return $next($request);
        }
        else
        {
            return redirect('/')->with('status', 'you can not  Login  to the Admin');
        }
     
    }
}
