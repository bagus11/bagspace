<?php

namespace App\Http\Controllers\Chat\Master;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addGroupChatRequest;
use App\Models\Chat\ChatDetailGroupModel;
use App\Models\Chat\ChatGroupModel;
use App\Models\User;
use Illuminate\Http\Request;
use NumConvert;

class SettingChatController extends Controller
{
    function index() {
        return view('chat.setting.chat_group.chat_group-index');
    }
    function getGroup() {
        $data = ChatGroupModel::all();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function addGroup(Request $request, addGroupChatRequest $addGroupChatRequest) {
        // try{
                $addGroupChatRequest->validated();
                $transaction_code ='';
                $increment_code = ChatGroupModel::orderBy('id','desc')->first();
                $date_month =strtotime(date('Y-m-d'));
                $month =idate('m', $date_month);
                $year = idate('y', $date_month);
                $month_convert =  NumConvert::roman($month);
                if($increment_code ==null){
                    $transaction_code = '1/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }else{
                    $month_before = explode('/',$increment_code->group_code,-1);
                    if($month_convert != $month_before[2]){
                        $transaction_code = '1/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                    }else{
                        $transaction_code = $month_before[0] + 1 .'/'.str_pad($request->location_id, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                    }   
                }
                $post =[
                    'group_code'        => $transaction_code,
                    'group_name'        => $request->name,
                    'description'       => $request->description,
                    'user_id'           => auth()->user()->id
                ];
                ChatGroupModel::create($post);
                
                return ResponseFormatter::success(   
                    $post,                              
                    'Group chat successfully added'
                );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Transaction failed to update',
        //         500
        //     );
        // }
    }
    function getDetailGroup(Request $request){
        $active = ChatDetailGroupModel::with([
            'userRelation'
        ])->where('group_code',$request->group_code)->get();
        $user = [];
        foreach($active as $row){
            array_push($user,$row->user_id);
        }
        $inactive = User::whereNotIn('id',$user)->get();
        return response()->json([
            'inactive'=>$inactive,
            'active'=>$active,
        ]); 

    }
    function updateDetailGroup(Request $request) {
        $status         = 500;
        $message        = 'PIC failed to udpate';
        $postArray      =[];
        $group_code    = ChatDetailGroupModel::where('group_code',$request->group_code)->first();
        if($request->type == 2){
            foreach($request->picId as $row){
                $post =[
                    'group_code'   =>$request->group_code,
                    'user_id'        =>$row ,
                    'created_at'    =>date('Y-m-d H:i:s')
                ];
                array_push($postArray, $post);
            }
            $insert = ChatDetailGroupModel::insert($postArray);
            if($insert){
                $status =200;
                $message ='PIC successfully updated';
            }
        }else{
            $delete = ChatDetailGroupModel::whereIn('user_id',$request->picId)->delete();
            if($delete){
                $status =200;
                $message ='PIC successfully updated';  
            }
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]);  
    }
    function detailGroup(Request $request) {
        $detail = ChatGroupModel::where('group_code',$request->group_code)->first();
        return response()->json([
            'detail'=>$detail,
        ]);   
    }

}
