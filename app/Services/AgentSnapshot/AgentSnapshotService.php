<?php

namespace App\Services\AgentSnapshot;

use App\Repositories\AgentSnapshot\AgentSnapShotRepository;
use App\Repositories\Interfaces\AgentSnapshot\AgentSnapshotRepositoryInterfaces;
use App\Repositories\Interfaces\BaseRepositoryInterfaces;
use App\Services\Interfaces\AgentSnapshot\AgentSnapshotServiceInterfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AgentSnapshotService implements AgentSnapshotServiceInterfaces
{
    private AgentSnapShotRepositoryInterfaces $repository;

    public function __construct(AgentSnapShotRepositoryInterfaces $repository)
    {
        $this->repository = $repository;
    }

    public function index(array $relations = []): Collection
    {
        return $this->repository->index($relations);
    }

    public function store(array $attributes): ?Model
    {
        return $this->repository->store($attributes);
    }

    public function update(array $attributes, int $id): bool
    {
        return $this->repository->update($attributes, $id);
    }

    public function show(int $id, array $relations = []): ?Model
    {
        return $this->repository->show($id, $relations);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function search(array $columns = ['*'], array $relations = [], array $filters = []): Collection
    {
        return $this->repository->search($columns, $relations, $filters);
    }

    public function checkExistsAgentSnapshotById(int $id): bool
    {
        return $this->repository->checkExists($id);
    }
}
