<?php

namespace App\Http\Middleware;

use Closure;
use Exception;

class handleErrors
{

    public function handle($request, Closure $next, $guard = null)
    {
       
        /*if ($e) {
            return response('Unauthorized.', 401);
        }

        return $next($request);*/
    }
}