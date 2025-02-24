<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeTimelineHeaderRequest;
use App\Http\Requests\SummonBotRequest;
use App\Models\logTimelineHistoryDate;
use App\Models\Timeline\DetailTeamTimeline;
use App\Models\Timeline\TimelineHeader;
use App\Models\Timeline\TimelineSubDetail;
use App\Models\Timeline\TimelineSubDetailLog;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use NumConvert;
use Telegram\Bot\Laravel\Facades\Telegram;
class MonitoringTimelineController extends Controller
{
    function index(){
        return view('timeline.monitoring_timeline.monitoring_timeline-index');
    }
    function getTimelineHeader(){
        if(auth()->user()->hasPermissionTo('get-only_admin-monitoring_timeline'))
        {
            $data = TimelineHeader::with(['officeRelation','teamRelation','typeRelation'])->get();
        }else{
            $data = TimelineHeader::with([
                'officeRelation',
                'teamRelation',
                'typeRelation',
                'teamRelation.detailRelation.UserRelation',
                'taskRelation',
                'taskRelation.detailRelation',
                'detailRelation',
                ])->
            whereHas('teamRelation.detailRelation.UserRelation', function($q){
                $q->where('id',auth()->user()->id);
            })->get();
        }
       
        
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getTimelineHeaderUser(){
        $data = TimelineHeader::with([
                                    'officeRelation',
                                    'teamRelation',
                                    'teamRelation.detailRelation.UserRelation',
                                    'taskRelation',
                                    'typeRelation',
                                    'taskRelation.detailRelation',
                                    'detailRelation',
                                    ])->
                                whereHas('teamRelation.detailRelation.UserRelation', function($q){
                                    $q->where('id',auth()->user()->id);
                                })->get();
        $daily = TimelineSubDetailLog::where('user_id',auth()->user()->id)
                                        ->where('subdetail_code','-')
                                        ->where('start_date', date('Y-m-d'))
                                        ->get();
        return response()->json([
            'data'=>$data,
            'daily'=>$daily,
        ]);
    }
    function getTimelineHeaderDetail(Request $request) {
        $data = TimelineHeader::with([
            'officeRelation',
            'teamRelation',
            'teamRelation.detailRelation.UserRelation',
            'taskRelation',
            'taskRelation.detailRelation',
            'detailRelation',
            ])->
        whereHas('teamRelation.detailRelation.UserRelation', function($q){
            $q->where('id',auth()->user()->id);
        })->where('request_code', $request->request_code)->get();
        return response()->json([
        'data'=>$data,
        ]);
    }
    public function saveTimelineHeader(Request $request, storeTimelineHeaderRequest $storeTimelineHeaderRequest)
    { 
       
        // try {
            $storeTimelineHeaderRequest->validated();
            $increment_code= TimelineHeader::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $ticket_code = '1/TML/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
               
                if($month_convert != $month_before[2]){
                    $ticket_code = '1/TML/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/TML/'.$month_convert.'/'.$year;
                }   
            }
       
            $post =[
                'request_code'=>$ticket_code,
                'name'=>$request->name,
                'office_id'=>$request->office_id,
                'description'=>$request->description,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'team_id'=>$request->team_id,
                'user_id'=>auth()->user()->id,
                'status'=>0,
                // 'type_id'=>$request->type_id,
                'percentage'=>0,
                'token'=>'6586388951:AAFftrLrMijUCYVhiQjCY0EesZDxjzYSHUA',
                'link'=>'',
                'id_channel'=>'',
            ];
            $postLog=[
                'request_code'=>$ticket_code,
                'team_id'=>$request->team_id,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'remark'    =>'has created this project',
                'user_id'=>auth()->user()->id,
            ];
            // dd($request);
    
            TimelineHeader ::create($post);
            logTimelineHistoryDate ::create($postLog);
            return ResponseFormatter::success(
               $post,
                'Timeline Header successfully added'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Timeline Header failed to update',
        //         500
        //     );
        // }
    }
    
    function detailTimeline(Request $request) {
        $detail             = TimelineHeader::with(['officeRelation','teamRelation','picRelation'])->where('id',$request->id)->first();
        $table              = DetailTeamTimeline::select('users.name as username','detail_team_timeline.*')
                                        ->join('users','users.id','detail_team_timeline.user_id')
                                        ->where('team_id',$detail->team_id)
                                        ->orderBy('detail_team_timeline.position', 'desc')
                                        ->get();
        $log                = logTimelineHistoryDate::with('picRelation')->where('team_id',$detail->team_id)->where('request_code',$detail->request_code)->orderBy('created_at','desc')->get();
        return response()->json([
            'detail'=>$detail,
            'table'=>$table,
            'log'=>$log,
        ]);
    }
    function updateLogTimelineHeaderDate(Request $request) {
        // try {
            $postLog=[      
                'start_date'    =>$request->start_date_edit,
                'end_date'      =>$request->end_date_edit,
                'team_id'       =>$request->team_id_edit,
                'request_code'  =>$request->request_code_edit,
                'remark'        =>$request->description_edit,
                'user_id'       =>auth()->user()->id,
                'created_at'    =>date('Y-m-d H:i:s')
            ];
            $postHead=[      
                'start_date'    =>$request->start_date_edit,
                'end_date'      =>$request->end_date_edit,
                'team_id'       =>$request->team_id_edit,
                'request_code'  =>$request->request_code_edit,
                'user_id'       =>auth()->user()->id,
                'created_at'    =>date('Y-m-d H:i:s')
            ];
            $post =[
                'start_date'    =>$request->start_date_edit,
                'end_date'      =>$request->end_date_edit,
                'updated_at'    =>date('Y-m-d H:i:s')
            ];
            // dd($request);
          
            logTimelineHistoryDate ::create($postLog);
            TimelineHeader ::where('request_code',$request->request_code_edit)->where('team_id', $request->team_id_edit)->update($postHead);
            return ResponseFormatter::success(
               $post,
                'Timeline Header successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Timeline Header failed to update',
        //         500
        //     );
        // }
    }
   
    function summonBot(Request $request, SummonBotRequest $summonBotRequest) {
    //   try {   
        $summonBotRequest->validated();
        $header = TimelineHeader::find($request->id);
        $post =[
            'status_bot'    => 1,
            'link'          =>$request->link,
            'id_channel'    => $request->channel
        ];
        // dd($request->channel);
       // Menambahkan nilai $request->channel ke dalam file .env
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        

        // Extract the existing TELEGRAM_CHANNEL_ID value from the .env file
        preg_match('/TELEGRAM_CHANNEL_ID\s*=\s*\[(.*?)\]/', $str, $matches);
        $existingChannels = isset($matches[1]) ? $matches[1] : '';
        
        $newChannelId = $request->channel;
      
        // If there are existing channel IDs, append the new channel ID
        if ($existingChannels) {
            // Append the new channel ID to the existing array
            $newChannels = rtrim($existingChannels, ', ') . ', ' . $newChannelId;
        } else {
            // If there are no existing channel IDs, create a new array with the new channel ID
            $newChannels = $newChannelId;
        }
        
        // Extract channel IDs into an array
        $channelIdsArray = explode(',', $newChannels);
      
        // Set chat_id to the last channel ID in the array
        $lastChannelId = end($channelIdsArray);
        
        // Set up Telegram message
        $text = "<b style='text-align:center'>" . $header->name . "</b>\n\n\n\n"
            . "PIC          : " . auth()->user()->name . "\n"
            . "ICT DEV - Bot Successfully activated :)";
        
        \Dotenv\Dotenv::createImmutable(base_path())->load();
        // Send Telegram message to the last channel ID
        
        $send = Telegram::sendMessage([
            'chat_id' => $lastChannelId,
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        
        $header->update($post);
        // Jika sudah ada, bisa dilakukan pembaruan sesuai kebutuhan

        // Refresh konfigurasi Laravel agar perubahan .env bisa diakses secara langsung
  
        return ResponseFormatter::success(
            $post,
             'BOT successfully activated :)'
         );            
    //  } catch (\Throwable $th) {
    //      return ResponseFormatter::error(
    //          $th,
    //          'BOT failed to update',
    //          500
    //      );
    //  }
    }
    public function removeChannelIdFromEnv($channelIdToRemove)
    {
        // Path menuju file .env
        $envFilePath = base_path('.env');

        // Membaca isi file .env
        $envContent = file($envFilePath);

        // Menghapus baris yang mengandung TELEGRAM_CHANNEL_ID=$channelIdToRemove
        $updatedEnvContent = array_filter($envContent, function ($line) use ($channelIdToRemove) {
            return strpos($line, 'TELEGRAM_CHANNEL_ID='.$channelIdToRemove) === false;
        });

        // Menulis ulang file .env dengan isi yang sudah diubah
        file_put_contents($envFilePath, implode('', $updatedEnvContent));

        return response()->json(['message' => 'Channel ID removed from .env']);
    }

}
