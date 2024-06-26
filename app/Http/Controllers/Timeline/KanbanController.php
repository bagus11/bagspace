<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Timeline\ChatTimelineModel;
use App\Models\Timeline\DetailTeamTimeline;
use App\Models\Timeline\TimelineDetail;
use App\Models\Timeline\TimelineDetailLog;
use App\Models\Timeline\TimelineHeader;
use App\Models\Timeline\TimelineSubDetail;
use App\Models\Timeline\TimelineSubDetailLog;
use App\Models\User;
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
        $leader   = DetailTeamTimeline::where('team_id',$timelineName->team_id)->where('position',2)->first();
        $data =[
            'data'              =>$timelineName,
            'request_code'      =>$request_code,
            'team'              =>$team,
            'leader'            =>$leader
        ];
        return view('timeline.kanban.kanban-index',$data);
    }
    function getTImelineDetail(Request $request) {
        $data   = TimelineDetail ::with(['userRelation','subDetailRelation','subDetailRelation.userRelation','subDetailRelation.logRelation','subDetailRelation.logRelation.userRelation'])->where('request_code',$request->request_code)->get();
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
                    'plan'      => $row->plan,
                    'detail_code'=>$row->detail_code
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
        $detail     = TimelineSubDetail ::with(['userRelation'])->where('id',$request->id)->first();
        $log_task   = TimelineSubDetailLog::with([
                                                'userRelation',
                                                'creatorRelation',
                                            ])->where('subdetail_code', $detail->subdetail_code)
                                            ->get();
        return response()->json([
            'detail'=>$detail,
            'log_task'=>$log_task,
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
        $log        = TimelineDetailLog::with(['userRelation'])->where('detail_code',$request->detail_code)->get();
        return response()->json([
            'data'=>$data,
            'chat'=>$chat,
            'detail'=>$detail,
            'log'=>$log,
        ]); 
    }
    function getChat(Request $request) {
        $chat       = ChatTimelineModel::with(['userRelation'])->where('detail_code',$request->detail_code)->get();
        return response()->json([
            'chat'=>$chat,
        ]); 
    }
    function getGanttChart(Request $request) {
            $data = TimelineHeader::with(['detailRelation','detailRelation.subDetailRelation'])->where('request_code',$request->request_code)->get();
            return response()->json($data);
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
    function updateDaily(Request $request) {
        try {    
            $attachmentPath = '';
            $header = TimelineSubDetail::where('subdetail_code', $request->subdetail_code)->first();
            // Check if a file is uploaded
            if ($request->hasFile('daily_attachment')) {
                $file = $request->file('daily_attachment');
                $timestamp = now()->format('Ymd_His'); // Get current date and time
                $fileName = $timestamp . '_' . $file->getClientOriginalName(); // Format file name
                $attachmentPath = $file->storeAs('AttachmentTask', $fileName, 'public'); // Save file to storage/AttachmentTask
            }
            $post =[
                'subdetail_code'          => $request->subdetail_code,
                'attachment'            => $attachmentPath == ''?$attachmentPath : 'storage/'.$attachmentPath,
                'name'                  => $header->name,
                'start_date'            => $header->start_date,
                'end_date'              => $header->end_date,
                'amount'                => $header->amount,
                'pic'                   => $header->pic,
                'user_id'               => auth()->user()->id,
                'remark'                => $request->daily_description,
                'user_id'               => auth()->user()->id,
                'created_at'            => date('Y-m-d H:i:s')
            ];
            TimelineSubDetailLog::create($post);
           
            return ResponseFormatter::success(   
                $post,                              
                'Activity successfully update progress, thanks :)'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Activity failed to add',
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
            $postLog = [
                'request_code'  => $request->request_code,
                'detail_code'   => $ticket_code,
                'start_date'    => $request->start_date_module,
                'end_date'      => $request->end_date_module,
                'name'          => $request->name_module,
                'plan'          => $header->type_id ==1 ?0: $request->plan_amount,
                'description'   => $request->description_module,
                'user_id'       => auth()->user()->id,
                'remark'        =>'Has create this module',
            ];
            // dd($post);
             TimelineDetail::insert($post);
             TimelineDetailLog::create($postLog);
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
            $attachmentPath = '';

            // Check if a file is uploaded
            if ($request->hasFile('attachment_task')) {
                $file = $request->file('attachment_task');
                $timestamp = now()->format('Ymd_His'); // Get current date and time
                $fileName = $timestamp . '_' . $file->getClientOriginalName(); // Format file name
                $attachmentPath = $file->storeAs('GalleryTask', $fileName, 'public'); // Save file to storage/AttachmentTask
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
                'status'                => 0,
                'amount'                => $header->type_id ==1 ? 0 : $request->actual_amount,
                'attachment'            => $attachmentPath == ''?$attachmentPath : 'storage/'.$attachmentPath,
            ];
            $post_bot =[
                'subdetail_code'        => $ticket_code,
                'name'                  => $request->name_sub_module,
                'description'           => $request->description_sub_module,
                'start_date'            => $request->start_date_sub_module,
                'end_date'              => $request->end_date_sub_module,
                'amount'                => $header->type_id ==1 ? 0 : $request->actual_amount,
                'pic'                   => $request->pic_id, 
                'created_at'            => date('Y-m-d H:i:s'),
                'user_id'               => auth()->user()->id,
                'remark'                => 'has created task : <b>'.$request->name_sub_module.'</b>',
            ];
             TimelineSubDetail::insert($post);
             TimelineSubDetailLog::create($post_bot);
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
                     'status'        => 3
                 ]);
             }else{
                 TimelineDetail::where([
                     'request_code' =>$request->request_code,
                     'detail_code' =>$request->detail_code,
                 ])->update([
                     'percentage'    =>$percentage,
                     'status'        => 1
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
        $headerTimeline = TimelineHeader::where('request_code', $task->request_code)->first();
        $leader         = DetailTeamTimeline::where('team_id',$headerTimeline->team_id)->where('position', 2)->first();
        $post_update    = [
            'status'    => $task->status ==1 ?0 : 1,
            'update_done'  =>$task->status ==1 ?null : date('Y-m-d H:i:s'),
            
        ];
        $statusMessage =  $task->status ==0 ? "Has finished task " : "Has unchecked task ";
        $activate = $request->status == 1 ?'Cancel' :'DONE';
        $post_chat=[
            'request_code'          => $task->request_code,
            'attachment'            => '',
            'detail_code'           =>  $task->detail_code,
            'remark'                => $statusMessage.' : <b>'.$task->name.'</b>',
            'user_id'               => auth()->user()->id,
            'created_at'            => date('Y-m-d H:i:s')
        ];
        $post_bot =[
            'subdetail_code'        => $task->subdetail_code,
            'name'                  => $task->name,
            'description'           => $task->description,
            'start_date'            => $task->start_date,
            'end_date'              => $task->end_date,
            'amount'                => $task->amount,
            'pic'                   => $task->pic,  
            'created_at'            => date('Y-m-d H:i:s'),
            'user_id'               => auth()->user()->id,
            'remark'                => $statusMessage.' : <b>'.$task->name.'</b>',
        ];
        $bot=[];
        if((auth()->user()->id == $task->pic) || (auth()->user()->id == $leader->user_id)){
            // ChatTimelineModel::create($post_chat);
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
                        'status'        => 3
                    ]);
                }else{
                    TimelineDetail::where([
                        'request_code' =>$task->request_code,
                        'detail_code' =>$task->detail_code,
                        
                        
                    ])->update([
                        'percentage'    =>$percentage,
                        'status'        => 1
                    ]);
                    TimelineHeader::where('request_code',$task->request_code)->update([
                        'percentage'=>$percentageRFP,
                        'status'=>1
                    ]);
                }
                TimelineSubDetailLog::create($post_bot);
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
        $header         = TimelineHeader::where('request_code', $task->request_code)->first();
        $detail         = TimelineDetail::where('detail_code',$task->detail_code)->first();
        if($detail->percentage == 100){
            $status         = 500;
            $message        = 'Cannot update because, module is totally done ';
        }else if($request->status == 3 && $detail->percentage < 100){
            $status         = 500;
            $message        = 'Cannot update to DONE, because module is not 100%';
        }else{
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
    function updateTask(Request $request) {
        $id     = TimelineSubDetail::with('userRelation')->find($request->id);
        $header = TimelineHeader::where('request_code', $id->request_code)->first();
      
        $post =[
            'name'                  => $request->name_edit_sub_module,
            'description'           => $request->description_edit_sub_module,
            'start_date'            => $request->start_date_edit_sub_module,
            'end_date'              => $request->end_date_edit_sub_module,
            'amount'                => $id->amount ==0 ? 0 : $request->actual_amount_edit,
            'pic'                   => $request->pic_id_edit,
        ];
   
        $post_bot =[
            'subdetail_code'       =>  $id->subdetail_code,
            'name'                  => $request->name_edit_sub_module,
            'description'           => $request->description_edit_sub_module,
            'start_date'            => $request->start_date_edit_sub_module,
            'end_date'              => $request->end_date_edit_sub_module,
            'amount'                => $id->amount ==0 ? 0 : $request->actual_amount_edit,
            'pic'                   => $request->pic_id_edit,
            'created_at'            => date('Y-m-d H:i:s'),
            'user_id'               => auth()->user()->id,
            'remark'                => $request->remark_edit
        ];
       
        
         $user = auth()->user()->name;
         $newPIC = User::find( $request->pic_id_edit);
        //  dd($user);
        if($id->amount ==0){
            $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
            ."Old Task : \n \n \n"
            . "PIC          : " .$id->userRelation->name . "\n"
            . "Task         :  <b>$id->name</b>  \n"
            . "Start Date   :   $id->start_date \n"
            . "End Date   :   $id->end_date \n"
            . "Description   :   $id->description \n\n\n\n"
            
            ."New Task : \n \n \n "
            . "PIC          : " . $newPIC->name . "\n"
            . "Task         :  <b>$request->name_edit_sub_module</b>  \n"
            . "Start Date   :   $request->start_date_edit_sub_module \n"
            . "End Date   :   $request->end_date_edit_sub_module \n"
            . "Description   :   $request->description_edit_sub_module \n\n\n\n"
            
            ."Updated By  : $user
            ";

        }else{
            $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
            ."Old Task : \n \n \n"
            . "PIC              : " .$id->userRelation->name . "\n"
            . "Task             :  <b>$id->name</b>  \n"
            . "Start Date       :   $id->start_date \n"
            . "End Date         :   $id->end_date \n"
            . "Actual           :   $id->amount \n"
            . "Description      :   $id->description \n\n\n\n"
            
            ."New Task : \n \n \n "
            . "PIC          : " . $newPIC->name . "\n"
            . "Task         :  <b>$request->name_edit_sub_module</b>  \n"
            . "Start Date   :   $request->start_date_edit_sub_module \n"
            . "End Date   :   $request->end_date_edit_sub_module \n"
            . "Actual           :   $request->actual_amount_edit \n"
            . "Description   :   $request->description_edit_sub_module \n\n\n\n"
            
            ."Updated By  : $user
            ";
        }
        Telegram::sendMessage([
             'chat_id' => $header->id_channel,
             'parse_mode' => 'HTML',
             'text' => $text
         ]);
         $id->update($post);
         TimelineSubDetailLog::create($post_bot);

        return ResponseFormatter::success(   
            $id,                              
            'Task successfully updated'
        );    
    }
    function updateModule(Request $request) {
        try{
                $detail = TimelineDetail::where('detail_code', $request->detail_code)->first();
                $post = [
                    'start_date'    => $request->start_date_module_edit,
                    'end_date'      => $request->end_date_module_edit,
                    'name'          => $request->name_module_edit,
                    'plan'          => $request->plan_amount_edit,
                    'description'   => $request->description_module_edit,
                ];
                $postLog = [
                    'request_code'  => $detail->request_code,
                    'detail_code'   => $detail->detail_code,
                    'start_date'    => $request->start_date_module_edit,
                    'end_date'      => $request->end_date_module_edit,
                    'name'          => $request->name_module_edit,
                    'plan'          => $request->plan_amount_edit,
                    'description'   => $request->description_module_edit,
                    'user_id'       => auth()->user()->id,
                    'remark'        => $request->reason_module_edit,
                ];

                TimelineDetail::where('detail_code', $request->detail_code)->update($post);
                TimelineDetailLog::create($postLog);
                return ResponseFormatter::success(   
                    $post,                              
                    'Module successfully updated'
                );            
          } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Task failed to add',
                500
            );
        }  
    }
    function getLogTask(Request $request) {
        $detail = TimelineSubDetail::with(['userRelation'])->where('subdetail_code',$request->subdetail_code)->first();
        $data   = TimelineSubDetailLog::with(['userRelation','creatorRelation'])->where('subdetail_code',$request->subdetail_code)->get();
        return response()->json([
            'detail'        =>$detail,
            'data'       =>$data,
        ]); 
    }

}
