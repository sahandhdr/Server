<?php

namespace App\Services\Interfaces\AgentSnapshot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AgentSnapshotServiceInterfaces
{
    public function index(array $relations = []) :Collection;
    public function store(array $attributes): ?Model;
    public function update(array $attributes, int $id): bool;
    public function show(int $id, array $relations = []): ?Model;
    public function delete(int $id): bool;
    public function search(array $columns = ['*'], array $relations = [], array $filters = []) :Collection;
    public function checkExistsAgentSnapshotById(int $id): bool;

}
