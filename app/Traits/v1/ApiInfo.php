<?php

namespace App\Traits\v1;

use App\Models\User;

trait ApiInfo
{
    protected function getUserAclInfo($user_id)
    {
        $user = User::where('id', $user_id)->first();

        // اگر کاربر وجود نداشت
        if (!$user)
            return ['message' => 'user-notFound', 'code' => 404];

        // دریافت نقش‌ها
        $roles = $user->roles()->with('permissions')->select('name_en', 'name_fa')->get()->toArray();

        $permissions = $user->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique('id');

        $departments = $user->departments()->get()->toArray();

        $dept_ids = $user->departments();

        return [
            'roles' => $roles,
            'permissions' => $permissions,
            'departments' => $departments,
            'dept_ids' => $dept_ids
        ];
    }

}
