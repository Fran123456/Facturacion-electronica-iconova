<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class ApiAuth
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()==null) {
            return response()->json(['error' =>  "No  autenticado"], 401);
        }  

        return $next($request);
    }
}