<?php

namespace App\Http\Controllers\Signature;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SignatureHeader;
use App\Models\SignatureDetail;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\ValidationSignRequest;
use App\Mail\SignatureNotification;
use App\Models\Sign\ApprovalSign;
use App\Models\Sign\MasterSignature;
use FPDF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use \Mpdf\Mpdf as PDF;
use Mpdf\MpdfException;
use mPDF;
use NumConvert;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use Illuminate\Support\Facades\Log;
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
        $detail = SignatureHeader::find( $request->sign_id);
        $data   = SignatureDetail::with('userRelation')->where('signature_code', $detail->signature_code)->groupBy('user_id')->get();
        return response()->json([
            'detail'=>$detail,  
            'data'=>$data,  
        ]);    
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
   function sendSign(Request $request) {
    try {
        $array = [];
        $response = $request->array;
        $x = $request->x; // Canvas width
        $y = $request->y; // Canvas height
        
        for ($i = 0; $i < count($response); $i++) {
            // Calculate scaled coordinates based on canvas dimensions
            $pdfX = $x * $response[$i]['x_location'];
            $pdfY = $y * $response[$i]['y_location'];
          
            // Generate ticket based on current date, user ID, and interval
            $interval = NumConvert::roman($i + 3);
            $date_month = strtotime(date('Y-m-d'));
            $month = idate('m', $date_month);
            $mont_convert = NumConvert::roman($month);
            $userHead = User::find($response[$i]['id']); 
            $nik = $userHead->nik;
            $ticket = 'DS/' . date('YmdHis') . '/' . $nik . '/' . $mont_convert . '/' . $interval;
            
            // Fetch signature header information
            $head = SignatureHeader::with(['userRelation'])
                    ->where('signature_code', $request->signature_code)
                    ->first();
            
            // Fetch approval sign step
            $step = ApprovalSign::where([
                        'signature_code' => $request->signature_code,
                        'user_id' => $response[$i]['id'],
                    ])->first();

            // Create array for database insertion
            $post = [
                'signature_code' => $request->signature_code,
                'detail_signaturecode' => $ticket,
                'user_id' => $response[$i]['id'],
                'signature_type' => $response[$i]['type_id'],
                'step' => $step->step,
                'page_number' => $response[$i]['page_location'],
                // 'x' => $pdfX, // Scaled x coordinate
                // 'y' => $pdfY, // Scaled y coordinate
                'status' => 0,
                'x' => $response[$i]['x_location'], // Original x coordinate
                'y' => $response[$i]['y_location'], // Original y coordinate
            ];
            
            // Push the constructed post array into the main array
            array_push($array, $post);
        }       
        // dd($array);
        // Transaction to insert signature details and update header status
        DB::transaction(function() use($array, $request, $head, $ticket) {
            SignatureDetail::insert($array);

            SignatureHeader::where('signature_code', $request->signature_code)
                ->update([
                    'status' => 1,
                    'step_approval_id' => $head->step_approval_id + 1
                ]);

            // Send email notification
            $target = ApprovalSign::with('userRelation')
                        ->where('signature_code', $request->signature_code)
                        ->first();
            Mail::to($target->userRelation['email'])
                ->send(new SignatureNotification($ticket, $head, $target, $head->title));
        });

        // Return success response
        return ResponseFormatter::success(
            $post,
            'Signature successfully sent, this page will automatically close in 5 seconds, thanks :)'
        );            
    } catch (\Throwable $th) {
        // Return error response if any exception occurs
        return ResponseFormatter::error(
            $th,
            'Signature failed to send',
            500
        );
    }
}

   function validationSign($id) {
        Auth::check();
        $signature_code = str_replace('_','/', $id);
        $head = SignatureHeader::where('signature_code',$signature_code)->first();
        $data =[
            'head' =>$head
        ];
        return view('sign.validation_sign.validation_sign-index',$data);
   }
   function getValidationSign(Request $request) {
        $data = SignatureDetail::with([
            'userRelation',
            'signatureRelation',
        ])->where([
            'signature_code'    => $request->signature_code,
            'step'              => $request->step,
        ])->get();
        return response()->json([
            'data'=>$data,  
        ]);    
   }
   public function postValidationSign(Request $request, ValidationSignRequest $validationSignRequest)
   {
       try {
           // Validate and retrieve the validated data
           $validatedData = $validationSignRequest->validated();
   
           // Retrieve necessary data
           $head = SignatureHeader::where('signature_code', $request->signature_code)->first();
           if (!$head) {
               Log::error('No matching signature header found for signature_code: ' . $request->signature_code);
               return ResponseFormatter::error(null, 'No matching signature header found.', 404);
           }
   
           $details = SignatureDetail::where('signature_code', $request->signature_code)
               ->where('user_id', $head->step_approval_id)
               ->get();
   
           if ($details->isEmpty()) {
               Log::error('No matching signature details found for signature_code: ' . $request->signature_code);
               return ResponseFormatter::error(null, 'No matching signature details found.', 404);
           }
   
           // Load the existing PDF attachment
           $nameArray = explode('/', $head->attachment);
           array_shift($nameArray);
           $nameRemove = implode('/', $nameArray);
           $pdfPath = storage_path('app/public/' . $nameRemove);
   
           if (!file_exists($pdfPath)) {
               Log::error('PDF file does not exist at path: ' . $pdfPath);
               return ResponseFormatter::error(null, 'PDF file does not exist.', 404);
           }
   
           // Create an instance of FPDI
           $pdf = new Fpdi();
   
           // Import existing PDF content
           $pageCount = $pdf->setSourceFile($pdfPath);
           $templateIds = [];
           for ($i = 1; $i <= $pageCount; $i++) {
               $templateIds[$i] = $pdf->importPage($i);
   
               // Check orientation of each page and set it accordingly
               $size = $pdf->getTemplateSize($templateIds[$i]);
               if ($size['width'] > $size['height']) {
                   $pdf->AddPage('L', [$size['width'], $size['height']]); // Landscape
                   $imageWidth = 45;
                   $imageHeight = 15;
               } else {
                   $pdf->AddPage('P', [$size['width'], $size['height']]); // Portrait
                   $imageWidth = 30;
                   $imageHeight = 10;
               }
   
               $pdf->useTemplate($templateIds[$i]);
               $pageWidth = $size['width'];
               $pageHeight = $size['height'];
   
               // Check if there are details for this page
               foreach ($details as $row) {
                   if ($row->page_number == $i) {
                       $validation = ApprovalSign::where('user_id', $head->step_approval_id)->first();
                       $signature = MasterSignature::where('user_id', $validation->user_id)->first();
   
                       if ($signature && $signature->signature) {
                           // Decode base64 image
                           $signatureImagePath = $signature->signature;
                           $imageData = explode(',', $signatureImagePath);
                           $mimeType = isset($imageData[0]) ? explode(':', explode(';', $imageData[0])[0])[1] : 'image/png';
                           $mimeToExtension = [
                               'image/jpeg' => 'jpg',
                               'image/png' => 'png',
                               'image/gif' => 'gif',
                               'image/bmp' => 'bmp',
                               'image/webp' => 'webp'
                           ];
                           $fileExtension = isset($mimeToExtension[$mimeType]) ? $mimeToExtension[$mimeType] : 'png';
   
                           // Decode and save the image
                           $base64Image = isset($imageData[1]) ? $imageData[1] : $imageData[0];
                           $decodedImage = base64_decode($base64Image);
                           $directory = storage_path('app/public/storage/sign');
                           $tempImagePath = $directory . '/temp_signature.' . $fileExtension;
   
                           // Ensure the directory exists
                           if (!file_exists($directory)) {
                               mkdir($directory, 0755, true);
                           }
   
                           // Save the decoded image to a file
                           $result = file_put_contents($tempImagePath, $decodedImage);
                           if ($result !== false) {
                               Log::info('File written successfully. Bytes written: ' . $result);
   
                               // Convert web coordinates to PDF coordinates
                               $canvasWidth = 1200;  // Set these according to the actual dimensions of the web canvas
                               $canvasHeight = 800;  // Set these according to the actual dimensions of the web canvas
   
                               // Calculate precision factors for coordinate conversion
                               $xFactor = $pageWidth / $canvasWidth;
                               $yFactor = $pageHeight / $canvasHeight;
   
                               // Convert web coordinates to PDF coordinates with precision
                               $pdfX = $row->x * $xFactor;
                               $pdfY = $row->y * $yFactor;
   
                               // Ensure coordinates are within page bounds
                               if ($pdfX >= 0 && $pdfX <= $pageWidth && $pdfY >= 0 && $pdfY <= $pageHeight) {
                                   // Place the image on the PDF
                                   $pdf->Image($tempImagePath, $pdfX, $pdfY, $imageWidth, $imageHeight);
                                   Log::info('Image placed at: x=' . $pdfX . ', y=' . $pdfY . ' on page ' . $i);
                               } else {
                                   Log::warning('Coordinates are out of page bounds: x=' . $pdfX . ', y=' . $pdfY . ' on page ' . $i);
                               }
                           } else {
                               Log::error('Failed to write file.');
                           }
                       } else {
                           Log::error('No signature or image found for user_id: ' . $validation->user_id);
                       }
                   }
               }
           }
   
           $directory = storage_path('app/public/attachments/sign');
           if (!file_exists($directory)) {
               mkdir($directory, 0755, true);
           }
   
           // Save the updated PDF
           $replaceName = str_replace('/', '-', $request->signature_code);
           $updatedPdfPath = $directory . '/' . $replaceName . date('YmdHis') . '.pdf';
           $pdf->Output($updatedPdfPath, 'F');
   
           // Update the head attachment with the new file path
           $head->attachment = 'storage/attachments/sign/' . $replaceName . '.pdf';
           $head->save();
   
           return ResponseFormatter::success($updatedPdfPath, 'Approver successfully updated');
       } catch (\Throwable $th) {
           Log::error('Throwable: ' . $th->getMessage());
           return ResponseFormatter::error($th->getMessage(), 'Approver failed to update', 500);
       }
   }
   
   
}
