<?php

namespace App\Http\Controllers\Signature;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Sign\MasterSignature;
use App\Models\User;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    function getValidationSign() {
        $count = MasterSignature::where('user_id', auth()->user()->id)->count();
        return response()->json([
            'count'        =>$count,
        ]); 
    }
    function saveSignature(Request $request) {
        try {    
            $postSign =[
                'signature'        => $request->signature,
                'created_at'        => date('Y-m-d H:i:s'),
                'type'              => 1,
                'user_id'           => auth()->user()->id
            ];
            $postParaf =[
                'signature'        => $request->paraf,
                'created_at'        => date('Y-m-d H:i:s'),
                'type'              => 2,
                'user_id'           => auth()->user()->id
            ];
            MasterSignature::create($postSign);
            MasterSignature::create($postParaf);
            User::where('id', auth()->user()->id)->update(['pincode'    => $request->pincode]);
            return ResponseFormatter::success(   
                $postSign,                              
                'Status successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Status failed to update',
                500
            );
        }
    }
}
