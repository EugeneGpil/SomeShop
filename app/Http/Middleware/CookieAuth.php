<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class CookieAuth
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
        if (!$request->cookie('access_token')) {
            return $next($request);
        }   

        $request->headers->set('Authorization', 'Bearer ' . decrypt($request->cookie('access_token')));

        return $next($request);
    }
}
