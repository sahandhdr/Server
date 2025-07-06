<?php

namespace App\Services\Interfaces\Auth;

use Illuminate\Database\Eloquent\Model;

interface AuthServiceInterfaces
{
    public function register(array $attributes): array;
    public function login(array $attributes): array;
    public function logout(): array;
    public function changePassword(array $data, int $user_id): array;
}
