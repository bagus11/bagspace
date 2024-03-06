@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">Role</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_role_user" style="float: right"   data-toggle="modal" data-target="#addRoleUserModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                    <table class="datatable-stepper" id="role_user_table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="sort" data-sort="name">Name</th>
                                <th scope="col" class="sort" data-sort="role">Role</th>
                                <th scope="col" class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">Permission</p>
                    </div>
                    <div class="col-9">
                    </div>
                  </div>
                </div>
                  <div class="card-body">
                    <table class="datatable-stepper" id="role_permission_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>
@include('setting.user_access.modal.add_roleUser')
@include('setting.user_access.modal.edit_roleUser')
@include('setting.user_access.modal.add_rolePermission')
@include('setting.user_access.modal.edit_rolePermission')
@endsection
@push('custom-js')
    @include('setting.user_access.user_access-js')
@endpush
