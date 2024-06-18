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
                <div class="card-header">
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
                    <div class="card-body">
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
        </div>
        @include('sign.sign-modal_create')
        @include('sign.sign-modal_detail')
    @endsection()
    @push('custom-js')
        @include('sign.sign_js')
    @endpush
