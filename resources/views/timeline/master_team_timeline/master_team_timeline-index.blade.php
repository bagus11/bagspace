@extends('layouts.admin')
@section('title', 'Master Team Timeline')
@section('content')

<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
    <li class="breadcrumb-item"> <i class="ni ni-ruler-pencil text-danger"></i> Timeline Project</li>
    <li class="breadcrumb-item" aria-current="page"><i class="ni ni-badge"></i> Master Team</li>
  </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-0">
                <div class="card-header">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">Team List</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_role_user" style="float: right"   data-toggle="modal" data-target="#addTeamModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                    <table class="datatable-stepper" id="team_table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" style="text-align: center" data-sort="role"></th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="role">Status</th>
                                <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
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
@include('timeline.master_team_timeline.modal.add-team')
@include('timeline.master_team_timeline.modal.edit-team')
@include('timeline.master_team_timeline.modal.add-detail_team')
@endsection
@push('custom-js')
    @include('timeline.master_team_timeline.master_team_timeline-js')
@endpush
