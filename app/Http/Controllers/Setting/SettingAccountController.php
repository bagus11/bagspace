<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Timeline\TimelineSubDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingAccountController extends Controller
{
    function index() {
        return view('setting.account.setting_account-index');
    }
    function  getCalculation() {
        $progress = TimelineSubDetail::where('pic', auth()->user()->id)
                                    ->where('status', 0)
                                    ->count();
        $all = TimelineSubDetail::where('pic', auth()->user()->id)
                                    ->count();
        $project =TimelineSubDetail::where('pic', auth()->user()->id)
                                    ->groupBy('request_code')
                                    ->get();

        return response()->json([
            'progress'=>$progress,
            'all'=>$all,
            'project'=>$project,
        ]);
    }
    function update_password(Request $request,ChangePasswordRequest $changePasswordRequest ) {
        try {
            $changePasswordRequest->validated();
            $post=[
                'password'=> Hash::make($request->new_password),
            ];
            User::find(auth()->user()->id)->update($post);
            return ResponseFormatter::success(
                $post,
                'Roles successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Roles failed to add',
                500
            );
        }
    }
}
