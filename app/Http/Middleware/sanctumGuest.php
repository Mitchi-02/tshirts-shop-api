<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class sanctumGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(auth('sanctum')->check()){
            return response()->json([
                'status' => 0,
                'message' => "Vous êtes déjà connecté",
            ], 401);
        }
        return $next($request);
    }
}
