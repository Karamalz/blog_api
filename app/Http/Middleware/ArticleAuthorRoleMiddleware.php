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
        $article = $this->articleService->getArticle($request->route('id'));
        if ($article[0]->author_id != JWTAuth::user()->id && JWTAuth::user()->roles->roles=='normal') {
            return response()->json([
                'result' => false,
                'message' => 'You are not the author or admin!',
            ], 403);
        }
        return $next($request);
    }
}
