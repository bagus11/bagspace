<?php

namespace App\Http\Controllers\Booking;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\addRoomRequest;
use App\Http\Requests\updateRoomRequest;
use App\Models\Booking\MasterRoomModel;
use App\Models\Setting\MasterLocation;
use Illuminate\Http\Request;

class MasterRoomController extends Controller
{
    function index() {
        return view('booking.master_room.master_room-index');
    }
    function getRoom() {
        $data = MasterRoomModel::with([
            'locationRelation',
        ])->get();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function detailRoom(Request $request) {
        $detail = MasterRoomModel::find($request->id);
        return response()->json([
            'detail'=>$detail,
        ]); 
    }
    function getLocation() {
        $data = MasterLocation::all();
        return response()->json([
            'data'=>$data,
        ]); 
    }
    function addRoom(Request $request, addRoomRequest $addRoomRequest) {
         // try{
            $addRoomRequest->validated();
            $post=[
                'name'=>$request->name,
                'description'=>$request->description,
                'location'=>$request->location_id,
                'user_id'   =>auth()->user()->id,
                'status'   =>0,
            ];
            MasterRoomModel::create($post);
            return ResponseFormatter::success(   
                $post,                              
                'Room successfully added'
            );            
    // } catch (\Throwable $th) {
    //     return ResponseFormatter::error(
    //         $th,
    //         'Transaction failed to update',
    //         500
    //     );
    // }
    }
    function updateRoom(Request $request, updateRoomRequest $updateRoomRequest) {
         // try{
            $updateRoomRequest->validated();
            $post=[
                'name'=>$request->name_edit,
                'description'=>$request->description_edit,
                'location'=>$request->location_id_edit,
                'user_id'   =>auth()->user()->id
            ];
            MasterRoomModel::find($request->id)->update($post);
            return ResponseFormatter::success(   
                $post,                              
                'Room  successfully udpate'
            );            
    // } catch (\Throwable $th) {
    //     return ResponseFormatter::error(
    //         $th,
    //         'Transaction failed to update',
    //         500
    //     );
    // }
    }
}
