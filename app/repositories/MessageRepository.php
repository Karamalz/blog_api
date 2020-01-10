<?php

namespace App\Repositories;

use App\entities\Message;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MessageRepository
{

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function messageStore(Request $request, $articleId)
    {
        return Message::create([
            'message_article_id' => $articleId,
            'message_author_id' => JWTAuth::user()->id,
            'message_author' => JWTAuth::user()->name,
            'message_content' => $request->content,
        ]);
    }

    public function messageDestroy($messageId)
    {
        return Message::where('message_id', '=', $messageId)->delete();
    }

    public function messageDestroyByArticleId($articleId)
    {
        return Message::where('message_article_id', '=', $articleId)->delete();
    }

    public function getmessageById($messageId)
    {
        return Message::where('message_id', '=', $messageId)->get();
    }

    public function getmessageByArticleId($articleId)
    {
        return Message::where('message_article_id', '=', $articleId)->get();
    }

}
