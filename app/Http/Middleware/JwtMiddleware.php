<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JwtMiddleware extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (TokenExpiredException $e) {
            try {
                $refreshed = JWTAuth::parseToken()->refresh();
                JWTAuth::setToken($refreshed)->toUser();
                $request->headers->set('Authorization', 'Bearer ' . $refreshed);
                var_dump($request->headers->get('authorization'));
            } catch (JWTException $e) {
                return response()->json([
                    'result' => false,
                    'message' => 'token_absent',
                ], 401);
            }
        } catch (TokenInvalidException $e) {
            return response()->json([
                'result' => false,
                'message' => 'token_invalid',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'result' => false,
                'message' => 'token_absent',
            ], 401);
        }
        return $this->setAuthenticationHeader($next($request), $refreshed);
    }
}
