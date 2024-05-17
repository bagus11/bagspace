<?php

namespace App\Http\Controllers\Timeline;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMasterTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Models\Timeline\MasterTypeTimeline;
use Illuminate\Http\Request;

class MasterTypeController extends Controller
{
    function index(){
        return view('timeline.master_type.master_type-index');
    }
    function getTimelineType() {
        $data = MasterTypeTimeline::all();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function getActiveTimelineType() {
        $data = MasterTypeTimeline::where('status',1)->get();
        return response()->json([
            'data'=>$data,
        ]);
    }
    function saveTimelineType(Request $request, StoreMasterTypeRequest $storeMasterTypeRequest) {
        try {
            $storeMasterTypeRequest->validated();
            $post =[
                'name'    =>$request->name,
                'status'    =>0,
            ];
            // dd($request);
          
            MasterTypeTimeline ::create($post);
            return ResponseFormatter::success(
               $post,
                'Type successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to update',
                500
            );
        }
    }
   
    function updateTimelineType(Request $request, UpdateTypeRequest $updateTypeRequest) {
        try {
            $updateTypeRequest->validated();
            $post =[
                'name'    =>$request->name_edit,
            ];
            // dd($request);
          
            MasterTypeTimeline ::find($request->id)->update($post);
            return ResponseFormatter::success(
               $post,
                'Type successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to update',
                500
            );
        }
    }
    function updateStatusType(Request $request) {
        try {
            $header = MasterTypeTimeline::find($request->id);
            $post =[
                'status'    => $header->status == 0 ?1 : 0
            ];
            $header->update($post);
            return ResponseFormatter::success(
               $post,
                'Type successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Type failed to update',
                500
            );
        }
    }

}
