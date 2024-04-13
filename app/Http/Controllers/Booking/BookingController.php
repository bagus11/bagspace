<?php

namespace App\Http\Controllers\Booking;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateApprovalTicketRequest;
use App\Models\Booking\ApprovalModel;
use App\Models\Booking\BookingDetail;
use App\Models\Booking\BookingHeader;
use App\Models\Booking\MasterApproval;
use App\Models\Booking\MasterRoomModel;
use App\Models\Booking\MeetingLink;
use App\Models\Setting\MasterLocation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;
use PhpParser\Node\Stmt\TryCatch;
use NumConvert;

class BookingController extends Controller
{
    function index() {
        return view('booking.booking_room.booking_room-index');
    }
    function getTicket() {
        $data = BookingHeader::with([
            'locationRelation'
        ])->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function getActiveRoom(Request $request) {
        $data = MasterRoomModel::where('location',$request->location_id)->where('status',0)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    function createTicket(Request $request, StoreTicketRequest $storeTicketRequest) {
           // try {
            $storeTicketRequest->validated();
            $transaction_code ='';
            $increment_code = BookingHeader::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $typeLabel = $request->type_id == 1 ? "OFF" : "ON";
            $locationLabel = MasterLocation::find($request->location_id);
            $month_convert =  NumConvert::roman($month);
            if($increment_code ==null){
                $transaction_code = '1/'.$typeLabel.'/'.str_pad($locationLabel->initial, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->meeting_id,-1);
                if($month_convert != $month_before[3]){
                    $transaction_code = '1/'.$typeLabel.'/'.str_pad($locationLabel->initial, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }else{
                    $transaction_code = $month_before[0] + 1 .'/'.$typeLabel.'/'.str_pad($locationLabel->initial, 2, '0', STR_PAD_LEFT).'/'.$month_convert.'/'.$year;
                }   
            }
            $getApprover = ApprovalModel::where('location_id',$request->location_id)->orderBy('id','asc')->first();
            
            $post =[
                'meeting_id'        => $transaction_code,
                'title'             => $request->title,
                'description'       => $request->description,
                'meeting_code'      =>'-',
                'location_id'       => $request->location_id,
                'room_id'           => $request->type_id == 1 ? $request->room_id : 0,
                'type'              => $request->type_id,
                'status'            => 0,
                'step'              => 1,
                'user_id'           => auth()->user()->id,
                'approval_id'       => $request->type_id == 1 ? $getApprover->user_id: 5,
                'date_start'        =>$request->start_date,
                'start_time'        =>$request->start_time,
                'end_time'          =>$request->end_time,
            ];
            $post_log =[
                'meeting_id'        => $transaction_code,
                'user_id'           => auth()->user()->id,
                'status'            => 0,
                'step'              => 0,
                'remark'            => auth()->user()->name.' has create a new ticket'
            ];
            DB::transaction(function() use($post,$post_log,$request) {
                BookingHeader::create($post);
                BookingDetail::create($post_log);

            });
            return ResponseFormatter::success(   
                $post,                              
                'Ticket successfully created, please notify your approver. Thanks :)'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Ticket failed to update',
        //         500
        //     );
        // }
    }
    function detailTicket(Request $request) {
        // dd($request);
        $detail = BookingHeader::with([
            'userRelation',
            'locationRelation',
            'roomRelation',
        ])->where('id',$request->id)->first();
        $data = BookingDetail ::with([
            'userRelation'
        ])->where('meeting_id',$detail->meeting_id)->get();
        $approval = ApprovalModel::with([
            'approvalRelation'
        ])->where('location_id', $detail->location_id)->get();
        $user = User::where('flg_aktif', 1)->get();
        
        return response()->json([
            'detail'=>$detail,  
            'data'=>$data,  
            'user'=>$user,  
            'approval'=>$approval,  
        ]);  
    }
    function updateApprovalTicket(Request $request, UpdateApprovalTicketRequest $updateApprovalTicketRequest) {
           // try {
            $updateApprovalTicketRequest->validated();
            $bookingHeader              = BookingHeader::where('meeting_id', $request->meeting_id)->first();
            $countApproval              = ApprovalModel::where('location_id', $bookingHeader->location_id)->count();
            $stepApproval               = $bookingHeader->step == 0 ? $bookingHeader->step + 1 :  $bookingHeader->step + 1;
            $nextApproval               = ApprovalModel::where('location_id', $bookingHeader->location_id)->where('step', $stepApproval)->first();
            $lastApprover               = ApprovalModel::where('location_id', $bookingHeader->location_id)->orderBy('id', 'desc')->first();
           
            $status                     =0;
            if($request->selectApproval == 1){
                if($bookingHeader->status == 1){
                    $status     = $bookingHeader->status;
                    if($nextApproval == null){
                        $status     = $bookingHeader->status + 1;
                    }
                }else{
                    $status     = $bookingHeader->status + 1;
                }
                $arrayPostLink =[];
                if($request->option_meet_id){
                    foreach($request->array_list_user as $row){
                        // if get last approver
                            $meetingIdReplace = str_replace('/','',$request->meeting_id);
                            if($lastApprover->user_id == auth()->user()->id){
                                $length = 32; // panjang string yang diinginkan
                                $randomString =$meetingIdReplace. bin2hex(random_bytes($length));
                            }
                            // dd($request);
                            $meetingPost =[
                                'meeting_id'    => $request->meeting_id,
                                'link'          => $randomString,
                                'user_id'       => $row['value'],
                                'status'        => 0,
                                'type'          => $request->option_meet_id,
                            ];
                            
                        // if get last approver
                        array_push($arrayPostLink,$meetingPost);
                    }
                }
                // Last Before Upload Data
                    $postHeader                       =[
                                                    'step'              => $nextApproval === null ? 0 : $bookingHeader->step + 1,
                                                    'status'            => $status,
                                                    'approval_id'       => $nextApproval === null ? 0 : $nextApproval->user_id,
                                                    'updated_at'        => date('Y-m-d H:i:s')
                                                ];
                    $post_log                   =[
                                                    'meeting_id'        => $request->meeting_id,
                                                    'user_id'           => auth()->user()->id,
                                                    'step'              => $bookingHeader->step,
                                                    'remark'            => $request->remark_approval,
                                                    'status'            => $status
                                                ];
                // Last Before Upload Data

            }else{
                $postHeader                       =[
                                                'step'              => 0,
                                                'status'            => 9,
                                                'approval_id'       => 0,
                                                'updated_at'        => date('Y-m-d H:i:s')
                                            ];
                $post_log                   =[
                                                'meeting_id'        => $request->meeting_id,
                                                'user_id'           => auth()->user()->id,
                                                'step'              => $bookingHeader->step,
                                                'remark'            => $request->remark_approval,
                                                'status'            => 9
                                            ];
            }
            dd($request);
            DB::transaction(function() use($request,$postHeader,$post_log,$arrayPostLink) {
               $test = BookingHeader::where('meeting_id', $request->meeting_id)->update($postHeader);
                
               BookingDetail::create($post_log);
               if($request->selectApproval == 1  && count($arrayPostLink) > 0){
                    MeetingLink::insert($arrayPostLink);
               }

            });
            return ResponseFormatter::success(   
                $postHeader,                              
                'Ticket successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Ticket failed to update',
        //         500
        //     );
        // }
    }
}
