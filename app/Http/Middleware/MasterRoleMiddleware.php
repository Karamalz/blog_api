<?php

namespace App\Http\Middleware;

use Closure;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class MasterRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if(JWTAuth::user()->roles->roles != 'WebMaster') {
            return response()->json([
                'result' => false,
                'message' => 'You are not WebMaster!',
            ], 403);
        }
        return $next($request);
    }
}
