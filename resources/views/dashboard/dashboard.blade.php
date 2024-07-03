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
    <div class="card">
     <div class="card-header pb-0">
      <label style="font-size: 13px;font-weight:bold">Task List</label>
      <div class="card-tools">
        <div class="row">
          <div class="col-10">
            <select name="select_project"  class="form-control select2" id="select_project"></select>
          </div>
          <div class="col-2 mt-1">
            <button class=" btn btn-sm btn-default" style="float: right" title="Daily Activity">
              <i class="fa-solid fa-book"></i>
            </button>
          </div>
        </div>
      </div>
     </div>
       <div class="card-body p-0" style="height: 500px; overflow-y :auto;overflow-x: rever !important;">
         <ul class="list-group list-group-flush list p-0" id="task_container">
            
         </ul>
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
@include('dashboard.modal.add-signature')
@include('dashboard.modal.detail-timeline')
@endsection
@push('custom-js')
    @include('dashboard.dashboard-js')
    @include('dashboard.timeline-js')
    @include('dashboard.signature-js')
@endpush