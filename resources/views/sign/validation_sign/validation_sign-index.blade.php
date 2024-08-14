
@extends('sign.validation_sign.validation-index')
@section('title', 'Sign')
@section('content')
<fieldset class="mx-2">
    <legend>Set Signature Field Here</legend>
    <div class="row d-flex justify-content-center">
        <input type="hidden" id="attachment" value="{{asset($head->attachment) }}">
        <input type="hidden" id="step" value="{{$head->step_approval_id}}">
        <input type="hidden" id="signature_code" value="{{$head->signature_code}}">
        <div class="col-8">
            <canvas id="pdf-canvas" style="border:1px solid #4793AF; border-radius:15px;width:100%;"></canvas>
            <div class="row mt-2">
                <div class="col-10">
                    <button class="btn-sm btn btn-info" id="prev-page">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="btn-sm btn btn-info" id="next-page">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
                <div class="col-2 d-flex justify-content-end">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#validationModal">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</fieldset>

@include('sign.validation_sign.modal.validation-modal')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sf-bootstrap-pincode-input@1.5.0/js/bootstrap-pincode-input.min.js"></script>

@include('sign.validation_sign.validation_sign-js')


@endsection