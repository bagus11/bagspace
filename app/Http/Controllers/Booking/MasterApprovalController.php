<?php

namespace App\Http\Controllers\Booking;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addMasterApprovalRequest;
use App\Http\Requests\updateApprovalRequest;
use App\Http\Requests\updateMasterApprovalRequest;
use App\Models\Booking\ApprovalModel;
use App\Models\Booking\BookingHeader;
use App\Models\Booking\MasterApproval;
use App\Models\Setting\MasterLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterApprovalController extends Controller
{
    function index() {
        return view('booking.approval.approval-index');
    }
    function getApproval(Request $request) {
        $data = MasterApproval::with([
            'locationRelation'
        ])->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getStepApproval(Request $request) {
        $data = ApprovalModel::with('approvalRelation')->where('approval_id',$request->approval_id)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function addMasterApproval(Request $request, addMasterApprovalRequest $addMasterApprovalRequest) {
        try {
            $addMasterApprovalRequest->validated();
            $location = MasterLocation::find($request->location_id);
            $ticket = date('YmdHis').'-'.$location->initial;
            $post =[
                'step'              => $request->step,
                'location_id'       => $request->location_id,
                'approval_id'       => $ticket
            ];
            MasterApproval::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully added'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Master Approver failed to add',
                500
            );
        }
        
    }
    function updateApproval(Request $request, updateApprovalRequest $updateApprovalRequest) {
           try {
            $updateApprovalRequest->validated();
            $validating = ApprovalModel::where('approval_id',$request->approval_id)->count();
            $array_post=[];
            foreach($request->user_array as $row){
                $location = MasterApproval::where('approval_id',$request->approval_id)->first(); 
                $post = [
                    'user_id'           => $row['user_id'],
                    'step'              => $row['step'],
                    'location_id'       => $location->location_id,
                    'approval_id'       => $location->approval_id,
                    'created_at'        =>date('Y-m-d H:i:s')
                ];
                array_push($array_post, $post);
            }
            DB::transaction(function() use($validating,$array_post,$request) {
                if($validating > 0){
                    ApprovalModel::where('approval_id',$request->approval_id)->delete();
                    ApprovalModel::insert($array_post);
                }else{
                    ApprovalModel::insert($array_post);
                }
            });
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Master Approver failed to update',
                500
            );
        }
    }
    function detailMasterApproval(Request $request) {
        $detail = MasterApproval::with([
            'locationRelation'
        ])
        ->where('id',$request->id)
        ->first();
        return response()->json([
            'detail'=>$detail,  
        ]);  
    }
    function editMasterApproval(Request $request, updateMasterApprovalRequest $updateApprovalRequest) {
        // try {
            $updateApprovalRequest->validated();
            $post =[
                'step'              => $request->edit_step,
            ];
            MasterApproval::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Master Approver successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Master Approver failed to update',
        //         500
        //     );
        // }
    }
    function getApprover(Request $request) {
        $data = BookingHeader::where('approval_id',auth()->user()->id)->get();
        
        return response()->json([
            'data'=>$data,  
        ]);   
    }
}
