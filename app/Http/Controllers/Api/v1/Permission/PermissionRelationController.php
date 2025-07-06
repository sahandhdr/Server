<?php

namespace App\Http\Controllers\Api\v1\Permission;

use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class PermissionRelationController extends ApiController
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }

//    --------------------------- role ---------------------------
    public function attachRoleToPermission($permission_id, $role_id)
    {
        return $this->service->attach(
            'permissions',            // جدول اصلی
            'roles',      // جدول مرتبط
            'role_permission',  // جدول میانی (pivot)
            'permission_id',          // کلید خارجی جدول اصلی در جدول میانی
            'role_id',    // کلید خارجی جدول مرتبط در جدول میانی
            $permission_id,
            $role_id
        );
    }

    public function detachRoleFromPermission($permission_id, $role_id)
    {
        return $this->service->detach(
            'permissions',            // جدول اصلی
            'roles',      // جدول مرتبط
            'role_permission',  // جدول میانی (pivot)
            'permission_id',          // کلید خارجی جدول اصلی در جدول میانی
            'role_id',    // کلید خارجی جدول مرتبط در جدول میانی
            $permission_id,
            $role_id
        );
    }

    public function syncRolesWithPermission(Request $request, $permission_id)
    {
        return $this->service->sync(
            'roles',
            'permissions',
            'role_permission',
            'role_id',
            'permission_id',
            $permission_id,
            $request->role_ids, // باید یک آرایه از IDها باشد
        );
    }
}
