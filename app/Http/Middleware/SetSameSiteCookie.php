<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetSameSiteCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (method_exists($response, 'withCookie')) {
            $response->withCookie(cookie('example_cookie', 'value', 120, '/', null, false, true, false, 'Strict'));
        }

        return $response;
    }
}
