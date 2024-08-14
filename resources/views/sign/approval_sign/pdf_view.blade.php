
@extends('sign.layout.admin-sign')
@section('title', 'Sign')
@section('content')
<fieldset class="mx-2">
    <legend>Set Signature Field Here</legend>
    <div class="row">
        <input type="hidden" id="attachment" value="{{ asset($head->attachment) }}">
        <input type="hidden" id="signature_code" value="{{$head->signature_code}}">
        <div class="col-8" id="canvas_layout">
            <canvas id="pdf-canvas" style="border:1px solid #4793AF; border-radius:15px;width:100%;"></canvas>
            <div class="row mt-2">
                <div class="col-12 d-flex justify-content-end">
                    <button class="btn-sm btn btn-info" id="prev-page">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="btn-sm btn btn-info" id="next-page">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-4">
            <fieldset class="p-0">
                <legend>Detail Signature Content</legend>
                <ul class="list-group list-group-flush list p-0" id="user_container"></ul>
                <div class="row mt-2 mb-2 mr-2" id="send_container">
                    <div class="col-12 d-flex justify-content-end">
                        <input type="hidden" name="signature" id="signature-input">
                        <button class="btn btn-sm btn-success" type="click" id="btn_send">
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</fieldset>
@include('sign.approval_sign.sign-approval')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
@include('sign.approval_sign.approval_sign-js')


@endsection