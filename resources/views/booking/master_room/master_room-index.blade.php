@extends('layouts.admin')
@section('content')
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-planet text-info"></i> Booking Room</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-box-2"></i> Master Room</li>
  </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">List Room</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_room" style="float: right"   data-toggle="modal" data-target="#addMasterRoomModal">
                        <i class="fas fa-plus"></i>
                      </button>
                      <button class="btn btn-sm btn-info mr-1" style="float: right"  id="btnRefresh">
                        <i class="fas fa-refresh"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="datatable-stepper" id="master_room_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Status</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Location</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="action">Action</th>
                        </tr>
                    </thead>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('booking.master_room.modal.edit-master_room')
@include('booking.master_room.modal.add-master_room')
@endsection
@push('custom-js')
@include('booking.master_room.master_room-js')
@endpush
