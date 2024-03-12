<?php

namespace App\Services;

use App\Contracts\BaseRepositoryInterface;
use App\Repositories\PostRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostService extends BaseService
{
    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);
    }

    public function show(int $id): ?object
    {
        return $this->repository->show($id);
    }

    public function getCategories(int $postId): array | object | null
    {
        return $this->repository->getCategories($postId);
    }

    public function paginateWithSearch(int $perPage = 15, ?string $searchTerm = ''): LengthAwarePaginator
    {
        return $this->repository->paginateWithSearch($perPage, $searchTerm);
    }
}
