<?php

namespace App\Http\Middleware;

use App\services\MessageService;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessageAuthorRoleMiddleware
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function handle($request, Closure $next)
    {
        if ($request->route('messageId') == '') {
            return response()->json([
                'success' => false,
                'message' => 'Invalid message ID',
                'data' => '',
            ], 404);
        }
        $message = $this->messageService->getMessage($request->route('messageId'));
        if ($message->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Message with ID:' . $request->route('messageId') . ' is not exist',
                'data' => '',
            ], 404);
        }
        if (JWTAuth::user()->roles->roles == 'normal' && $message[0]->message_author_id != JWTAuth::user()->id) {
            return response()->json([
                'result' => false,
                'message' => 'You are not the author or admin!',
            ], 403);
        }
        return $next($request);
    }
}
