<?php

use App\Http\Controllers\Chat\Master\SettingChatController;
use App\Http\Controllers\Setting\RolePermissionController;
use App\Http\Controllers\Setting\UserAccessController;
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

        // User Access
            Route::get('user_access', [UserAccessController::class, 'index'])->name('user_access');
            Route::get('getRoleUser', [UserAccessController::class, 'getRoleUser'])->name('getRoleUser');
            Route::get('getUser', [UserAccessController::class, 'getUser'])->name('getUser');
            Route::get('getUserDepartment', [UserAccessController::class, 'getUserDepartment'])->name('getUserDepartment');
            Route::post('addRoleUser', [UserAccessController::class, 'addRoleUser'])->name('addRoleUser');
            Route::get('detailRoleUser', [UserAccessController::class, 'detailRoleUser'])->name('detailRoleUser');
            Route::post('updateRoleUser', [UserAccessController::class, 'updateRoleUser'])->name('updateRoleUser');
            Route::get('getRolePermissionDetail', [UserAccessController::class, 'getRolePermissionDetail'])->name('getRolePermissionDetail');
            Route::post('saveRolePermission', [UserAccessController::class, 'saveRolePermission'])->name('saveRolePermission');
            Route::get('destroyRolePermission', [UserAccessController::class, 'destroyRolePermission'])->name('destroyRolePermission');
        // User Access
    // Setting
            
        // Chat
        // Setting Chat
            Route::get('setting_chat_menus', [SettingChatController::class, 'index'])->name('setting_chat_menus');
            Route::get('getGroup', [SettingChatController::class, 'getGroup'])->name('getGroup');
            Route::get('detailGroup', [SettingChatController::class, 'detailGroup'])->name('detailGroup');
            Route::post('addGroup', [SettingChatController::class, 'addGroup'])->name('addGroup');
            Route::post('updateDetailGroup', [SettingChatController::class, 'updateDetailGroup'])->name('updateDetailGroup');
            Route::get('getDetailGroup', [SettingChatController::class, 'getDetailGroup'])->name('getDetailGroup');
            Route::post('updateGroup', [SettingChatController::class, 'updateGroup'])->name('updateGroup');

        // Setting Chat
    // Chat

  

});
