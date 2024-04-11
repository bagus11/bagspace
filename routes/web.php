<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Booking\MasterApprovalController;
use App\Http\Controllers\Booking\MasterRoomController;
use App\Http\Controllers\Chat\Master\SettingChatController;
use App\Http\Controllers\Chat\Transaction\ChatController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('/');

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

    // Booking Room
        // Master Room
            Route::get('master_room', [MasterRoomController::class, 'index'])->name('master_room');
            Route::get('getRoom', [MasterRoomController::class, 'getRoom'])->name('getRoom');
            Route::get('getLocation', [MasterRoomController::class, 'getLocation'])->name('getLocation');
            Route::post('addRoom', [MasterRoomController::class, 'addRoom'])->name('addRoom');
            Route::get('detailRoom', [MasterRoomController::class, 'detailRoom'])->name('detailRoom');
            Route::post('updateRoom', [MasterRoomController::class, 'updateRoom'])->name('updateRoom');
        // Master Room

        // Booking Room 
            Route::get('booking_room', [BookingController::class, 'index'])->name('booking_room');
            Route::get('getTicket', [BookingController::class, 'getTicket'])->name('getTicket');
            Route::get('detailTicket', [BookingController::class, 'detailTicket'])->name('detailTicket');
            Route::get('getActiveRoom', [BookingController::class, 'getActiveRoom'])->name('getActiveRoom');
            Route::post('createTicket', [BookingController::class, 'createTicket'])->name('createTicket');
            Route::post('updateApprovalTicket', [BookingController::class, 'updateApprovalTicket'])->name('updateApprovalTicket');
            
        // Booking Room
            
        // Approval
            Route::get('approval', [MasterApprovalController::class, 'index'])->name('approval');
            Route::get('getApproval', [MasterApprovalController::class, 'getApproval'])->name('getApproval');
            Route::post('addMasterApproval', [MasterApprovalController::class, 'addMasterApproval'])->name('addMasterApproval');
            Route::get('getStepApproval', [MasterApprovalController::class, 'getStepApproval'])->name('getStepApproval');
            Route::get('detailMasterApproval', [MasterApprovalController::class, 'detailMasterApproval'])->name('detailMasterApproval');
            Route::post('updateApproval', [MasterApprovalController::class, 'updateApproval'])->name('updateApproval');
            Route::post('editMasterApproval', [MasterApprovalController::class, 'editMasterApproval'])->name('editMasterApproval');
       
            Route::get('getApprover', [MasterApprovalController::class, 'getApprover'])->name('getApprover');

        // Approval
    // Booking Room

  

});
