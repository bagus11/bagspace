@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<style>
  .divider:after,
  .divider:before {
    content: "";
    flex: 1;
    height: 1px;
    background: #eee;
  }
  .checkbox-container {
    display: flex;
    justify-content: center;
    align-items: center;
}

.is_checked {
    border-radius: 5px !important;
}


</style>
<div class="row justify-content mx-2 mt-2">
  <div class="col-md-8">
    <div class="card ">
      <div class="card-header"> 
          <ul class="nav nav-tabs card-header-tabs pull-right"  id="myTab" role="tablist" >
              <li class="nav-item" style="border-top-left-radius: 15px !important">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" style="font-size: 12px; font-family:Poppins !important" aria-controls="home" aria-selected="true">Project</a>
              </li>
              <li class="nav-item" style="border-top-right-radius: 15px !important">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" style="font-size: 12px; font-family:Poppins !important" aria-controls="profile" aria-selected="false">Daily Activity</a>
              </li>
          </ul>
      </div>
    
      <div class="card-body">
          <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mb-0">
                  <div class="row">
                    <div class="col-12">
                      <select name="select_project"  class="form-control select2" style="float: right" id="select_project"></select>
                    </div>
                  </div>
                </div>
                <ul class="list-group list-group-flush list p-0" id="task_container">
                
                </ul>
              </div>
              <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="row p-0 mb-2">
                  <div class="col-12">
                    <button class="btn btn-sm btn-danger ml-2" style="float: right" onclick="reportDaily(12)" title="Export To PDF">
                      <i class="fas fa-file"></i>
                    </button>
                    <button class=" btn btn-sm btn-success" style="float: right" id="btn_add_daily" title="Daily Activity"  data-toggle="modal" data-target="#addDailyModal">
                      <i class="fa-solid fa-plus"></i>
                    </button>
                  </div>
                </div>
                <ul class="list-group list-group-flush list p-0" id="daily_container">
                
                </ul>
              </div>
             
          </div>
      </div>
    </div>
 </div>
 
  <div class="col-md-4">
    <div class="row">
      <div class="col-md-12" >
        <div class="card">
              <div class="card-header pb-0">
                <table style="width: 100%">
                  <tr>
                    <td style="width: 90%">
                      <label style="font-size: 13px;font-weight:bold">Project Track</label>
                    </td>
                    <td>
                      <i class="ni ni-ruler-pencil text-danger " style="font-size: 25px"></i>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="card-body">
                    <ul class="list-group list-group-flush list my--3" id="progress_track_container">
                    </ul>
              </div>
          </div>
      </div>
      <div class="col-md-12" id="approver_container">
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
  </div>

@include('dashboard.modal.approver')
@include('dashboard.modal.detail_daily')
@include('dashboard.modal.add-signature')
@include('dashboard.modal.detail-timeline')
@include('dashboard.modal.daily_activity')
@endsection
@push('custom-js')
    @include('dashboard.dashboard-js')
    @include('dashboard.timeline-js')
    @include('dashboard.signature-js')
@endpush