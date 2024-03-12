<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class PostRepository extends BaseRepository
{

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function show(int $id): ?object
    {
        return $this->model->find($id);
    }

    public function getCategories(int $postId): array | object | null
    {
        $post = $this->model->findOrFail($postId);
        if (!$post->relationLoaded('categories')) {
            $post->load('categories');
        }
        return $post->categories;
    }

    public function paginateWithSearch(int $perPage = 15, ?string $searchTerm = ''): LengthAwarePaginator
    {
        $query = $this->model->where('title', 'like', "%{$searchTerm}%")
            ->orWhere('content', 'like', "%{$searchTerm}%")
            ->orWhere('created_at', 'like', "%{$searchTerm}%")
            ->orWhereHas('categories', function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%");
            });

        return $query->paginate($perPage);
    }


}
