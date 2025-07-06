<?php

namespace App\Services\Interfaces\Agent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface AgentServiceInterfaces
{
    public function index(array $relations = []) :Collection;
    public function store(array $attributes): ?Model;
    public function update(array $attributes, int $id): bool;
    public function show(int $id, array $relations = []): ?Model;
    public function delete(int $id): bool;
    public function search(array $columns = ['*'], array $relations = [], array $filters = []) :Collection;
    public function checkExistsAgentById(int $id): bool;

    public function checkExistsAgentByMac($mac_address): bool;
}
