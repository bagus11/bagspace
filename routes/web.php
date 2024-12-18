<?php

use App\Http\Controllers\Booking\BookingController;
use App\Http\Controllers\Booking\MasterApprovalController;
use App\Http\Controllers\Booking\MasterRoomController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\Setting\RolePermissionController;
use App\Http\Controllers\Setting\SettingAccountController;
use App\Http\Controllers\Setting\UserAccessController;
use App\Http\Controllers\Signature\SignatureController;
use App\Http\Controllers\Timeline\KanbanController;
use App\Http\Controllers\Timeline\MasterTeamTimelineController;
use App\Http\Controllers\Timeline\MasterTimelineCategory;
use App\Http\Controllers\Timeline\MasterTypeController;
use App\Http\Controllers\Timeline\MonitoringTimelineController;
use App\Http\Controllers\Signature\SignTransactionController;
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
        
            Route::group(['middleware' => ['permission:view-role_permission']], function () {
                Route::get('role_permission', [RolePermissionController::class, 'index'])->name('role_permission');
            });
          
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
            Route::group(['middleware' => ['permission:view-user_access']], function () {
                Route::get('user_access', [UserAccessController::class, 'index'])->name('user_access');
            });
           
            Route::get('getRoleUser', [UserAccessController::class, 'getRoleUser'])->name('getRoleUser');
            Route::get('getUser', [UserAccessController::class, 'getUser'])->name('getUser');
            Route::get('getUserDepartment', [UserAccessController::class, 'getUserDepartment'])->name('getUserDepartment');
            Route::get('getDepartment', [UserAccessController::class, 'getDepartment'])->name('getDepartment');
            Route::post('addRoleUser', [UserAccessController::class, 'addRoleUser'])->name('addRoleUser');
            Route::get('detailRoleUser', [UserAccessController::class, 'detailRoleUser'])->name('detailRoleUser');
            Route::post('updateRoleUser', [UserAccessController::class, 'updateRoleUser'])->name('updateRoleUser');
            Route::get('getRolePermissionDetail', [UserAccessController::class, 'getRolePermissionDetail'])->name('getRolePermissionDetail');
            Route::post('saveRolePermission', [UserAccessController::class, 'saveRolePermission'])->name('saveRolePermission');
            Route::get('destroyRolePermission', [UserAccessController::class, 'destroyRolePermission'])->name('destroyRolePermission');
        // User Access
    // Setting
            

    // Booking Room
        // Master Room
            Route::group(['middleware' => ['permission:view-master_room']], function () {
                Route::get('master_room', [MasterRoomController::class, 'index'])->name('master_room');
            });
          
            Route::get('getRoom', [MasterRoomController::class, 'getRoom'])->name('getRoom');
            Route::get('getLocation', [MasterRoomController::class, 'getLocation'])->name('getLocation');
            Route::post('addRoom', [MasterRoomController::class, 'addRoom'])->name('addRoom');
            Route::get('detailRoom', [MasterRoomController::class, 'detailRoom'])->name('detailRoom');
            Route::post('updateRoom', [MasterRoomController::class, 'updateRoom'])->name('updateRoom');
        // Master Room

        // Booking Room 
            Route::group(['middleware' => ['permission:view-booking_room']], function () {
                Route::get('booking_room', [BookingController::class, 'index'])->name('booking_room');
            });
          
            Route::get('getTicket', [BookingController::class, 'getTicket'])->name('getTicket');
            Route::get('detailTicket', [BookingController::class, 'detailTicket'])->name('detailTicket');
            Route::get('getActiveRoom', [BookingController::class, 'getActiveRoom'])->name('getActiveRoom');
            Route::post('createTicket', [BookingController::class, 'createTicket'])->name('createTicket');
            Route::post('updateApprovalTicket', [BookingController::class, 'updateApprovalTicket'])->name('updateApprovalTicket');
            
        // Booking Room
            
        // Approval
            Route::group(['middleware' => ['permission:view-approval']], function () {
                Route::get('approval', [MasterApprovalController::class, 'index'])->name('approval');
            });
           
            Route::get('getApproval', [MasterApprovalController::class, 'getApproval'])->name('getApproval');
            Route::post('addMasterApproval', [MasterApprovalController::class, 'addMasterApproval'])->name('addMasterApproval');
            Route::get('getStepApproval', [MasterApprovalController::class, 'getStepApproval'])->name('getStepApproval');
            Route::get('detailMasterApproval', [MasterApprovalController::class, 'detailMasterApproval'])->name('detailMasterApproval');
            Route::post('updateApproval', [MasterApprovalController::class, 'updateApproval'])->name('updateApproval');
            Route::post('editMasterApproval', [MasterApprovalController::class, 'editMasterApproval'])->name('editMasterApproval');
       
            Route::get('getApprover', [MasterApprovalController::class, 'getApprover'])->name('getApprover');
           
        // Approval


        // Meeting Online
            Route::get('meetingRoom/{meetingLink}',[BookingController::class, 'meetingRoom']); 
        // Meeting Online
        // Timeline Project
            // Master Team Timeline
                    Route::group(['middleware' => ['permission:view-master_team_timeline']], function () {
                        Route::get('master_team_timeline', [MasterTeamTimelineController::class, 'index'])->name('master_team_timeline');
                    });
              
                Route::get('getTeamTimeline', [MasterTeamTimelineController::class, 'getTeamTimeline'])->name('getTeamTimeline');
                Route::post('updateStatusMasterTeamTimeline', [MasterTeamTimelineController::class, 'updateStatusMasterTeamTimeline'])->name('updateStatusMasterTeamTimeline');
                Route::get('getDetailTeam', [MasterTeamTimelineController::class, 'getDetailTeam'])->name('getDetailTeam');
                Route::get('getMasterTeamDetail', [MasterTeamTimelineController::class, 'getMasterTeamDetail'])->name('getMasterTeamDetail');
                Route::get('getActiveTeam', [MasterTeamTimelineController::class, 'getActiveTeam'])->name('getActiveTeam');
                Route::post('addDetailTeam', [MasterTeamTimelineController::class, 'addDetailTeam'])->name('addDetailTeam');
                Route::post('updateDetailTeam', [MasterTeamTimelineController::class, 'updateDetailTeam'])->name('updateDetailTeam');
                Route::post('saveTeam', [MasterTeamTimelineController::class, 'saveTeam'])->name('saveTeam');
                Route::post('updateMasterTeam', [MasterTeamTimelineController::class, 'updateMasterTeam'])->name('updateMasterTeam');
            // Master Team Timeline 
            // Monitoring Timeline
                Route::group(['middleware' => ['permission:view-monitoring_timeline']], function () {
                    Route::get('monitoring_timeline', [MonitoringTimelineController::class, 'index'])->name('monitoring_timeline');
                });
              
                Route::get('getTimelineHeader', [MonitoringTimelineController::class, 'getTimelineHeader'])->name('getTimelineHeader');
                Route::get('getTimelineHeaderUser', [MonitoringTimelineController::class, 'getTimelineHeaderUser'])->name('getTimelineHeaderUser');
                Route::post('saveTimelineHeader', [MonitoringTimelineController::class, 'saveTimelineHeader'])->name('saveTimelineHeader');
                Route::get('detailTimeline', [MonitoringTimelineController::class, 'detailTimeline'])->name('detailTimeline');
                Route::post('updateLogTimelineHeaderDate', [MonitoringTimelineController::class, 'updateLogTimelineHeaderDate'])->name('updateLogTimelineHeaderDate');
                Route::post('summonBot', [MonitoringTimelineController::class, 'summonBot'])->name('summonBot');
                Route::get('getTimelineHeaderDetail', [MonitoringTimelineController::class, 'getTimelineHeaderDetail'])->name('getTimelineHeaderDetail');
                // Kanban
                
                    Route::get('project/{id}',[KanbanController::class, 'index']);
                    Route::get('getTimelineDetail', [KanbanController::class, 'getTimelineDetail'])->name('getTimelineDetail');
                    Route::get('getSubDetailKanban', [KanbanController::class, 'getSubDetailKanban'])->name('getSubDetailKanban');
                    Route::post('sendChat', [KanbanController::class, 'sendChat'])->name('sendChat');
                    Route::get('getGanttChart', [KanbanController::class, 'getGanttChart'])->name('getGanttChart');
                    Route::get('getChat', [KanbanController::class, 'getChat'])->name('getChat');
                    Route::post('createModule', [KanbanController::class, 'createModule'])->name('createModule');
                    Route::post('addTask', [KanbanController::class, 'addTask'])->name('addTask');
                    Route::post('updateTask', [KanbanController::class, 'updateTask'])->name('updateTask');
                    Route::get('getTeam', [KanbanController::class, 'getTeam'])->name('getTeam');
                    Route::get('postBot', [KanbanController::class, 'postBot'])->name('postBot');
                    Route::get('getSubDetailTimeline', [KanbanController::class, 'getSubDetailTimeline'])->name('getSubDetailTimeline');
                    Route::get('getLogTask', [KanbanController::class, 'getLogTask'])->name('getLogTask');
                    Route::post('updateStatusTask', [KanbanController::class, 'updateStatusTask'])->name('updateStatusTask');
                    Route::post('updateTimelineDetailStatus', [KanbanController::class, 'updateTimelineDetailStatus'])->name('updateTimelineDetailStatus');
                    Route::post('updateModule', [KanbanController::class, 'updateModule'])->name('updateModule');
                    Route::post('updateDaily', [KanbanController::class, 'updateDaily'])->name('updateDaily');
                    Route::post('addDaily', [KanbanController::class, 'addDaily'])->name('addDaily');
                    Route::get('print_daily/{id}', [KanbanController::class, 'print_daily']);
                    Route::get('detailActivity', [KanbanController::class, 'detailActivity'])->name('detailActivity');
                // Kanban
            // Monitoring Timeline
            // Master Type
                Route::group(['middleware' => ['permission:view-master_type_timeline']], function () {
                    Route::get('master_type_timeline', [MasterTypeController::class, 'index'])->name('master_type_timeline');
                });
              
                Route::get('getTimelineType', [MasterTypeController::class, 'getTimelineType'])->name('getTimelineType');
                Route::get('getActiveTimelineType', [MasterTypeController::class, 'getActiveTimelineType'])->name('getActiveTimelineType');
                Route::post('saveTimelineType', [MasterTypeController::class, 'saveTimelineType'])->name('saveTimelineType');
                Route::post('updateTimelineType', [MasterTypeController::class, 'updateTimelineType'])->name('updateTimelineType');
                Route::post('updateStatusType', [MasterTypeController::class, 'updateStatusType'])->name('updateStatusType');
            // Master Type
            // Master Category
                Route::group(['middleware' => ['permission:view-master_category_timeline']], function () {
                    Route::get('master_category_timeline', [MasterTimelineCategory::class, 'index'])->name('master_category_timeline');
                });
               
                Route::get('getTimelineCategory', [MasterTimelineCategory::class, 'getTimelineCategory'])->name('getTimelineCategory');
                Route::post('saveTimelineCategory', [MasterTimelineCategory::class, 'saveTimelineCategory'])->name('saveTimelineCategory');
                Route::post('updateStatusCategory', [MasterTimelineCategory::class, 'updateStatusCategory'])->name('updateStatusCategory');
                Route::post('updateTimelineCategory', [MasterTimelineCategory::class, 'updateTimelineCategory'])->name('updateTimelineCategory');
            // Master Category

            // Signature
                Route::get('getValidationSignExist', [SignatureController::class, 'getValidationSignExist'])->name('getValidationSignExist');
                Route::post('saveSignature', [SignatureController::class, 'saveSignature'])->name('saveSignature');
            // Signature
        // Timeline Project

        
        // Booking Room
        // Library
                Route::get('library', [LibraryController::class, 'index'])->name('library');
                Route::get('getLibrary', [LibraryController::class, 'getLibrary'])->name('getLibrary');
                Route::post('addLibrary', [LibraryController::class, 'addLibrary'])->name('addLibrary');
                Route::get('detailLibrary', [LibraryController::class, 'detailLibrary'])->name('detailLibrary');
                Route::post('updateLibrary', [LibraryController::class, 'updateLibrary'])->name('updateLibrary');
        // Library

        // Setting
                Route::get('setting_account', [SettingAccountController::class, 'index'])->name('setting_account');
                Route::get('getCalculation', [SettingAccountController::class, 'getCalculation'])->name('getCalculation');
                Route::post('update_password', [SettingAccountController::class, 'update_password'])->name('update_password');
                Route::post('changeImage', [SettingAccountController::class, 'changeImage'])->name('changeImage');
        // Setting
        // signature transaction
        Route::get('sign', [SignTransactionController::class,'index'])->name('sign');
        Route::get('fetch-sign', [SignTransactionController::class,'fetch'])->name('fetch-sign');
        Route::get('list-user-approval', [SignTransactionController::class,'fetchUserApproval'])->name('list-user-approval');
        Route::get('detail-sign', [SignTransactionController::class,'detailSign'])->name('detail-sign');
        Route::post('create-sign', [SignTransactionController::class,'createSignTransaction'])->name('create-sign');
        Route::get('getApprovalSign', [SignTransactionController::class,'getApprovalSign'])->name('getApprovalSign');
        Route::post('updateApprovalSign', [SignTransactionController::class,'updateApprovalSign'])->name('updateApprovalSign');
        Route::post('sendSign', [SignTransactionController::class,'sendSign'])->name('sendSign');
        Route::get('getUserSign', [SignTransactionController::class, 'getUserSign'])->name('getUserSign');
        Route::get('sign-document', [SignTransactionController::class,'signDocument'])->name('sign-document');
        Route::get('view-pdf/{filename}', [SignTransactionController::class,'viewPdf']);
        // signature transaction
        
    });
    Route::get('validationSign/{link}', [SignTransactionController::class, 'validationSign'])->name('validationSign');
    Route::get('getValidationSign', [SignTransactionController::class, 'getValidationSign'])->name('getValidationSign');
    Route::post('postValidationSign', [SignTransactionController::class, 'postValidationSign'])->name('postValidationSign');
