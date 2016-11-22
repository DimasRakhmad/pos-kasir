<?php

namespace App\Http\Middleware;

use Closure;
use Session;


class NotifMiddleware
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
        Session::set('tes','10');
        // $tes= "tes";
        // return $tes;
        return $next($request);
    }
}
