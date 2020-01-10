<?php

namespace App\Repositories;

use App\entities\Article;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleRepository
{

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function articleStore(Request $request)
    {
        return Article::create([
            'author_id' => JWTAuth::user()->id,
            'author' => JWTAuth::user()->name,
            'title' => $request->title,
            'catagory' => $request->catagory,
            'content' => $request->content,
        ]);
    }

    public function articleEdit(Request $request, $articleId)
    {
        return Article::where('id', $articleId)
            ->update([
                'title' => $request->title,
                'catagory' => $request->catagory,
                'content' => $request->content,
            ]);
    }

    public function articleDestroy($articleId)
    {
        return Article::find($articleId)->delete();
    }

    public function getAllArticle()
    {
        return Article::orderby('id')->get();
    }

    public function getArticleById($articleId)
    {
        return Article::where('id', '=', $articleId)->get();
    }

    public function getArticleByCatagory($catagory)
    {
        return Article::where('catagory', '=', $catagory)->get();
    }

    public function getArticleByKeyword($key)
    {
        return Article::where('title', 'like', "%" . $key . "%")->get();
    }

    public function getArticleByUsername($name)
    {
        return Article::where('author', '=', $name)->get();
    }

}
