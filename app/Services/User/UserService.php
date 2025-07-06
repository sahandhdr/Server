<?php

namespace App\Services\User;

use App\Repositories\Interfaces\User\UserRepositoryInterfaces;
use App\Services\Interfaces\User\UserServiceInterfaces;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterfaces
{
    private UserRepositoryInterfaces $repository;

    public function __construct(UserRepositoryInterfaces $repository)
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

    public function checkExistsUserById(int $id): bool
    {
        return $this->repository->checkExists($id);
    }

    public function upload_pic(array $attributes): array
    {
        return $this->repository->upload_pic($attributes);
    }

    public function removeUserPicFromStorage(int $user_id): array
    {
        return $this->repository->removeUserPicFromStorage($user_id);
    }
}
