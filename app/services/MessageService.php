<?php

namespace App\services;

use App\repositories\MessageRepository;

class MessageService
{
    protected $messageRepo;

    public function __construct(MessageRepository $messageRepo)
    {
        $this->messageRepo = $messageRepo;
    }

    public function getMessage($messageId)
    {
        return $this->messageRepo->getMessageById($messageId);
    }

    public function store($request, $articleId)
    {
        return $this->messageRepo->messageStore($request, $articleId);
    }

    public function destroy($messageId)
    {
        return $this->messageRepo->messageDestroy($messageId);
    }
}
