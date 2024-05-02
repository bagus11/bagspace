<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateMasterTeamRequest;
use App\Models\Timeline\DetailTeamTimeline;
use App\Models\Timeline\MasterTeamTimeline;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterTeamTimelineController extends Controller
{
    function index(){
        return view('timeline.master_team_timeline.master_team_timeline-index');
    }
    function getTeamTimeline() {
        $data = MasterTeamTimeline::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getActiveTeam() {
        $data = MasterTeamTimeline::where('status',1)->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getDetailTeam( Request $request){
        $active         =  User::select('users.name','users.id')
                                ->leftJoin('detail_team_timeline', 'detail_team_timeline.user_id','users.id')
                                ->where('detail_team_timeline.team_id',$request->id)
                                ->get();
        $innactive      =  User::select('users.name','users.id')
                                ->whereNotIn('users.id',DB::table('detail_team_timeline')
                                ->select('user_id')
                                ->where('team_id',$request->id))
                                ->get();
        $leaderOption   =  User::all();
        return response()->json([
            'active'=>$active,
            'innactive'=>$innactive,
            'leaderOption'=>$leaderOption,
        ]);
    }
    function updateStatusMasterTeamTimeline( Request $request) {
        try {    
            $post =[
                'status'        => $request->status == 1 ? 0 : 1,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $role = MasterTeamTimeline::findOrFail($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
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
    public function addDetailTeam(Request $request)
    {
        $status = 500;
        $message = 'Data failed to add';
        $userArray = $request->checkArray;
        $postArray =[];
        foreach($userArray as $row){
            $post=[
                'team_id'=>$request->id,
                'user_id'=>$row,
                'position'=>1,
                'created_at'=>date('Y-m-d H:i:s')
            ];
            array_push($postArray, $post);
        } 
       
        $insert = DetailTeamTimeline::insert($postArray);
        if($insert){
            $status = 200;
            $message = 'Data successfully insert';
        }
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    public function updateDetailTeam(Request $request)
    {
        $status = 500;
        $message = 'Data failed to add';
        $userArray = $request->checkArray;
        foreach($userArray as $row){
            $delete =DetailTeamTimeline::where('team_id', $request->id)->where('user_id',$row)->delete();
            if($delete){
                $message="Data successfully update";
                $status=200;
            }
        } 
        return response()->json([
            'message'=>$message,
            'status'=>$status,
        ]);
    }
    function saveTeam(Request $request, CreateTeamRequest $createTeamRequest) {
        try {    
            $createTeamRequest->validated();
            $post =[
                'name'          => $request->team_name,
                'status'        => 0
            ];
             MasterTeamTimeline::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Team successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Team failed to add',
                500
            );
        }
    }
    public function getMasterTeamDetail(Request $request)
    {
        $detail             = MasterTeamTimeline::find($request->id);
        $table              = DetailTeamTimeline::select('users.name as username','detail_team_timeline.*')
                                        ->join('users','users.id','detail_team_timeline.user_id')
                                        ->where('team_id',$request->id)
                                        ->orderBy('detail_team_timeline.position', 'desc')
                                        ->get();
        $leader             = DetailTeamTimeline::select('users.name as username','users.id')->join('users','users.id','detail_team_timeline.user_id')->where('team_id',$request->id)->where('position',2)->first();
        return response()->json([
            'detail'=>$detail,
            'table'=>$table,
            'leader'=>$leader,
        ]);
    }
    public function updateMasterTeam(Request $request, UpdateMasterTeamRequest $updateMasterTeamRequest)
    { 
       
        // try {
            $updateMasterTeamRequest->validated();
            $post =[
                'name'=>$request->teamNameUpdate
            ];
            // dd($request);
            DetailTeamTimeline ::where('team_id',$request->id)->where('position',2)->update(['position'=>1]);
            $update = DetailTeamTimeline ::where('team_id',$request->id)->where('user_id',$request->leaderId)->update(['position'=>2]);
            
            if($update){
                MasterTeamTimeline::find($request->id)->update($post);
            }
            return ResponseFormatter::success(
               $post,
                'Position successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Position failed to update',
        //         500
        //     );
        // }
    }
}
