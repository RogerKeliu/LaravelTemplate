<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function showWithPermissions($role)
    {
        // injeccio dependencies no funciona perquè utilizem model extends Spatie
        return(Role::with('permissions')->find($role));
    }

    public function removePermission(Role $role, Permission $permission) {
        $role->revokePermissionTo($permission);
    }

    public function removeAllPermission(Role $role) {
        $role->syncPermissions();
    }

    public function assignPermission(Role $role, Permission $permission)
    {
        $role->givePermissionTo($permission);
    }
}
