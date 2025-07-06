<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class UserRelationController extends Controller
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }

    //    -------------------------- role --------------------------
    public function attachRoleToUser($user_id, $role_id)
    {
        return $this->service->attach(
            'users',
            'roles',
            'role_user',
            'user_id',
            'role_id',
            $user_id,
            $role_id
        );
    }

    public function detachRoleFromUser($user_id, $role_id)
    {
        return $this->service->detach(
            'users',
            'roles',
            'role_user',
            'user_id',
            'role_id',
            $user_id,
            $role_id
        );
    }

    public function syncRolesWithUser(Request $request, $user_id)
    {
        return $this->service->sync(
            'users',
            'roles',
            'role_user',
            'user_id',
            'role_id',
            $user_id,
            $request->role_ids // باید یک آرایه از IDها باشد
        );
    }

    //    -------------------------- department --------------------------
    public function attachDepartmentToUser($user_id, $dept_id)
    {
        return $this->service->attach(
            'users',
            'departments',
            'dept_user',
            'user_id',
            'dept_id',
            $user_id,
            $dept_id
        );
    }

    public function detachDepartmentFromUser($user_id, $dept_id)
    {
        return $this->service->detach(
            'users',
            'departments',
            'dept_user',
            'user_id',
            'dept_id',
            $user_id,
            $dept_id
        );
    }

    public function syncDepartmentsWithUser(Request $request, $user_id)
    {
        return $this->service->sync(
            'users',
            'departments',
            'dept_user',
            'user_id',
            'dept_id',
            $user_id,
            $request->dept_ids // باید یک آرایه از IDها باشد
        );
    }
}
