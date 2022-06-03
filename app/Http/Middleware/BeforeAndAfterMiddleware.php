<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BeforeAndAfterMiddleware
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
        //dump('before');
        $response = $next($request);
        //dump('after');

        return $response;
    }
}
