@extends('layouts.admin')
@section('title', 'Digital Sign Transaction')
@section('content')
    <nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item"> <i class="ni ni-paper-diploma text-warning"></i> Digital Sign</li>
            {{-- <li class="breadcrumb-item" aria-current="page"><i class="ni ni-key-25"></i> Role & Permission</li> --}}
        </ol>
    </nav>
    <div class="container-fluid">
        <div class="justify-content-center">
            <div class="card">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="list-sign" data-toggle="tab" data-target="#list-sign-pane"
                            type="button" role="tab" aria-controls="list-sign-pane" aria-selected="true">List
                            Sign</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="approve-sign" data-toggle="tab" data-target="#approve-sign-pane"
                            type="button" role="tab" aria-controls="approve-sign-pane" aria-selected="false">Approve
                            Sign</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="list-sign-pane" role="tabpanel" aria-labelledby="list-sign"
                        tabindex="0">
                        <div class="card-header" id="list_sign_transaction" style="padding: 1.0rem !important;">
                            <div class="row">
                                <div class="col-3">
                                    <p class="title-head">Sign Transaction</p>
                                </div>
                                <div class="col-9">
                                    <button class="btn btn-sm btn-success" id="btn_add_sign" style="float: right"
                                        data-toggle="modal" data-target="#addSignModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" style="padding: 1rem !important;">
                                <table class="datatable-stepper" id="sign_table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="no">No</th>
                                            <th scope="col" class="sort" data-sort="sign">Transaction Sign Number</th>
                                            <th scope="col" class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="approve-sign-pane" role="tabpanel" aria-labelledby="approve-sign"
                        tabindex="0">
                        <div class="card-header" id="list_approve_sign_transaction" style="padding: 1.0rem !important;">
                            <div class="row">
                                <div class="col-3">
                                    <p class="title-head">Approve Sign</p>
                                </div>
                                {{-- <div class="col-9">
                                    <button class="btn btn-sm btn-success" id="btn_add_sign" style="float: right"
                                        data-toggle="modal" data-target="#">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div> --}}
                            </div>
                            <div class="card-body" style="padding: 1rem !important;">
                                <table class="datatable-stepper" id="approve_sign_table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="sort" data-sort="no">No</th>
                                            <th scope="col" class="sort" data-sort="sign">Transaction Sign Number</th>
                                            <th scope="col" class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('sign.sign-modal_create')
        @include('sign.sign-modal_detail')
@endsection()
{{-- {{ asset('storage/attachments/sign/1-NHR-VI-24.pdf') }} --}}
@push('custom-js')
    @include('sign.sign_js')
@endpush
