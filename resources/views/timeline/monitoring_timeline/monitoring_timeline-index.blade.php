@extends('layouts.admin')
@section('title', 'Monitoring Timeline')
@section('content')
<style>
  #container {
     width: 100%;
     height: 300 px !important;
     margin: 0;
     padding: 0;
   }
   #chart_div{
    width: 100% !important;
    height: 100% !important;
   }
</style>
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-ruler-pencil text-danger"></i> Timeline Project</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-atom"></i> Monitoring Timeline</li>
  </ol>
</nav>
<div class="row justify-content-center mx-1">
  <div class="col-md-12">
      <div class="card p-0">
          <div class="card-header pb-0">
            <div class="row">
              <div class="col-3">
                <p class="title-head">Project List</p>
              </div>
              <div class="col-9">
                <button class="btn btn-sm btn-success" id="btn_add_ticket" style="float: right"   data-toggle="modal" data-target="#addTimelineHeader">
                  <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-sm btn-info mr-1" id="btnRefresh" style="float: right">
                  <i class="fa-solid fa-arrows-rotate"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="card-body p-0">
        
              <table class="datatable-stepper" id="timeline_header_table">
                  <thead class="thead-light">
                      <tr>
                          <th scope="col" class="sort" style="text-align: center" data-sort="request_code">Request Code</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="type">Type</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="team">Team</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="status">Status</th>
                          <th scope="col" class="sort" style="text-align: center" data-sort="action">Action</th>
                      </tr>
                  </thead>
              </table>
          </div>
          <div class="card-footer">

          </div>
        </div>
  </div>

</div>


@include('timeline.monitoring_timeline.modal.botTimeline')
@include('timeline.monitoring_timeline.modal.add-timeline_header')
@include('timeline.monitoring_timeline.modal.detail-timeline')
@include('timeline.monitoring_timeline.modal.edit-timeline')
@endsection
@push('custom-js')
    @include('timeline.monitoring_timeline.monitoring_timeline-js')
@endpush
