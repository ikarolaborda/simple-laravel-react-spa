<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{

    public function __construct(
        protected PostService $postService
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        return PostResource::make(
            $this->postService
                ->paginateWithSearch(15, $request->input('search', '')))
            ->response();
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json([]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->postService->show($id));
    }

    public function categories(int $postId): JsonResponse
    {
        return response()->json($this->postService->getCategories($postId));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json([]);
    }

    public function destroy(int $id): JsonResponse
    {
        return response()->json([]);
    }
}
