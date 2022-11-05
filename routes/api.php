<?php

use App\Http\Controllers\Api\PermissionControlller;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\RolePermissionController;
use App\Http\Controllers\Api\UserRoleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', function () {
    return view('landing');
});

Route::post('/tokens/create', function (Request $request) {
    $token = User::first()->createToken($request->token_name);
    dd($token->plainTextToken);
    return ['token' => $token->plainTextToken];
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me/profile', [MeController::class, 'index']);
    Route::get('/me/profile/lang', [MeController::class, 'lang']);
    Route::post('/me/profile/lang', [MeController::class, 'langStore']);
    Route::get('/admin-users', [UserController::class, 'index']);

    /**
     * Resources
     */

    Route::resource('/user', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/permission', PermissionControlller::class);

    /**
     * Views
    */

    Route::post('/canView', [\App\Http\Controllers\Api\MeController::class, 'canView']);


    /**
     *
     * Relations
     *
     */

    /** User Roles */

    Route::post('user/{user}/assignRole/{role}', [UserRoleController::class, 'assignRole']);
    Route::post('user/{user}/removeRole/{role}', [UserRoleController::class, 'removeRole']);
    Route::post('user/{user}/removeRoles', [UserRoleController::class, 'removeAllRoles']);
    Route::get('user/{id}/roles', [UserRoleController::class, 'showWithRoles']);

    /** Role Permissions */

    Route::get('role/{role}/permission', [RolePermissionController::class, 'showWithPermissions']);
    Route::post('role/{role}/assignPermission/{permission}', [RolePermissionController::class, 'assignPermission']);
    Route::post('role/{role}/removePermission/{permission}', [RolePermissionController::class, 'removePermission']);
    Route::post('role/{role}/removePermissions', [RolePermissionController::class, 'removeAllPermission']);
});
