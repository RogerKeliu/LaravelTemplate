<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function showWithRoles(User $id)
    {
        return User::with('roles')->find($id)->first()->toArray();
    }
    /** */
    public function assignRole(User $user, Role $role)
    {
        $user->assignRole($role);
    }

    /** */
    public function removeRole(User $user, Role $role)
    {
        $user->removeRole($role);
    }

    /** */
    public function removeAllRoles(User $user)
    {
        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
    }
}
