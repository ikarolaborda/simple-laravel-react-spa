<?php

namespace App\Contracts;

interface BaseServiceInterface
{

    public function all(): array | object;

    public function create(array $data): ?object;

    public function update(array $data, int $id): ?object;

    public function delete(int $id): bool;

    public function show(int $id): ?object;
}
