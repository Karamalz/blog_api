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
        if (!preg_match('/^[0-9]+$/', $articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid article ID',
                'data' => '',
            ], 422);
        }
        $response = $this->messageService->store($request, $articleId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Message success' : 'Failed to leave message',
            'data' => '',
        ], 200);
    }

    public function destroy($messageId)
    {
        $response = $this->messageService->destroy($messageId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Delete message success' : 'Failed to delete message',
            'data' => '',
        ], 200);
    }
}
