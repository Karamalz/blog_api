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
                'message' => '查詢失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
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
                'message' => '文章儲存失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '文章新增成功',
                'data' => '',
            ], 200);
        }
    }

    // show $id article
    public function show($id)
    {
        $article = $this->articleService->show($id);
        if ($article['article']->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => '此文章不存在',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
                'data' => [
                    'articles' => $article['article'],
                    'messages' => $article['messages'],
                ],
            ], 200);
        }
    }

    // show edit article page with $id article
    public function edit($id)
    {
        $article = $this->articleService->edit($id);
        if ($article->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => '此文章不存在',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
                'data' => $article,
            ], 200);
        }
    }

    // update $id article
    public function update(articleRequest $request, $id)
    {
        if (!$this->articleService->update($request, $id)) {
            return response()->json([
                'success' => false,
                'message' => '修改文章失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '文章修改成功',
                'data' => '',
            ], 200);
        }
    }

    // destroy $id article
    public function destroy($id)
    {
        if (!$this->articleService->destroy($id)) {
            return response()->json([
                'success' => false,
                'message' => '刪除文章失敗',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '文章刪除成功',
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
                'message' => '無此分類文章',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
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
                'message' => '無此關鍵字文章',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
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
                'message' => '無此作者文章',
                'data' => '',
            ], 500);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查詢成功',
                'data' => $articles,
            ], 200);
        }
    }
}
