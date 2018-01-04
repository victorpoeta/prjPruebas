<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class sessionPTMiddleware
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
        if (!Session::has('login')) {
            return redirect('/WSlogin');
        }

        return $next($request);
    }
}
