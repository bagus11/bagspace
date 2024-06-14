<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Timeline\TimelineSubDetail;
use Illuminate\Http\Request;

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
}
