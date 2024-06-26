@extends('layouts.admin')
@section('content')
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-planet text-info"></i> Booking Room</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-circle-08"></i> Master Approval</li>
  </ol>
</nav>

    <div class="row justify-content-center mx-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">List Approval</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_approver" style="float: right"   data-toggle="modal" data-target="#addApprover">
                        <i class="fas fa-plus"></i>
                      </button>
                      <button class="btn btn-sm btn-info mr-1" style="float: right"  id="btnRefresh">
                        <i class="fas fa-refresh"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                    <table class="datatable-stepper" id="approver_table">
                        <thead class="thead-light">
                            <tr>
                                <th  style="text-align: center">No</th>
                                    <th  style="text-align: center">Approval ID</th>
                                    <th  style="text-align: center">Location</th>
                                    <th  style="text-align: center">Step Approval</th>
                                    <th  style="text-align: center">Action</th>
                            </tr>
                        </thead>
                      </table>
                </div>
            </div>
        </div>
    </div>

@include('booking.approval.modal.edit-approval')
@include('booking.approval.modal.add-approval')
@include('booking.approval.modal.step-approval')
@endsection
@push('custom-js')
@include('booking.approval.approval-js')
@endpush
