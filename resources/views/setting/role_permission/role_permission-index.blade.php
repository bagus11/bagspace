@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p>Role</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_role" style="float: right"   data-toggle="modal" data-target="#addRoleModal">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table align-items-center" id="roles_table">
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
                      <p>Permission</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_permission" style="float: right">
                        <i class="fas fa-plus"></i>
                      </button>
                    </div>
                  </div>
                </div>
                  <div class="card-body">
                    <table class="table align-items-center" id="permission_table">
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
