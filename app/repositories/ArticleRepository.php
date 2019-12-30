<?php

namespace App\Repositories;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleRepository{

    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function articleStore(Request $request)
    {
        Article::create([
            'author_id' => Auth::user()->id,
            'author' => Auth::user()->name,
            'title' => $request->title,
            'catagory' => $request->catagory,
            'content' => $request->content,
        ]);

        return;
    }

    public function articleEdit(Request $request, $id)
    {
        $update_article = $this->article->find($id);
        $update_article->title = $request->title;
        $update_article->catagory = $request->catagory;
        $update_article->content = $request->content;
        $update_article->save();

        return;
    }

    public function articleDestroy($id)
    {      
        return Article::find($id)->delete();
    }

    public function getAllArticle()
    {
        return Article::all();
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
        return Article::where('title', 'like', "%".$key."%")->get();
    }

    public function getArticleByUsername($name)
    {
        return Article::where('author', '=', $name)->get();
    }

}