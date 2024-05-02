

@extends('timeline.kanban.admin_kanban')
@section('title', 'Project')
@section('content')
<div class="justify-content-center row mx-2">
    <input type="hidden" id="request_code" value="{{$request_code}}" >
    <input type="hidden" id="status_module" value="" >
        <div class="mt-4 mx-4">
          <div id="kanban-board" class="row">
            <div id="todo" class="col kanban-column">
              <div class="card bg-dark card-parent">
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
        
            <div id="in-progress" class="col kanban-column">
                <div class="card bg-dark card-parent">
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
        
            <div id="pending" class="col kanban-column">
                <div class="card bg-dark card-parent">
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
       

        <div id="done" class="col kanban-column">
            <div class="card bg-dark card-parent">
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


{{-- <style>
    .kanban-column{
      min-width: 300px !important;
    }
  </style> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.6.6/dragula.min.js" integrity="sha512-MrA7WH8h42LMq8GWxQGmWjrtalBjrfIzCQ+i2EZA26cZ7OBiBd/Uct5S3NP9IBqKx5b+MMNH1PhzTsk6J9nPQQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
@include('timeline.kanban.modal.add-model')
@include('timeline.kanban.modal.detail-model')
@include('timeline.kanban.modal.add-task')
@endsection
@push('custom-js')
    @include('timeline.kanban.kanban-js')
@endpush
