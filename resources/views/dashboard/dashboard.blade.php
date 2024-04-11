@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content">
        <div class="col-md-4" id="approver_container">
            <div class="card">
                <div class="card-header pb-0">
                  <table style="width: 100%">
                    <tr>
                      <td style="width: 90%">
                        <label style="font-size: 13px;font-weight:bold"> Approval List</label>
                      </td>
                      <td>
                        <i class="ni ni-circle-08 " style="font-size: 25px"></i>
                      </td>
                    </tr>
                  </table>
                </div>
                <div class="card-body p-0">
                  <table class="datatable-stepper" id="approver_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" style="text-align: center" class="sort" data-sort="name">Meeting ID</th>
                            <th scope="col" style="text-align: center" class="sort" data-sort="name">Action</th>
                        </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>

</div>
@include('dashboard.modal.approver')
@endsection
@push('custom-js')
    @include('dashboard.dashboard-js')
@endpush