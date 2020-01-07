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

        if (!$this->messageService->store($request, $articleId)) {
            return response()->json([
                'success' => false,
                'message' => '留言失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '留言成功',
                'data' => '',
            ], 200);
        }
    }

    public function destroy($messageId)
    {
        if (!$this->messageService->destroy($messageId)) {
            return response()->json([
                'success' => false,
                'message' => '刪除留言失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '留言刪除成功',
                'data' => '',
            ], 200);
        }
    }
}
