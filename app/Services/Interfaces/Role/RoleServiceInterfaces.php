<?php

namespace App\Services\Interfaces\Role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RoleServiceInterfaces
{
    public function index() :Collection;
    public function store(array $attributes): ?Model;
    public function update(array $attributes, int $id): bool;
    public function show(int $id): ?Model;
    public function delete(int $id): bool;
    public function search(array $columns = ['*'], array $relations = [], array $filters = []) :Collection;
    public function checkExistsRoleById(int $id): bool;
}
