<?php

namespace App\Http\Controllers\Signature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SignatureHeader;
use App\Models\SignatureDetail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Models\Sign\ApprovalSign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
// use Barryvdh\DomPDF\Facade\Pdf;
use mPDF;
use NumConvert;
class SignTransactionController extends Controller
{
    public function index()
    {
        return view('sign.sign-index');
    }
    public function fetch(Request $request)
    {
        try {
            $signatureHeader = SignatureHeader::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success($signatureHeader, 'Transaction sign fetched successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(),'Transaction sign fetched error');
        }
    }
    public function fetchUserApproval()
    {
        try {
            $user = User::get(['id', 'name']);
            return ResponseFormatter::success($user,'user approval sign fetched successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(),'user approval sign fetched error');
        }
    }
    function getApprovalSign(Request $request) {
        $data = ApprovalSign::where('signature_code', $request->signature_code)->get();
        return response()->json([
            'data'=>$data,  
        ]);  
    }
    public function createSignTransaction(Request $request)
    {
        // try {
       
            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'approval_type'=> 'required',
                'title_sign'=> 'required|string',
                'description_sign'=> 'required|string',
                'total_approval_sign'=> 'required',
                'attachment_sign'=> 'required|mimes:png,pdf',
            ], [
                'approval_type.required'=> 'Approval type/Jenis approval tidak boleh kosong',
                'title_sign.required'=> 'Title sign/Tanda judul tidak boleh kosong',
                'description_sign.required'=> 'Desription sign/Deskripsi judul tidak boleh kosong',
                'total_approval_sign.required'=> 'Total approval sign/Jumlah approval tidak boleh kosong',
                // 'attachment_sign.required'=> 'Total approval sign/Jumlah approval tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $count_sign = SignatureHeader::count() + 1;
            $sign_type = $request->approval_type == 0 ? 'HRK' : 'NHR';
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            $month_romawi = NumConvert::roman($month);
      
            $this_year = now()->format('y');

            $result_signature_code = $count_sign.'/'.$sign_type.'/'.$month_romawi.'/'.$this_year;
            $result_file_name = $count_sign.'-'.$sign_type.'-'.$month_romawi.'-'.$this_year;

            $sign_attachment = $request->file('attachment_sign');
            $sign_attachment_name = $result_file_name.'.'.$sign_attachment->getClientOriginalExtension();
            $sign_attachment->move(public_path('storage/attachments/sign'), $sign_attachment_name);
            // $file_name_attachment = public_path('storage/attachments/sign/').$sign_attachment_name;

            $sign_data = [
                'approval_type' => $request->approval_type,
                'title' => $request->title_sign,
                'description' => $request->description_sign,
                'user_id' => Auth::id(),
                'attachment'=> 'storage/attachments/sign/'.$sign_attachment_name,
                // 'attachment'=> $file_name_attachment,
                'step_approval'=> $request->total_approval_sign,
                'status'=> 0,
                'step_approval_id'=> 0,
                'signature_code'=> $result_signature_code,
            ];

            $sign = SignatureHeader::create($sign_data);

            DB::commit();
            return ResponseFormatter::success($sign, 'sign transaction created successfully');
        // } catch (ValidationException $e) {
        //     // Return validation errors as JSON response
        //     DB::rollback();
        //     return ResponseFormatter::error(null, ['errors' => $e->errors()], 422);
        // } catch (\Throwable $th) {
        //     DB::rollback();
        //     return ResponseFormatter::error(null, $th->getMessage(), 500);
        // }
    }
    public function detailSign(Request $request)
    {
        try {
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            NumConvert::roman($month);

            $sign_transaction = SignatureHeader::find( $request->sign_id);
            // $user = User::get(['id', 'name']);
            $data = [
                $sign_transaction
            ];
            return ResponseFormatter::success($data,'sign transaction fetched successfully');
        } catch (\Throwable $th) {
            return ResponseFormatter::error(null, $th->getMessage(), 500);
        }
    }
    public function signDocument()
    {
        return view('sign.approval_sign.index');
    }
    public function viewPdf($id)
    {
        $signature_code   = str_replace('_','/',$id);
        $head = SignatureHeader::where('signature_code', $signature_code)->first();
        $data =[
            'head'      => $head,
        ];
        return view('sign.approval_sign.pdf_view',$data);
    }
    function updateApprovalSign(Request $request) {
        try {
            $validating = ApprovalSign::where('signature_code',$request->signature_code)->count();
            $array_post=[];
            foreach($request->user_array as $row){
                $post = [
                    'user_id'           => $row['user_id'],
                    'step'              => $row['step'],
                    'signature_code'       => $request->signature_code,
                    'created_at'        =>date('Y-m-d H:i:s')
                ];
                array_push($array_post, $post);
            }
            DB::transaction(function() use($validating,$array_post,$request) {
                if($validating > 0){
                    ApprovalSign::where('approval_id',$request->approval_id)->delete();
                    ApprovalSign::insert($array_post);
                }else{
                    ApprovalSign::insert($array_post);
                }
            });
            return ResponseFormatter::success(   
                $post,                              
                'Approver successfully updated'
            );            
        } catch (\Throwable $th) {
            return ResponseFormatter::error(
                $th,
                'Approver failed to update',
                500
            );
        }
    }
    function getUserSign(Request $request) {
        $data = ApprovalSign::with(['userRelation'])->where('signature_code',$request->signature_code)->get();
       return response()->json([
           'data'=>$data,  
       ]);    
   }
}
