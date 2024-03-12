<?php

namespace App\Services;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

abstract class BaseService implements BaseServiceInterface
{
    public function __construct(
        protected BaseRepositoryInterface $repository
    )
    {
    }

    public function all(): array | object
    {
        return $this->repository->all();
    }

    public function create(array $data): ?object
    {
        return $this->repository->create($data);
    }

    public function update(array $data, int $id): ?object
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginate($perPage);
    }

    abstract public function show(int $id): ?object;
}
