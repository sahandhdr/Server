<?php

namespace App\Services\Permission;

use App\Repositories\Interfaces\Permission\PermissionRepositoryInterfaces;
use App\Services\Interfaces\Permission\PermissionServiceInterfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PermissionService implements PermissionServiceInterfaces
{
    private PermissionRepositoryInterfaces $repository;

    public function __construct(PermissionRepositoryInterfaces $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->index();
    }

    public function store(array $attributes): ?Model
    {
        return $this->repository->store($attributes);
    }

    public function update(array $attributes, int $id): bool
    {
        return $this->repository->update($attributes, $id);
    }

    public function show(int $id): ?Model
    {
        return $this->repository->show($id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function search(array $columns = ['*'], array $relations = [], array $filters = []): Collection
    {
        return $this->repository->search($columns, $relations, $filters);
    }

    public function checkExistsPermissionById(int $id): bool
    {
        return $this->repository->checkExists($id);
    }
}
