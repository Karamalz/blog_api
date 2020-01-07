<?php

namespace App\Http\Middleware;

use Closure;
use App\services\MessageService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class MessageAuthorRoleMiddleware
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function handle($request, Closure $next)
    {
        $message = $this->messageService->getMessage($request->route('messageId'));
        if(JWTAuth::user()->roles->roles=='normal' && $message[0]->message_author_id != JWTAuth::user()->id) {
            return response()->json([
                'result' => false,
                'message' => 'You are not the author or admin!',
            ], 403);
        }
        return $next($request);
    }
}
