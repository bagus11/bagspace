

@extends('timeline.kanban.admin_kanban')
@section('title', $data->name)
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
<link rel="stylesheet" href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css">

<style>
        .nav-tabs .nav-link {
            color: #F9F2ED;
            height: 40px;
            background-color: #4793AF;
            border-radius: none;
            font-size: 12px; 
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }
        .nav-tabs .nav-link.active {
            color: #FF8A08;
            background-color: #F9F2ED;
            border-color: transparent;
        }
        .dropdown-menu {
            /* background-color: #31363F; */
            border-radius: 15px;
        }
        .list-group {
            /* background-color: #343a40; */
        }

        .list-group-item {
            /* background-color: #343a40; */
            color: black;
            font-size: 11px;
            transition: background-color 0.3s, color 0.3s;
        }

        .list-group-item:hover {
            background-color: #4793AF !important;
            color: white !important;
        }
        .hover:hover{
            color: white !important;
        }
        .card-parent{
            background-color: #DDDDDD !important
        }
</style>
{{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}

<!-- Tab Content -->
<div class="tab-content mx-4 mt-2">
    <div class="tab-pane fade show active" id="kanban" role="tabpanel" aria-labelledby="kanban-tab">
        <div class="justify-content-center row mx-2" style="margin-top:-20px">
            <input type="hidden" id="request_code" value="{{$request_code}}" >
            <input type="hidden" id="status_module" value="" >
            <input type="hidden" name="pc_code_id" id="pc_code_id">
            <input type="hidden" name="leader_id" id="leader_id" value="{{$leader->user_id}}">
            <input type="hidden" id="header_type" value="{{$data->type_id}}">
            <div class="mt-4 mx-4">
                <div id="kanban-board" class="row">
                    <!-- Kanban Columns -->
                    <!-- To Do Column -->
                    <div id="todo" class="col-md-3 kanban-column">
                        <div class="card card-parent" id="parent1">
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
                        <div class="card card-parent" id="parent2">
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
                        <div class="card card-parent" id="parent3">
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
                        <div class="card card-parent" id="parent4">
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
           
            <div class="mt-4 card">
                <div class="card-header p-0 my-1">
                    <div class="card-tools">
                        <button id="export-btn" class="btn btn-sm btn-success" title="" style="float: right">
                            <i class="fa-solid fa-file-excel"></i> Export to Excell
                        </button>
                    </div>
                    
                </div>
                <div class="card-body p-0">
                    <div id="gantt-chart" class="row">
                        <!-- Gantt chart will be rendered here -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div id="gantt_here" style='width:100%; min-height: 600px !important; border-radius:15px !important;'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
        <div class="justify-content-center row mt-2" style="margin-top:-20px">
            <div class="col-12">
                <div class="card" style="border-radius:15px !important;">
                    <div class="card-body" style="border-radius:15px !important;">
                        <b> {{$data->name}}</b> 
                        <div class="ml-2">
                            <div class="row" style="width: 60%">
                                <p>{{$data->description}}</p>
                            </div>
                            <div class="row" style="width: 60%">
                                    <div class="col-6" >
                                        <p>Start Date : {{$data->start_date}}</p>
                                    </div>
                                    <div class="col-6">
                                        <p>End Date : {{$data->end_date}}</p>
                                    </div>
                                
                                    <div class="col-6" style="margin-top:-10px">
                                        @php
                                            $status = 'NEW';
                                            if($data->status == 1){
                                                $status = "In Progress";
                                            }else if($data->status == 2){
                                                $status = "Pending";
                                            }else if($data->status == 3){
                                                $status = "DONE";
                                            }
                                        @endphp
                                        <p>Status : <b>{{$status}}</b></p>
                                    </div>
                                    <div class="col-6" style="margin-top:-10px">
                                        <p>Progress : <b>{{$data->percentage}}%</b></p>
                                    </div>
                            </div>
                            <div class="row mt-2 mx-2">
                                <div class="col-5">
                                    <div class="accordion no-shadow " id="accordionExample" style="border:1px solid #524C42;border-radius:15px !important;max-height:400px !important;overflow-y:auto">
                                    <div id="moduleContainerLabel"></div>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div style="border:1px solid #524C42;border-radius:15px !important;" id="detail_content">
                                        <div id="result_container"></div>
                                        <fieldset class="legend1">
                                            <legend>Log Activity</legend>
                                            <div id="activity_container"></div>
                                        </fieldset>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
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
@include('timeline.kanban.modal.add-daily')
@include('timeline.kanban.modal.detail-model')
@include('timeline.kanban.modal.log-module')
@include('timeline.kanban.modal.add-task')
@include('timeline.kanban.modal.detail-taskModal')
@include('timeline.kanban.modal.edit-task')
@include('timeline.kanban.modal.edit-module')
@include('timeline.kanban.modal.task_done')
@include('timeline.kanban.modal.detail-taskModal')
@endsection
@push('custom-js')
    @include('timeline.kanban.kanban-js')
@endpush
