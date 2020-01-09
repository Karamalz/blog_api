<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class MasterRoleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (JWTAuth::user()->roles->roles != 'WebMaster') {
            return response()->json([
                'success' => false,
                'message' => 'You are not WebMaster!',
                'date' => '',
            ], 403);
        }
        return $next($request);
    }
}
