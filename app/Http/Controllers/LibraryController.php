<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreLibraryRequest;
use App\Http\Requests\UpdateLibraryRequest;
use App\Models\LibraryBackup;
use App\Models\LibraryModel;
use App\Models\MasterDepartment;
use Illuminate\Http\Request;
use NumConvert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class LibraryController extends Controller
{
    function index() {
        return view('library.library-index');
    }
    function getLibrary() {
        $data = LibraryModel ::with([
            'userRelation',
            'departmentRelation',
            'locationRelation',
            ])->get();
        return response()->json([
            'data'=>$data
        ]); 
    }
    function addLibrary(Request $request, StoreLibraryRequest $storeLibraryRequest) {
        try {    
            $storeLibraryRequest->validated();
            $increment_code= LibraryModel::orderBy('id','desc')->first();
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $year = idate('y', $date_month);
            $month_convert =  NumConvert::roman($month);
            $department = MasterDepartment::find($request->department)->first();
            if($increment_code ==null){
                $ticket_code = '1/'.$department->initial.'/'.$request->location_id.'/'.$month_convert.'/'.$year;
            }else{
                $month_before = explode('/',$increment_code->request_code,-1);
                if($month_convert != $month_before[3]){
                    $ticket_code = '1/'.$department->initial.'/'.$request->location_id.'/'.$month_convert.'/'.$year;
                }else{
                    $ticket_code = $month_before[0] + 1 .'/'.$department->initial.'/'.$request->location_id.'/'.$month_convert.'/'.$year;
                }   
            }
            $fileName ='';
            if($request->file('attachment')){
                $ticketName = explode("/", $ticket_code);
                $ticketName2 = implode('',$ticketName);
                $originalName = $request->file('attachment')->getClientOriginalExtension();
                $fileName =$ticketName2.'.'.$originalName;
            }
            $post =[
                'request_code'      => $ticket_code,
                'name'              => $request->name,
                'attachment'        => 'storage/library/'.$fileName,
                'description'       => $request->description,
                'department'        => $request->department,
                'location'          => $request->location_id,
                'user_id'           => auth()->user()->id,
            ];
             LibraryModel::create($post);
             if($request->file('attachment')){
               $request->file('attachment')->storeAs('public/library',$fileName);
            }
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
    function updateLibrary(Request $request, UpdateLibraryRequest $updateLibraryRequest) {
        // try {    
            $updateLibraryRequest->validated();
            $ticket= LibraryModel::find($request->id);
         
            $explode = str_replace('/','',$ticket->request_code);
            $fileName ='';
            if($request->file('attachment_edit')){
                $ticketName = explode("/", $ticket->request_code);
                $ticketName2 = implode('',$ticketName);
                $originalName = $request->file('attachment_edit')->getClientOriginalExtension();
                $fileName =$ticketName2.'.'.$originalName;
            }
            $post =[
                'name'              => $request->name_edit,
                'attachment'        => 'storage/library/'.$fileName,
                'description'       => $request->description_edit,
                'department'        => $request->department_edit,
                'location'          => $request->location_id_edit,
                'updated_at'        => date('Y-m-d H:i:s')
            ];
           
             if ($request->hasFile('attachment_edit')) {
                $file = $request->file('attachment_edit');
                $fileNameBackup = strtoupper(str_replace('/', '', $ticket->request_code)) .date('YmdHis'). '.' . $file->getClientOriginalExtension();
                $fileName = strtoupper(str_replace('/', '', $ticket->request_code)). '.' . $file->getClientOriginalExtension();
                
                // Move the uploaded file to another directory
                if ($ticket->attachment != '') {
                    $newDirectory = 'public/library_backup';
                    $moved = Storage::move('public/library/' . basename($ticket->attachment), $newDirectory . '/' . $fileNameBackup);
                    if (!$moved) {
                        return ResponseFormatter::error('Failed to move attachment to another directory.', 'Error', 500);
                    }
                 
                   
                }
                $update = $request->file('attachment_edit')->storeAs('public/library',$fileName);
                // dd($update);
                $post_backup =[
                    'request_code'   => $ticket->request_code,
                    'attachment'    => 'storage/library_backup/'.$fileNameBackup,
                    'user_id'       => auth()->user()->id,
                ];
                $insert = LibraryBackup::create($post_backup);
                $ticket->update($post);
            }
            return ResponseFormatter::success(   
                $post,                              
                'Status successfully updated'
            );            
        // } catch (\Throwable $th) {
        //     return ResponseFormatter::error(
        //         $th,
        //         'Status failed to update',
        //         500
        //     );
        // }
    }
    function detailLibrary(Request $request) {
        $detail = LibraryModel ::with([
            'userRelation',
            'departmentRelation',
            'locationRelation',
            ])->where('id',$request->id)->first();
        $data = LibraryBackup::with([
            'userRelation'
        ])->where('request_code', $detail->request_code)->get();
        return response()->json([
            'detail'=>$detail,
            'data'=>$data,
        ]); 
    }
}
