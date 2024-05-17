@extends('layouts.admin')
@section('title', 'Master Category Type')
@section('content')

<nav aria-label="breadcrumb" class="mx-3" style="font-size: 12px !important;">
  <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
    <li class="breadcrumb-item"> <i class="ni ni-ruler-pencil text-danger"></i> Timeline Project</li>
    <li class="breadcrumb-item" aria-current="page"><i class="ni ni-briefcase-24"></i> Master Category</li>
  </ol>
</nav>
<div class="row mx-2">
  <div class="col-12">
    <div class="card">
        <div class="card-header">
            <b style="font-size: 14px"> Category List</b>
            <div class="card-tools">
                <button class="btn btn-sm btn-success" id="btn_add_category" style="float: right"   data-toggle="modal" data-target="#addCategoryModal">
                    <i class="fas fa-plus"></i>
                  </button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="datatable-stepper" id="category_table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="sort" style="text-align: center" data-sort="role"></th>
                        <th scope="col" class="sort" style="text-align: center" data-sort="role">Status</th>
                        <th scope="col" class="sort" style="text-align: center" data-sort="name">Type</th>
                        <th scope="col" class="sort" style="text-align: center" data-sort="name">Name</th>
                        <th scope="col" class="sort" style="text-align: center" data-sort="action">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
  </div>
</div>
@include('timeline.master_category.modal.add-category')
@include('timeline.master_category.modal.edit-category')
@endsection
@push('custom-js')
    @include('timeline.master_category.master_category_timeline-js')
@endpush
