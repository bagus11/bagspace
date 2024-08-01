
@extends('sign.layout.admin-sign')
@section('title', 'Sign')
@section('content')
<fieldset class="mx-2">
    <legend>Set Signature Field Here</legend>
    <div class="row">
        <input type="hidden" id="attachment" value="{{ asset($head->attachment) }}">
        <div class="col-6">
            <canvas id="pdf-canvas" style="border:1px solid #4793AF; border-radius:15px;width:100%;min-height:600px"></canvas>
            <div class="row mt-2">
                <div class="col-12 d-flex">
                    <button class="btn-sm btn btn-info" id="prev-page">
                        <i class="fa-solid fa-arrow-left"></i>
                    </button>
                    <button class="btn-sm btn btn-info" id="next-page">
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12  d-flex justify-content-end">
                    <form id="signature-form" action="/save-signature" method="POST">
                        <input type="hidden" name="signature" id="signature-input">
                        <button class="btn btn-sm btn-success" type="submit">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <fieldset>
                <legend>Detail Signature Content</legend>
                <ul class="list-group list-group-flush list p-0" id="user_container">
                
                </ul>
            </fieldset>
        </div>
    </div>
</fieldset>
@include('sign.approval_sign.sign-approval')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
@include('sign.approval_sign.approval_sign-js')


@endsection