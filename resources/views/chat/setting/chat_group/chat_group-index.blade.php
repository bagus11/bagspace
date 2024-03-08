@extends('layouts.admin')
@section('content')
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-chat-round text-success"></i> Chat</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-money-coins"></i> Setting Chat Group</li>
  </ol>
</nav>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">List Group</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_group" style="float: right"   data-toggle="modal" data-target="#addGroupModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="datatable-stepper" id="group_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Code</th>
                            <th scope="col" class="sort" data-sort="name">Name</th>
                            <th scope="col" class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include('chat.setting.chat_group.modal.add-group')
@include('chat.setting.chat_group.modal.edit-group')
@include('chat.setting.chat_group.modal.update-group')
@endsection
@push('custom-js')
@include('chat.setting.chat_group.chat_group-js')
@endpush
