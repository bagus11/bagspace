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
use Telegram\Bot\Laravel\Facades\Telegram;

class KanbanController extends Controller
{
    function index($id){
        $request_code   = str_replace('_','/',$id);
        $timelineName = TimelineHeader::with(['teamRelation.userRelation'])->where('request_code', $request_code)->first();
        $team = DetailTeamTimeline::with('userRelation')->where('team_id', $timelineName->team_id)->get();
        $data =[
            'data'              =>$timelineName,
            'request_code'      =>$request_code,
            'team'      =>$team
        ];
        return view('timeline.kanban.kanban-index',$data);
    }
    function getTImelineDetail(Request $request) {
        $data   = TimelineDetail ::with(['userRelation'])->where('request_code',$request->request_code)->get();
        $detail = TimelineHeader ::where('request_code', $request->request_code)->first();
        $array = [];
      
    
        if($detail->type_id == 1){
            $post = [
                'data'=>$data,
                'detail'=>$detail,
                
            ];
        }else{
            foreach ($data as $row) {
                $done       = TimelineSubDetail::select(DB::raw('sum(amount) as sum'))
                                                ->where('detail_code', $row->detail_code)
                                                ->where('status', 1)
                                                ->first();
                // dd($row->detail_code);
                 
                if ($row->done != 0) {
                    // $percentage = ($done->sum / $row->plan) * 100;
                    $percentage = $done->sum ;
                } else {
                    $percentage = 0; // or any other logic to handle zero division
                }
            
                $sum = [
                    'actual'    => $done->sum == null ?0 : $done->sum,
                    'plan'      => $row->plan
                ];
                array_push($array, $sum);
            }
            $post = [
                'data'=>$data,
                'detail'=>$detail,
                'array'=>$array,  
            ];
        }
        return response()->json($post); 
    }
    function getSubDetailTimeline(Request $request) {
        $detail = TimelineSubDetail ::with(['userRelation'])->where('id',$request->id)->first();
        return response()->json([
            'detail'=>$detail
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
            $attachmentPath = '';

            // Check if a file is uploaded
            if ($request->hasFile('file_attach')) {
                $file = $request->file('file_attach');
                $timestamp = now()->format('Ymd_His'); // Get current date and time
                $fileName = $timestamp . '_' . $file->getClientOriginalName(); // Format file name
                $attachmentPath = $file->storeAs('AttachmentTask', $fileName, 'public'); // Save file to storage/AttachmentTask
            }
            $post =[
                'request_code'          => $request->request_code_chat,
                'attachment'            => $attachmentPath == ''?$attachmentPath : 'storage/'.$attachmentPath,
                'detail_code'           => $request->detail_code,
                'remark'                => $request->remark_chat,
                'user_id'               => auth()->user()->id,
                'created_at'            => date('Y-m-d H:i:s')
            ];
       
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
        // try {    
            $increment_code= TimelineDetail::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/DTML/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->detail_code,-1);
               
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/DTML/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/DTML/'.$month_convert.'/'.$year;
                }   
            }
            $header = TimelineHeader::where('request_code', $request->request_code)->first();
            $post =[
                'detail_code'           => $ticket_code,
                'request_code'          => $request->request_code,
                'name'                  => $request->name_module,
                'description'           => $request->description_module,
                'start_date'            => $request->start_date_module,
                'end_date'              => $request->end_date_module,
                'status'                => $request->status_module,
                'is_payment'            =>0,
                'is_taxt'               =>0,
                'is_negotiate'          =>0,
                'is_discount'           =>0,
                'percentage'            =>0,
                'payment_status'        =>0,
                'plan'                  => $header->type_id ==1 ?0: $request->plan_amount
            ];
            // dd($post);
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
            //  ChatTimelineModel::insert($post_chat);
             
            return ResponseFormatter::success(   
                $post,                              
                'Chat successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Chat failed to add',
        //         500
        //     );
        // }  
    }
    function addTask(Request $request, StoreTaskRequest $storeTaskRequest) {
        // try {    
            $storeTaskRequest->validated();
            $increment_code= TimelineSubDetail::orderBy('id','desc')->first();
           
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/SDTML/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->subdetail_code,-1);
                // dd($month_convert .' == '. $month_before[2]);
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/SDTML/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/SDTML/'.$month_convert.'/'.$year;
                }   
            }
            $header = TimelineHeader::where('request_code',  $request->request_code)->first();
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
                'amount'                => $header->type_id ==1 ? 0 : $request->actual_amount,
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
            //  ChatTimelineModel::insert($post_chat);
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
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Task failed to add',
        //         500
        //     );
        // }  
    }
    function updateStatusTask(Request $request) {
        $status         = 500;
        $message        = 'Failed Update Progress, please contact ICT Dev';
        $task           = TimelineSubDetail::where('id', $request->id)->first();
        $post_update    = [
            'status'    => $task->status ==1 ?0 : 1,
            'update_done'  =>$task->status ==1 ?null : date('Y-m-d H:i:s'),
            
        ];
       
        $activate = $request->status == 1 ?'Cancel' :'DONE';
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
                // Sending Message on BOT
                $bot =[
                    'task'          => $task->name,
                    'activate'      => $activate,
                    'request_code'   => $task->request_code,
                    'user'          => auth()->user()->name,
                    'project_name'  => $request->name
                ];
             
                // Sending Message on BOT
                $status = 200;
                $message ='Successfully Update Progress';
            }
        }else{
               $status = 500;
                $message ="Hayoooo, mau ngapain :)";
        }
        return response()->json([
            'status'        =>$status,
            'message'       =>$message,
            'bot'           =>$bot
        ]); 
        
    }
    function updateTimelineDetailStatus(Request $request) {
        $status         = 500;
        $message        = 'Failed Update Progress, please contact ICT Dev';
        $task           = TimelineDetail::where('detail_code', $request->detail_code)->first();
        $header = TimelineHeader::where('request_code', $task->request_code)->first();
        $detail = TimelineDetail::where('detail_code',$task->detail_code)->first();
        // dd($task);
        $post =[
            'status' => $request->status
        ];
        $status ='';
        switch ($request->status) {
            case 0:
                $status ="NEW";
            break;
            case 1:
                $status ="In Progress";
            break;
            case 2:
                $status ="Pending";
            break;
            case 3:
                $status ="DONE";
            break;
            default:
            $status = '';
            
        }
        // dd($request->status);
        if($request->status == 2){
            $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
            . "PIC          : " . auth()->user()->name . "\n"
            . "Module       :  <b>$detail->name</b>  \n"
            . "Status       :   Pending";
            Telegram::sendMessage([
                'chat_id' => $header->id_channel,
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        }
        if($detail->status == 2){
            
            $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
            . "PIC          : " . auth()->user()->name . "\n"
            . "Module       :  <b>$detail->name</b>  \n"
            . "Status       :  $status ";
            Telegram::sendMessage([
                'chat_id' => $header->id_channel,
                'parse_mode' => 'HTML',
                'text' => $text
            ]);
        }
        $update         = TimelineDetail::where('detail_code', $request->detail_code)->update($post);
        if($update){
            $status         = 200;
            $message        = 'Successfully Update Status ';
        }
      
        return response()->json([
            'status'=>$status,
            'message'=>$message,
        ]); 
        
    }
    function postBot(Request $request) { 
        // dd($request);
        $header = TimelineHeader::where('request_code', $request->request_code)->first();
        // dd($header);
        $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
        . "PIC          : " . $request->user . "\n"
        . "Task         :  <b>$request->task</b>  \n"
        . "Status       :   $request->activate \n";
        $send = Telegram::sendMessage([
            'chat_id' => $header->id_channel,
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        if($send){
            $status = 200;
            $message ='Bot successfully sending message';
        }

        return response()->json([
            'status'        =>$status,
            'message'       =>$message,
        ]); 
    }

}
