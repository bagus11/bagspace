<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Timeline\ChatTimelineModel;
use App\Models\Timeline\DetailTeamTimeline;
use App\Models\Timeline\TimelineDetail;
use App\Models\Timeline\TimelineHeader;
use App\Models\Timeline\TimelineSubDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumConvert;
class KanbanController extends Controller
{
    function index($id){
        $data =[
            'request_code' =>str_replace('_','/',$id)
        ];
        return view('timeline.kanban.kanban-index',$data);
    }
    function getTImelineDetail(Request $request) {
        $data = TimelineDetail ::with(['userRelation'])->where('request_code',$request->request_code)->get();
        return response()->json([
            'data'=>$data
        ]); 
    }
    function getTeam(Request $request) {
        $detail = TimelineHeader ::where('request_code',$request->request_code)->first();
        // dd($detail);
        $data   = DetailTeamTimeline::with('userRelation')->where('team_id', $detail->team_id)->get();
        return response()->json([
            'data'=>$data
        ]); 
    }
    function getSubDetailKanban(Request $request) {
        $data       = TimelineSubDetail::with(['userRelation'])->where('detail_code', $request->detail_code)->orderBy('start_date','asc')->get();
        $detail     = TimelineDetail::with(['userRelation']) ->where('detail_code', $request->detail_code)->first();
        $chat       = ChatTimelineModel::with(['userRelation'])->where('detail_code',$request->detail_code)->get();
        return response()->json([
            'data'=>$data,
            'chat'=>$chat,
            'detail'=>$detail,
        ]); 
    }
    function getChat(Request $request) {
        $chat       = ChatTimelineModel::with(['userRelation'])->where('detail_code',$request->detail_code)->get();
        return response()->json([
            'chat'=>$chat,
        ]); 
    }
    function sendChat(Request $request) {
        try {    
            
            $post =[
                'request_code'          => $request->request_code_chat,
                'attachment'            => '',
                'detail_code'           => $request->detail_code,
                'remark'                => $request->remark_chat,
                'user_id'               => auth()->user()->id,
                'created_at'            => date('Y-m-d H:i:s')
            ];
            // dd($request);
             ChatTimelineModel::insert($post);
            return ResponseFormatter::success(   
                $post,                              
                'Chat successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Chat failed to add',
                500
            );
        }
    }
    function createModule(Request $request) {
        try {    
            $increment_code= TimelineDetail::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/DTML/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
               
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/DTML/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/DTML/'.$month_convert.'/'.$year;
                }   
            }
            $post =[
                'detail_code'           => $ticket_code,
                'request_code'          => $request->request_code,
                'name'                  => $request->name_module,
                'description'           => $request->description_module,
                'start_date'            => $request->start_date_module,
                'end_date'              => $request->end_date_module,
                'status'                =>$request->status_module,
                'is_payment'            =>0,
                'is_taxt'               =>0,
                'is_negotiate'          =>0,
                'is_discount'           =>0,
                'percentage'            =>0,
                'payment_status'        =>0
            ];

            $post_chat=[
                'request_code'          => $request->request_code,
                'attachment'            => '',
                'detail_code'           => $ticket_code,
                'remark'                => ' has created this module',
                'user_id'               => auth()->user()->id,
                'created_at'            => date('Y-m-d H:i:s')
            ];
            // dd($post);
             TimelineDetail::insert($post);
             ChatTimelineModel::insert($post_chat);
            return ResponseFormatter::success(   
                $post,                              
                'Chat successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Chat failed to add',
                500
            );
        }  
    }
    function addTask(Request $request, StoreTaskRequest $storeTaskRequest) {
        try {    
            $storeTaskRequest->validated();
            $increment_code= TimelineSubDetail::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/SDTML/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
               
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/SDTML/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/SDTML/'.$month_convert.'/'.$year;
                }   
            }
            $post =[
                'request_code'          => $request->request_code,
                'detail_code'           => $request->detail_code,
                'subdetail_code'        => $ticket_code,
                'name'                  => $request->name_sub_module,
                'description'           => $request->description_sub_module,
                'start_date'            => $request->start_date_sub_module,
                'end_date'              => $request->end_date_sub_module,
                'pic'                   => $request->pic_id,
                'status'                =>0,
                'amount'                =>0,
            ];
            $post_chat=[
                'request_code'          => $request->request_code,
                'attachment'            => '',
                'detail_code'           =>  $request->detail_code,
                'remark'                => ' has created a new task : <b>'.$request->name_sub_module.'</b>',
                'user_id'               => auth()->user()->id,
                'created_at'            => date('Y-m-d H:i:s')
            ];
            
             TimelineSubDetail::insert($post);
             ChatTimelineModel::insert($post_chat);
             $statusDone     =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$request->detail_code)->where('status',1)->first();
             $statusAll      =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$request->detail_code)->first();
             $percentage     =   ($statusDone->percentage / $statusAll->percentage) * 100;
             $statusRFPDone  =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$request->request_code)->where('status',1)->first();
             $statusRFPAll   =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$request->request_code)->first();
             $percentageRFP  =   ($statusRFPDone->percentage / $statusRFPAll->percentage) * 100 ; 
             if($percentage == 100 ){
                 if($percentageRFP == 100){
                    TimelineHeader::where('request_code',$request->request_code)->update([
                     'percentage'=>$percentageRFP,
                     'status'=>1
                    ]);
                 }
                 TimelineDetail::where([
                     'request_code' =>$request->request_code,
                     'detail_code' =>$request->detail_code,
                 ])->update([
                     'percentage'    =>$percentage,
                     'status'        => 1
                 ]);
             }else{
                 TimelineDetail::where([
                     'request_code' =>$request->request_code,
                     'detail_code' =>$request->detail_code,
                 ])->update([
                     'percentage'    =>$percentage
                 ]);
                 TimelineHeader::where('request_code',$request->request_code)->update([
                     'percentage'=>$percentageRFP,
                     'status'=>1
                 ]);
             }
            return ResponseFormatter::success(   
                $post,                              
                'Task successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Task failed to add',
                500
            );
        }  
    }
    function updateStatusTask(Request $request) {
        $status         = 500;
        $message        = 'Failed Update Progress, please contact ICT Dev';
        $task           = TimelineSubDetail::where('id', $request->id)->first();
        $post_update    = [
            'status'    => $task->status ==1 ?0 : 1,
            'end_date'  =>date('Y-m-d') > $task->status ? date('Y-m-d') :'',
        ];
       
        $activate = $request->status == 1 ?'inactive' :'active';
        $post_chat=[
            'request_code'          => $task->request_code,
            'attachment'            => '',
            'detail_code'           =>  $task->detail_code,
            'remark'                => ' has update status task : <b>'.$task->name.'</b>',
            'user_id'               => auth()->user()->id,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        if(auth()->user()->id == $task->pic){
            ChatTimelineModel::create($post_chat);
            $update = TimelineSubDetail::where([
                'request_code' =>$task->request_code,
                'detail_code' =>$task->detail_code,
                'id'            =>$request->id
            ])->update($post_update);
            if($update){
                $statusDone     =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$task->detail_code)->where('status',1)->first();
                $statusAll      =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('detail_code',$task->detail_code)->first();
                $percentage     =   ($statusDone->percentage / $statusAll->percentage) * 100;
                $statusRFPDone  =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$task->request_code)->where('status',1)->first();
                $statusRFPAll   =   TimelineSubDetail::select(DB::raw('count(id) as percentage'))->where('request_code',$task->request_code)->first();
                $percentageRFP  =   ($statusRFPDone->percentage / $statusRFPAll->percentage) * 100 ; 
                if($percentage == 100 ){
                    if($percentageRFP == 100){
                       TimelineHeader::where('request_code',$task->request_code)->update([
                        'percentage'=>$percentageRFP,
                        'status'=>1
                       ]);
                    }
                    TimelineDetail::where([
                        'request_code' =>$task->request_code,
                        'detail_code' =>$task->detail_code,
                    ])->update([
                        'percentage'    =>$percentage,
                        'status'        => 1
                    ]);
                }else{
                    TimelineDetail::where([
                        'request_code' =>$task->request_code,
                        'detail_code' =>$task->detail_code,
                    ])->update([
                        'percentage'    =>$percentage
                    ]);
                    TimelineHeader::where('request_code',$task->request_code)->update([
                        'percentage'=>$percentageRFP,
                        'status'=>1
                    ]);
                }
               
                $status = 200;
                $message ='Successfully Update Progress';
            }
        }else{
               $status = 500;
                $message ="You're not trully PIC :)";
        }
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]); 
        
    }

}