<?php

namespace App\Repositories\Department;

use App\Models\Department\Department;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Department\DepartmentRepositoryInterfaces;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterfaces
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }
}
