<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\storeTimelineHeaderRequest;
use App\Models\logTimelineHistoryDate;
use App\Models\Timeline\DetailTeamTimeline;
use App\Models\Timeline\MasterTeamTimeline;
use App\Models\Timeline\TimelineHeader;
use Illuminate\Http\Request;
use NumConvert;
class MonitoringTimelineController extends Controller
{
    function index(){
        return view('timeline.monitoring_timeline.monitoring_timeline-index');
    }
    function getTimelineHeader(){
        $data = TimelineHeader::with(['officeRelation','teamRelation'])->get();
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
                'percentage'=>0,
            ];
            $postLog=[
                'request_code'=>$ticket_code,
                'team_id'=>$request->team_id,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
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
            TimelineHeader ::where('request_code',$request->request_code_edit)->where('team_id', $request->team_id_edit)->update($postLog);
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

}
