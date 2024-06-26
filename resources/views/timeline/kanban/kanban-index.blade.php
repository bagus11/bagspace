

@extends('timeline.kanban.admin_kanban')
@section('title', $data->name)
@section('content')
<style>
        .nav-tabs .nav-link {
            color: white;
            background-color: #343a40;
            border-color: #343a40;
            font-size: 12px; 
        }
        .nav-tabs .nav-link.active {
            color: black;
            background-color: #EEEEEE;
            border-color: #EEEEEE;
        }
        .dropdown-menu {
            background-color: #31363F;
            border-radius: 15px;
        }
</style>
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
<div class="row mx-4 mt-2 bg-dark" style="padding:10px;border-radius:15px">
    
    <div class="col-8 mt-2" style="font-size: 16px;color:white;">
        <b> {{$data->name}}</b> 
    </div>
    <div class="col-3" style="padding-right: 0;margin-right: -10%">
        <ul class="nav nav-tabs mx-4 mt-2" role="tablist" style="border-bottom: 1px solid #444;">
            <li class="nav-item">
                <a class="nav-link active" id="kanban-tab" data-toggle="tab" href="#kanban" role="tab" aria-controls="kanban" aria-selected="true">Kanban</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="gantt-tab" data-toggle="tab" href="#gantt" role="tab" aria-controls="gantt" aria-selected="false">Gantt Chart</a>
            </li>
        </ul>
    </div>
    <div class="col-1">
        <input type="hidden" id="header_type" value="{{$data->type_id}}">
        <div class="btn-group" style="float:right">
            <button type="button" class="btn btn-sm btn-tool btn-dark dropdown-toggle px-2" id="btn_history_remark" title="Participant" style="margin-top:3px" data-toggle="dropdown">
                <i class="fa-solid fa-users"></i>
            </button>
           
            <input type="hidden" name="pc_code_id" id="pc_code_id">
            <input type="hidden" name="leader_id" id="leader_id" value="{{$leader->user_id}}">
            <div class="dropdown-menu dropdown-menu-right"  role="menu" style="width: 250px !important;border-radius:15px;background-color:#31363F">
                
                @foreach ($team as $item)
                @php
                    $avatar = 'storage/users-avatar/'.$item->userRelation->avatar;
                @endphp
                {{-- {{$avatar}} --}}
                <div class="row align-items-center mb-2 mx-2">
                    <div class="col-auto">
                      <!-- Avatar -->
                      <img alt="Image placeholder" src="{{URL::asset($avatar)}}" class="avatar rounded-circle">
                    </div>
                    <div class="col ml--2">
                      <div class="d-flex justify-content-between align-items-center">
                        <div>
                          <h4 class="mb-0 text-sm" style="color: white;font-size:12px !important">{{$item->userRelation->name}}</h4>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>
        </div>
    </div>
  
  
</div>
<!-- Tab Content -->
<div class="tab-content mx-4 mt-2">
    <div class="tab-pane fade show active" id="kanban" role="tabpanel" aria-labelledby="kanban-tab">
        <div class="justify-content-center row mx-2" style="margin-top:-20px">
            <input type="hidden" id="request_code" value="{{$request_code}}" >
            <input type="hidden" id="status_module" value="" >
            <div class="mt-4 mx-4">
                <div id="kanban-board" class="row">
                    <!-- Kanban Columns -->
                    <!-- To Do Column -->
                    <div id="todo" class="col-md-3 kanban-column">
                        <div class="card bg-dark card-parent" id="parent1">
                            <div class="row mt-1 mb-0">
                                <div class="col-9">
                                    <b class="b-head ml-4 mt-2">To Do</b>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-sm radius mx-2 mb-1 btn_module" title="Create Module Here" id="btn_new_module" data-toggle="modal" data-target="#addCardModal" style="float: right;">
                                        <i class="fas fa-plus"></i>
                                   </button>
                                </div>
                            </div>
                            <div class="card-body kanban-cards p-2" id="kanban_new"></div>
                        </div>
                    </div>
                    <!-- In Progress Column -->
                    <div id="in-progress" class="col-md-3 kanban-column">
                        <div class="card bg-dark card-parent" id="parent2">
                            <div class="row mt-1 mb-0">
                                <div class="col-9">
                                    <b class="b-head ml-4 mt-2">In Progress</b>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-sm radius mx-2 mb-1 btn_module" title="Create Module Here" id="btn_on_progress_module" data-toggle="modal" data-target="#addCardModal" style="float: right;">
                                        <i class="fas fa-plus"></i>
                                   </button>
                                </div>
                            </div>
                            <div class="card-body kanban-cards p-2" id="kanban_progress"></div>
                        </div>
                    </div>
                    <!-- Pending Column -->
                    <div id="pending" class="col-md-3 kanban-column">
                        <div class="card bg-dark card-parent" id="parent3">
                            <div class="row mt-1 mb-0">
                                <div class="col-9">
                                    <b class="b-head ml-4 mt-2">Pending</b>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-sm radius mx-2 mb-1 btn_module" title="Create Module Here" id="btn_pending_module" data-toggle="modal" data-target="#addCardModal" style="float: right;">
                                        <i class="fas fa-plus"></i>
                                   </button>
                                </div>
                            </div>
                            <div class="card-body kanban-cards p-2" id="kanban_pending"></div>
                        </div>
                    </div>
                    <!-- Done Column -->
                    <div id="done" class="col-md-3 kanban-column">
                        <div class="card bg-dark card-parent" id="parent4">
                            <div class="row mt-1 mb-0">
                                <div class="col-9">
                                    <b class="b-head ml-4 mt-2">Done</b>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-sm radius mx-2 mb-1 btn_module" title="Create Module Here" id="btn_done_module"  data-toggle="modal" data-target="#addCardModal" style="float: right;">
                                        <i class="fas fa-plus"></i>
                                   </button>
                                </div>
                            </div>
                            <div class="card-body kanban-cards p-2" id="kanban_done"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gantt Chart Content -->
    <div class="tab-pane fade" id="gantt" role="tabpanel" aria-labelledby="gantt-tab">
        <div class="justify-content-center row p-0" style="margin-top:-20px">
            <input type="hidden" id="request_code" value="{{$request_code}}" >
            <input type="hidden" id="status_module" value="" >
            <div class="mt-4">
                <div id="gantt-chart" class="row">
                    <!-- Gantt chart will be rendered here -->
                    <div id="gantt_here" style='width:100%; min-height: 600px !important; border-radius:15px !important;'></div>
                    {{-- <div class="col-12">
                        <div class="card bg-dark">
                            <div class="card-body">
                               
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Card Modal (same as before, not included for brevity) -->


{{-- <style>
    .kanban-column{
      min-width: 300px !important;
    }
  </style> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" integrity="sha512-MrA7WH8h42LMq8GWxQGmWjrtalBjrfIzCQ+i2EZA26cZ7OBiBd/Uct5S3NP9IBqKx5b+MMNH1PhzTsk6J9nPQQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
@include('timeline.kanban.modal.add-model')
@include('timeline.kanban.modal.detail-model')
@include('timeline.kanban.modal.log-module')
@include('timeline.kanban.modal.add-task')
@include('timeline.kanban.modal.detail-taskModal')
@include('timeline.kanban.modal.edit-task')
@include('timeline.kanban.modal.edit-module')
@include('timeline.kanban.modal.detail-taskModal')
@endsection
@push('custom-js')
    @include('timeline.kanban.kanban-js')
@endpush
