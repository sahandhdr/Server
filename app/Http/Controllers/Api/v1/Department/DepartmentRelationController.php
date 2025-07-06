<?php

namespace App\Http\Controllers\Api\v1\Department;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class DepartmentRelationController extends Controller
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }

    //    -------------------------- user --------------------------
    public function attachDepartmentToUser($dept_id, $user_id)
    {
        return $this->service->attach(
            'departments',
            'users',
            'dept_user',
            'dept_id',
            'user_id',
            $dept_id,
            $user_id
        );
    }

    public function detachDepartmentFromUser($dept_id, $user_id)
    {
        return $this->service->detach(
            'departments',
            'users',
            'dept_user',
            'dept_id',
            'user_id',
            $dept_id,
            $user_id
        );
    }

    public function syncDepartmentsWithUser(Request $request, $dept_id)
    {
        return $this->service->sync(
            'departments',
            'users',
            'dept_user',
            'dept_id',
            'user_id',
            $dept_id,
            $request->user_ids // باید یک آرایه از IDها باشد
        );
    }
}
