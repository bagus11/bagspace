<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingAccountController extends Controller
{
    function index() {
        return view('setting.account.setting_account-index');
    }
}
