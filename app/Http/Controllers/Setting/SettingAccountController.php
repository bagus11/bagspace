<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\Timeline\TimelineSubDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    function changeImage(Request $request ) {
        
        try {
            $fileName = '';
        if ($request->hasFile('profile_image')) {
            $user = User::where('id',auth()->user()->id)->first();
            $currentAvatar = $user->avatar;
        
            // Check if current avatar is not the default one
            if ($currentAvatar != 'avatar.png') {
                // Delete the existing avatar image
                Storage::disk('public')->delete('users-avatar/' . $currentAvatar);
            }
        
            $file = $request->file('profile_image');
            $fileName = Str::slug(date('YmdHis')) . '.png';
            $path = $file->storeAs('users-avatar', $fileName, 'public');
        
            User::where('id',auth()->user()->id)->update([
                'avatar' => $fileName
            ]);
        
            return ResponseFormatter::success(
                $path,
                'Profile successfully updated'
            );
        }
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th->getMessage(),
                'Profile failed to update',
                500
            );
        }
    }
}
