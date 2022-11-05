<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // dd(Role::with('permissions')->find(1)->toArray());
    return view('landing');
});

Route::get('/login', function () {
    if (Auth::user()) {
        Auth::guard('web')->logout();
    }
    return view('auth');
})->name('login');

Route::get('products', [\App\Http\Controllers\Api\ProductController::class, 'index']);

Route::get('/me', [\App\Http\Controllers\Api\MeController::class, 'index']);

Route::middleware('auth:sanctum')->get('/app/{any?}', function () {
    return view('app');
})->where('any', '.*')->name('app');

Route::get('user/{id}/roles', [\App\Http\Controllers\Api\UserRoleController::class, 'showWithRoles']);
