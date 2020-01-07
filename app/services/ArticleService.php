<?php

namespace App\services;

use App\repositories\ArticleRepository;
use App\repositories\MessageRepository;
use App\repositories\RoleRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleService
{
    protected $articleRepo;
    protected $messageRepo;
    protected $roleRepo;

    public function __construct(ArticleRepository $articleRepo, MessageRepository $messageRepo, RoleRepository $roleRepo)
    {
        $this->articleRepo = $articleRepo;
        $this->messageRepo = $messageRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        return $this->articleRepo->getAllArticle();
    }

    public function store(Request $request)
    {
        return $this->articleRepo->articleStore($request);
    }

    public function show($articleId)
    {
        $article = $this->articleRepo->getArticleById($articleId);
        $messages = $this->messageRepo->getMessageByArticleId($articleId);
        return [
            'article' => $article,
            'messages' => $messages,
        ];
    }

    public function edit($articleId)
    {
        return $this->articleRepo->getArticleById($articleId);
    }

    public function update($request, $articleId)
    {
        return $this->articleRepo->articleEdit($request, $articleId);
    }

    public function destroy($articleId)
    {
        return $this->articleRepo->articleDestroy($articleId);
    }

    public function catagory($catagory)
    {
        return $this->articleRepo->getArticleByCatagory($catagory);
    }

    public function search($key)
    {
        return $this->articleRepo->getArticleByKeyword($key);
    }

    public function user($name)
    {
        return $this->articleRepo->getArticleByUsername($name);
    }

    public function getArticle($articleId)
    {
        return $this->articleRepo->getArticleById($articleId);
    }
}
