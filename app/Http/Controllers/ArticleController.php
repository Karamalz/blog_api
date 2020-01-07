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

    // display all articles
    public function index()
    {
        $articles = $this->articleService->index();
        if ($articles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Query failed',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $articles,
            ], 200);
        }
    }

    // store input article
    public function store(articleRequest $request)
    {
        if (!$this->articleService->store($request)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to store article!',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Store article success',
                'data' => '',
            ], 200);
        }
    }

    // show $id article
    public function show($articleId)
    {
        $article = $this->articleService->show($articleId);
        if ($article['article']->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Article with ID:' . $articleId . ' is not exist!',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => [
                    'articles' => $article['article'],
                    'messages' => $article['messages'],
                ],
            ], 200);
        }
    }

    // show edit article page with $id article
    public function edit($articleId)
    {
        $article = $this->articleService->edit($articleId);
        if ($article->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Article with ID:' . $articleId . ' is not exist!',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $article,
            ], 200);
        }
    }

    // update $id article
    public function update(articleRequest $request, $articleId)
    {
        if (!$this->articleService->update($request, $articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to edit article',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Edit article success',
                'data' => '',
            ], 200);
        }
    }

    // destroy $id article
    public function destroy($articleId)
    {
        if (!$this->articleService->destroy($articleId)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete article',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Delete article success',
                'data' => '',
            ], 200);
        }
    }

    // find and show all $catagory article
    public function catagory($catagory)
    {
        $articles = $this->articleService->catagory($catagory);
        if ($articles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'There is no article with catagory:' . $catagory,
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $articles,
            ], 200);
        }
    }

    // find and show article which title contains $request->key
    public function search(Request $request)
    {
        $articles = $this->articleService->search($request->key);
        if ($articles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'There is no article with keyword:' . $request->key,
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $articles,
            ], 200);
        }
    }

    // find and show article which author is $name
    public function user($name)
    {
        $articles = $this->articleService->user($name);
        if ($articles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'There is no article with author:' . $name,
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Query success',
                'data' => $articles,
            ], 200);
        }
    }
}
