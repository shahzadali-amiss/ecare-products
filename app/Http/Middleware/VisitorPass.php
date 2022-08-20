<?php

namespace App\Http\Middleware;

use Closure;

class VisitorPass
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
        if($request->hasCookie('visitor_id'))
        {
            return $next($request);
        }
        else
        {
            $visitor_id = rand(10000, 99999).time();
            $response = $next($request);
            return $response->withCookie(cookie()->forever('visitor_id', $visitor_id));
        }
    }
}
