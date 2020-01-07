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
        $this->messageService->store($request, $articleId);

        return redirect('/article/' . $articleId);
    }

    public function destroy($articleId, $messageId)
    {
        $this->messageService->destroy($messageId);

        return Redirect('/article/' . $articleId);
    }
}
