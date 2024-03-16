<?php
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        return $next($request);
    }
}