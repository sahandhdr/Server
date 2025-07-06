<?php

namespace App\Repositories\Role;

use App\Models\Permission\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Role\RoleRepositoryInterfaces;

class RoleRepository extends BaseRepository implements RoleRepositoryInterfaces
{
    public function __construct(Role $model)
    {
        Parent::__construct($model);
    }
}
