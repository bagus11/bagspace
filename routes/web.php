<?php

use App\Http\Controllers\Setting\RolePermissionController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    // Setting
        // Role Permission  
        Route::get('role_permission', [RolePermissionController::class, 'index'])->name('role_permission');
        Route::get('getRole', [RolePermissionController::class, 'getRole'])->name('getRole');
        Route::get('getPermission', [RolePermissionController::class, 'getPermission'])->name('getPermission');
        Route::get('deleteRole', [RolePermissionController::class, 'deleteRole'])->name('deleteRole');
        Route::post('addRole', [RolePermissionController::class, 'addRole'])->name('addRole');
        Route::get('detailRole', [RolePermissionController::class, 'detailRole'])->name('detailRole');
        Route::post('updateRole', [RolePermissionController::class, 'updateRole'])->name('updateRole');
        Route::get('permissionMenus', [RolePermissionController::class, 'permissionMenus'])->name('permissionMenus');
        Route::post('savePermission', [RolePermissionController::class, 'savePermission'])->name('savePermission');
        Route::get('deletePermission', [RolePermissionController::class, 'deletePermission'])->name('deletePermission');
        // Role Permission
    // Setting

  

});
