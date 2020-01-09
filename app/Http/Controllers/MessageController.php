<?php

namespace App\Http\Controllers;

use App\Http\Requests\messageRequest;
use App\services\MessageService;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function store(messageRequest $request, $articleId)
    {
        if (!preg_match('/\d{1,}/', $articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid article ID',
                'data' => '',
            ], 422);
        }
        if (!$this->messageService->store($request, $articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to leave message',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Message success',
                'data' => '',
            ], 200);
        }
    }

    public function destroy($messageId)
    {
        if (!$this->messageService->destroy($messageId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Delete message success',
                'data' => '',
            ], 200);
        }
    }
}
