<?php

namespace App\Policies;


class Helpers {
    public static function userCanDoAction($user, $action, $guard = 'web') {
        $userPermissions = $user->getPermissionsViaRoles();

        foreach($userPermissions as $permission) {
            if ($permission->name === $action) {
                return true;
            }
        }
        return false;
    }
}

