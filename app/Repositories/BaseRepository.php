<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(
        protected Model $model
    )
    {
    }

    public function all(): array | object
    {
        return $this->model->all();
    }

    public function create(array $data): ?object
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id): ?object
    {
        try {
            $record = $this->model->find($id);
            return $record->update($data);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function delete($id): bool
    {
        return $this->model->destroy($id);
    }

    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns, $pageName, $page);
    }

    abstract public function show(int $id): ?object;
}
