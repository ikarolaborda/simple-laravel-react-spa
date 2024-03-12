<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(
        private readonly CategoryService $categoryService
    )
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->paginate(15));
    }


    public function store(Request $request): JsonResponse
    {
        //
    }

    public function show($id): JsonResponse
    {
        //
    }

    public function update(Request $request, $id): JsonResponse
    {
        //
    }

    public function destroy($id): JsonResponse
    {
        //
    }
}
