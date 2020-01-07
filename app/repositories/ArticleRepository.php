<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'author_id' => Auth::user()->id,
            'author' => Auth::user()->name,
            'title' => $request->title,
            'catagory' => $request->catagory,
            'content' => $request->content,
        ]);
    }

    public function articleEdit(Request $request, $id)
    {
        return Article::where('id', $id)
            ->update([
                'title' => $request->title,
                'catagory' => $request->catagory,
                'content' => $request->content,
            ]);
    }

    public function articleDestroy($id)
    {
        return Article::find($id)->delete();
    }

    public function getAllArticle()
    {
        return Article::orderby('id')->get();
    }

    public function getArticleById($id)
    {
        return Article::where('id', '=', $id)->get();
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
