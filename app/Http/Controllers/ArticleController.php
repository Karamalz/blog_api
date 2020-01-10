<?php

namespace App\Http\Controllers;

use App\Http\Requests\articleRequest;
use App\services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    // return all articles
    public function index()
    {
        $articles = $this->articleService->index();
        return response()->json([
            'success' => true,
            'message' => $articles->isEmpty() ? 'No Article found' : 'Query success',
            'data' => $articles->isEmpty() ? '' : $articles,
        ], 200);
    }

    // store input article
    public function store(articleRequest $request)
    {
        $response = $this->articleService->store($request);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Store article success' : 'Failed to store article',
            'data' => '',
        ], 200);
    }

    // return $id article & messages
    public function show($articleId)
    {
        if (!preg_match('/^[0-9]+$/', $articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid article ID',
                'data' => '',
            ], 422);
        }
        $article = $this->articleService->show($articleId);
        return response()->json([
            'success' => true,
            'message' => $article['article']->isEmpty() ? 'Article with ID:' . $articleId . ' is not exist!' : 'Query success',
            'data' => $article['article']->isEmpty() ? '' : [
                'articles' => $article['article'],
                'messages' => $article['messages'],
            ],
        ], 200);
    }

    // return $id article
    public function edit($articleId)
    {
        $article = $this->articleService->edit($articleId);
        return response()->json([
            'success' => true,
            'message' => 'Query success',
            'data' => $article,
        ], 200);
    }

    // update $id article
    public function update(articleRequest $request, $articleId)
    {
        $response = $this->articleService->update($request, $articleId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Update article success' : 'Failed to update article',
            'data' => '',
        ], 200);
    }

    // destroy $id article
    public function destroy($articleId)
    {
        $response = $this->articleService->destroy($articleId);
        return response()->json([
            'success' => true,
            'message' => $response ? 'Delete article success' : 'Failed to delete article',
            'data' => '',
        ], 200);
    }

    // find and return all $catagory article
    public function catagory($catagory)
    {
        $articles = $this->articleService->catagory($catagory);
        return response()->json([
            'success' => true,
            'message' => $articles->isEmpty() ? 'There is no article with catagory:' . $catagory : 'Query success',
            'data' => $articles->isEmpty() ? '' : $articles,
        ], 200);
    }

    // find and return article which title contains $request->key
    public function search(Request $request)
    {
        $articles = $this->articleService->search($request->key);
        return response()->json([
            'success' => true,
            'message' => $articles->isEmpty() ? 'There is no article with keyword:' . $request->key : 'Query success',
            'data' => $articles->isEmpty() ? '' : $articles,
        ], 200);
    }

    // find and return article which author is $name
    public function user($name)
    {
        $articles = $this->articleService->user($name);
        return response()->json([
            'success' => true,
            'message' => $articles->isEmpty() ? 'There is no article with author:' . $name : 'Query success',
            'data' => $articles->isEmpty() ? '' : $articles,
        ], 200);
    }
}
