<?php

namespace App\services;

use App\repositories\ArticleRepository;
use App\repositories\MessageRepository;
use App\repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            $this->roleRepo->checkRoleInit(Auth::user()->id);
        }

        return $this->articleRepo->getAllArticle();
    }

    public function store(Request $request)
    {
        return $this->articleRepo->articleStore($request);
    }

    public function show($id)
    {
        $article = $this->articleRepo->getArticleById($id);
        $messages = $this->messageRepo->getMessageByArticleId($id);
        return [
            'article' => $article,
            'messages' => $messages,
        ];
    }

    public function edit($id)
    {
        return $this->articleRepo->getArticleById($id);
    }

    public function update($request, $id)
    {
        return $this->articleRepo->articleEdit($request, $id);
    }

    public function destroy($id)
    {
        return $this->articleRepo->articleDestroy($id);
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

    public function getArticle($id)
    {
        return $this->articleRepo->getArticleById($id);
    }
}
