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
                            <button class="btn btn-sm btn-info mr-2" id="btnRefresh" style="float: right">
                                <i class="fa-solid fa-arrows-rotate"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="datatable-stepper" id="sign_table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="no">No</th>
                                    <th scope="col" class="sort" data-sort="sign">Transaction Sign Number</th>
                                    <th scope="col" class="sort" data-sort="title">Title</th>
                                    <th scope="col" class="sort" data-sort="status">Status</th>
                                    <th scope="col" class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
              
            </div>
        </div>
        @include('sign.sign-modal_create')
        @include('sign.sign-modal_detail')
        @include('sign.approval-sign')
@endsection()
{{-- {{ asset('storage/attachments/sign/1-NHR-VI-24.pdf') }} --}}
@push('custom-js')
    @include('sign.sign_js')
@endpush
