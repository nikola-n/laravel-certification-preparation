<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TerminateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        sleep(5);
        echo 'prvo handle na middleware se povikuva' . '<br>';
        return $next($request);
    }

    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\Response $response
     *
     * @return void
     */
    public function terminate($request, $response)
    {
        app('log')->info('Middleware::terminate');
    }

}
