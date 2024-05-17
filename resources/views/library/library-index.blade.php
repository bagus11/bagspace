@extends('layouts.admin')
@section('content')
<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
  <li class="breadcrumb-item"> <i class="ni ni-planet text-info"></i> Library</li>
  </ol>
</nav>

    <div class="row justify-content-center mx-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                  <div class="row">
                    <div class="col-3">
                      <p class="title-head">List</p>
                    </div>
                    <div class="col-9">
                      <button class="btn btn-sm btn-success" id="btn_add_book" style="float: right"   data-toggle="modal" data-target="#addBookModal">
                        <i class="fas fa-plus"></i>
                      </button>
                      <button class="btn btn-sm btn-info mr-1" style="float: right"  id="btnRefresh">
                        <i class="fas fa-refresh"></i>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <table class="datatable-stepper" id="library_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Created At</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Ticket Code</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Location</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Department</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="name">Title</th>
                            <th scope="col" class="sort" style="text-align: center" data-sort="action">Action</th>
                        </tr>
                    </thead>
                  </table>
                </div>
            </div>
        </div>
    </div>
@include('library.modal.add-library')
@include('library.modal.detail-library')
@include('library.modal.edit-library')
@endsection
@push('custom-js')
@include('library.library-js')
@endpush
