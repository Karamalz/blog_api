<?php

namespace App\Http\Middleware;

use App\services\ArticleService;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleAuthorRoleMiddleware
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function handle($request, Closure $next)
    {
        if (!preg_match('/\d{1,}/', $request->route('articleId'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid article ID',
                'data' => '',
            ], 422);
        }
        $articles = $this->articleService->getArticle($request->route('articleId'));
        if ($articles->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Article with ID:' . $request->route('articleId') . ' is not exist',
                'data' => '',
            ], 404);
        }
        if ($articles[0]->author_id != JWTAuth::user()->id && JWTAuth::user()->roles->roles == 'normal') {
            return response()->json([
                'success' => false,
                'message' => 'You are not the author or admin!',
                'data' => '',
            ], 403);
        }
        return $next($request);
    }
}
