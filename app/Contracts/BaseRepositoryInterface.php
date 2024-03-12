<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{

    public function all(): array | object;

    public function create(array $data) : ?object;

    public function update(array $data, int $id) : ?object;

    public function delete(int $id): bool;

    public function show(int $id) : ?object;

    public function paginate(int $perPage = 15, array $columns = ['*'], string $pageName = 'page', ?int $page = null): LengthAwarePaginator;
}
