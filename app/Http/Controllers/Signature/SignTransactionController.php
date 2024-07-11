<?php

namespace App\Http\Controllers\Signature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SignatureHeader;
use App\Models\SignatureDetail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\MonthRomawi;
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
    public function createSignTransaction(Request $request)
    {
        try {
            // $count_sign = SignatureHeader::count() + 1;
            // $sign_type = $request->approval_type == 0 ? 'HRK' : 'NHR';
            // $date_month =strtotime(date('Y-m-d'));
            // $month =idate('m', $date_month);
            // $month_romawi = NumConvert::roman($month);
            // $this_year = now()->format('y');
            // $result_file_name = $count_sign.'-'.$sign_type.'-'.$month_romawi.'-'.$this_year;
            // $file_name_attachment = public_path('storage/attachments/sign/').$result_file_name;
            // dd($file_name_attachment);
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
            // $month_romawi = MonthRomawi::romawi(now()->format('m'));
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
                'step_approval_id'=> $request->approval_list_data[0],
                'signature_code'=> $result_signature_code,
            ];

            $sign = SignatureHeader::create($sign_data);

            $data_approver = [];
            $list_approver = [];
            for ($i=0; $i < count($request->approval_list_data); $i++) { 
                $list_approver = [
                    'signature_id' => $sign->id,
                    'detail_signature_code'=> now()->format('Y-m-d H:i:s'),
                    'user_id' => $request->approval_list_data[$i],
                    'step' => $request->step_approval[$i],
                    'attachment' => $sign_attachment_name,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                ];
                array_push($data_approver, $list_approver);
            }

            $data_approver = SignatureDetail::insert($data_approver);

            DB::commit();
            return ResponseFormatter::success($sign, 'sign transaction created successfully');
        } catch (ValidationException $e) {
            // Return validation errors as JSON response
            DB::rollback();
            return ResponseFormatter::error(null, ['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return ResponseFormatter::error(null, $th->getMessage(), 500);
        }
    }
    public function detailSign(Request $request)
    {
        try {
            $date_month =strtotime(date('Y-m-d'));
            $month =idate('m', $date_month);
            NumConvert::roman($month);

            $sign_transaction = SignatureHeader::with(['SignatureDetail.user'])->where('id', $request->sign_id)->first();
            // $user = User::get(['id', 'name']);
            $data = [
                $sign_transaction,
                // 'user' => $user
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
    public function viewPdf($filename)
    {
        set_time_limit(0);
        $path = public_path('storage/attachments/sign/' . $filename);

        // dd($path);
        if (!file_exists($path)) {
            abort(404, 'File not found');
        }
        // Memuat konten file PDF
        $pdf_content = file_get_contents($path);
        $pdf = mPDF::loadView('sign.approval_sign.pdf_view', compact('pdf_content'));

        // Tampilkan PDF di browser
        // return $pdf->stream($filename);
        return response($pdf_content, 200)->header('Content-Type', 'application/pdf');
    }
}
