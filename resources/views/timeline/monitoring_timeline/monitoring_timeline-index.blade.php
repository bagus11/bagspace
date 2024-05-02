@extends('layouts.admin')
@section('title', 'Monitoring Timeline')
@section('content')

<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-ruler-pencil text-danger"></i> Timeline Project</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-atom"></i> Monitoring Timeline</li>
  </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
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
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
              
                    <table class="datatable-stepper" id="timeline_header_table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="text-align: center" data-sort="request_code">Request Code</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="office">Office</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="office">Team</th>
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
</div>
@include('timeline.monitoring_timeline.modal.add-timeline_header')
@include('timeline.monitoring_timeline.modal.detail-timeline')
@include('timeline.monitoring_timeline.modal.edit-timeline')
@endsection
@push('custom-js')
    @include('timeline.monitoring_timeline.monitoring_timeline-js')
@endpush
