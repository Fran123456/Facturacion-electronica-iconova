<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate /*extends Middleware*/
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    /*protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }*/

    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }  

        return $next($request);
    }
}
