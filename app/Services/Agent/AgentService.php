<?php

namespace App\Services\Agent;

use App\Models\Agent\Agent;
use App\Repositories\Interfaces\Agent\AgentRepositoryInterfaces;
use App\Services\Interfaces\Agent\AgentServiceInterfaces;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AgentService implements AgentServiceInterfaces
{
    private AgentRepositoryInterfaces $repository;

    public function __construct(AgentRepositoryInterfaces $repository)
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

    public function checkExistsAgentById(int $id): bool
    {
        return $this->repository->checkExists($id);
    }

    public function checkExistsAgentByMac($mac_address): bool
    {
        return $this->repository->checkExistsAgentByMac($mac_address);
    }
}
