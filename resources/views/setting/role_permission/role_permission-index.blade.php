@extends('layouts.admin')
@section('content')
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-settings text-warning"></i> Setting</li>
  <li class="breadcrumb-item" aria-current="page"><i class="ni ni-key-25"></i> Role & Permission</li>
  </ol>
</nav>
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
                      <button class="btn btn-sm btn-success" id="btn_add_role" style="float: right"   data-toggle="modal" data-target="#addRoleModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="datatable-stepper" id="roles_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" data-sort="name">Name</th>
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
                      <button class="btn btn-sm btn-success" id="btn_add_permission" style="float: right"   data-toggle="modal" data-target="#addPermissionModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                  <div class="card-body p-0">
                    <table class="datatable-stepper" id="permission_table">
                      <thead class="thead-light">
                          <tr>
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
</div>
@include('setting.role_permission.modal.add_roles')
@include('setting.role_permission.modal.edit_roles')
@include('setting.role_permission.modal.add_permission')
@endsection
@push('custom-js')
    @include('setting.role_permission.role_permission-js')
@endpush
