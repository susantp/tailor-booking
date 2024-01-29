<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait CheckPermissionTrait {

    public function checkPermission($user_id, $role_id, $permission_name, $return = false) {
        if (Auth::user()->is_super_admin == 1) {
            return true;
        }

        $check = User::join('roles', 'users.role_id', '=', 'roles.id')
                ->join('role_permissions', 'role_permissions.role_id', '=', 'roles.id')
                ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                ->where('permissions.name', '=', $permission_name)
                ->where('users.id', '=', $user_id)
                ->where('users.role_id', '=', $role_id)
                ->get();

        if (count($check) > 0) {
            return true;
        }

        if ($return == true) {
            return false;
        }

        abort(503);
    }

}
