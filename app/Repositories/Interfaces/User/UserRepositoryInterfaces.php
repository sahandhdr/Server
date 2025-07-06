<?php

namespace App\Repositories\Interfaces\User;

use App\Repositories\Interfaces\BaseRepositoryInterfaces;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterfaces extends BaseRepositoryInterfaces
{

    public function upload_pic(array $attributes): array;

    public function removeUserPicFromStorage(int $user_id): array;

    public function delete_pic($pic_path): array;
}
