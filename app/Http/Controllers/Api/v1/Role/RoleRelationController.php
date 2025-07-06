<?php

namespace App\Http\Controllers\Api\v1\Role;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\Pivot\PivotServiceInterfaces;
use Illuminate\Http\Request;

class RoleRelationController extends Controller
{
    private PivotServiceInterfaces $service;

    public function __construct(PivotServiceInterfaces $service)
    {
        $this->service = $service;
    }
//    -------------------------- permission --------------------------
    public function attachPermissionToRole($role_id, $permission_id)
    {
        return $this->service->attach(
            'roles',            // جدول اصلی
            'permissions',      // جدول مرتبط
            'role_permission',  // جدول میانی (pivot)
            'role_id',          // کلید خارجی جدول اصلی در جدول میانی
            'permission_id',    // کلید خارجی جدول مرتبط در جدول میانی
            $role_id,
            $permission_id
        );
    }

    public function detachPermissionFromRole($role_id, $permission_id)
    {
        return $this->service->detach(
            'roles',
            'permissions',
            'role_permission',
            'role_id',
            'permission_id',
            $role_id,
            $permission_id
        );
    }

    public function syncPermissionsWithRole(Request $request, $role_id)
    {
        return $this->service->sync(
            'roles',
            'permissions',
            'role_permission',
            'role_id',
            'permission_id',
            $role_id,
            $request->permission_ids // باید یک آرایه از IDها باشد
        );
    }

//    -------------------------- user --------------------------
    public function attachUserToRole($role_id, $user_id)
    {
        return $this->service->attach(
            'roles',            // جدول اصلی
            'users',      // جدول مرتبط
            'role_user',  // جدول میانی (pivot)
            'role_id',          // کلید خارجی جدول اصلی در جدول میانی
            'user_id',    // کلید خارجی جدول مرتبط در جدول میانی
            $role_id,
            $user_id
        );
    }

    public function detachUserFromRole($role_id, $user_id)
    {
        return $this->service->detach(
            'roles',            // جدول اصلی
            'users',      // جدول مرتبط
            'role_user',  // جدول میانی (pivot)
            'role_id',          // کلید خارجی جدول اصلی در جدول میانی
            'user_id',    // کلید خارجی جدول مرتبط در جدول میانی
            $role_id,
            $user_id
        );
    }

    public function syncUsersWithRole(Request $request, $role_id)
    {
        return $this->service->sync(
            'roles',
            'users',
            'role_user',
            'role_id',
            'user_id',
            $role_id,
            $request->user_ids // باید یک آرایه از IDها باشد
        );
    }


}
