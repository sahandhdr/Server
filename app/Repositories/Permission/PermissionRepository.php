<?php

namespace App\Repositories\Permission;

use App\Models\Permission\Permission;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Permission\PermissionRepositoryInterfaces;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterfaces
{
    public function __construct(Permission $model)
    {
        Parent::__construct($model);
    }
}
