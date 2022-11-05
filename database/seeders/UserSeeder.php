<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users
        $adminUser = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        $workerUser = User::create([
            'name' => 'worker',
            'email' => 'worker@worker.com',
            'password' => bcrypt('workerworker')
        ]);
        $guestUser = User::create([
            'name' => 'guest',
            'email' => 'guest@guest.com',
            'password' => bcrypt('guestguest')
        ]);

        // Create Roles
        $adminRole = Role::create([
            'name' => 'admin',
        ]);
        $workerRole = Role::create([
            'name' => 'worker',
        ]);
        $guestRole = Role::create([
            'name' => 'guest',
        ]);

        // Create Permissions
        $getUsersPermission = Permission::create([
            'name' => 'get users',
        ]);
        $getProductPermission = Permission::create([
            'name' => 'get products',
        ]);
        $getAdminProductsPermission = Permission::create([
            'name' => 'view admin-products',
        ]);

        // Assign roles
        $adminUser->assignRole($adminRole);
        $workerUser->assignRole($workerRole);
        $guestUser->assignRole($guestRole);

        // Assign Admin Permissions
        $adminRole->givePermissionTo($getUsersPermission);
        $adminRole->givePermissionTo($getProductPermission);
        $adminRole->givePermissionTo($getAdminProductsPermission);

        // Assign Admin Permissions
        $workerRole->givePermissionTo($getUsersPermission);
        $workerRole->givePermissionTo($getProductPermission);

        // Assign Admin Permissions
        $guestRole->givePermissionTo($getUsersPermission);


        // Personal Acces Token for Users.
        $tokenAdmin = $adminUser->createToken('admin')->plainTextToken;

        $tokenWorker = $workerUser->createToken('worker')->plainTextToken;

        $tokenGuest = $guestUser->createToken('guest')->plainTextToken;

        Storage::put('./SanctumAuth.txt', [
            'admin  =>   ' . $tokenAdmin . "\r\n",
            'worker =>   ' . $tokenWorker . "\r\n",
            'guest  =>   ' . $tokenGuest . "\r\n",
        ]);
    }
}
