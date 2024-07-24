@extends('layouts.admin')
@section('content')

<style>
    .description{
        font-size: 10px !important;
    }
</style>

<div class="header pb-6 d-flex align-items-center" style="min-height: 150px; margin-top:-10px !important; background-image: url(../../assets/img/theme/bg.png); background-size: cover; background-position: center top;">

    <span class="mask bg-gradient-default opacity-7"></span>
    
    <div class="container-fluid d-flex align-items-center">
    <div class="row">
    <div class="col-lg-7 col-md-10">
        @php
            $name = explode(' ', auth()->user()->name);
        @endphp
    <h1 class="display-2 text-white">Hello {{$name[0]}}</h1>
    <p class="text-white mt-0 mb-5">This is your profile page. You can see the progress you've made with your work and manage your projects or assigned tasks</p>

    </div>
    </div>
    </div>
    </div>
    
    <div class="container-fluid mt--6">
    <div class="row">
    <div class="col-xl-4 order-xl-2">
    <div class="card card-profile">
    <img src="../../assets/img/theme/icon.png" alt="Image placeholder" class="card-img-top">
    <div class="row justify-content-center">
    <div class="col-lg-3 order-lg-2">
    <div class="card-profile-image">
    <a href="#">
        @php
            $auth= auth()->user()->avatar;
        @endphp
         
    <img src="{{asset('storage/users-avatar/'.$auth)}}" class="rounded-circle">
    </a>
    </div>
    </div>
    </div>
        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
         
        </div>
        <div class="card-body pt-4 ">
            <div class="card-body p-0">
                <div class="text-center" style="font-weight: bold">
                    <span style="font-size: 14px">
                        {{auth()->user()->name}}
                    </span>
                    <span style="font-size: 12px">({{auth()->user()->nik}})</span>
                <div>
                <div class="row pt-0 my-0" style="margin-top: -20px !important">
                    <div class="col">
                        <div class="card-profile-stats d-flex justify-content-center mt-0">
                            <div>
                                <span class="heading" id="project_label">2</span>
                                <span class="description">Project</span>
                            </div>
                            <div>
                                <span class="heading" id="task_label">100</span>
                                <span class="description">Task</span>
                            </div>
                            <div>
                                <span class="heading" id="remaining_label">11</span>
                                <span class="description">Remaining</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0 mb-0">
                <button style="float: right" class="btn btn-sm btn-warning mt-2"  data-toggle="modal" data-target="#changePasswordModal" title="Change Password">
                    <i class="fas fa-key"></i>
                </button>
            </div>
        </div>
    </div>
    </div>
    </div>
    
    <div class="card">
        <div class="card-header pb-0">
          <table style="width: 100%">
            <tr>
              <td style="width: 90%">
                <label style="font-size: 13px;font-weight:bold">Project Track</label>
              </td>
              <td>
                <i class="ni ni-ruler-pencil text-danger " style="font-size: 25px"></i>
              </td>
            </tr>
          </table>
        </div>
        <div class="card-body">
              <ul class="list-group list-group-flush list my--3" id="progress_track_container">
              </ul>
        </div>
    </div>
        </div>
        <div class="col-xl-8 order-xl-1">
        <div class="row">
        <div class="col-lg-6">
            <div class="card bg-gradient-info border-0">
            
                <div class="card-body">
                    <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total traffic</h5>
                                <span class="h2 font-weight-bold mb-0 text-white">350,897</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                                    <i class="ni ni-active-40"></i>
                                </div>
                            </div>
                    </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap text-light">Since last month</span>
                        </p>
                </div>
            </div>
        </div>
            
                <div class="col-lg-6">
                <div class="card bg-gradient-danger border-0">
                
                <div class="card-body">
                <div class="row">
                <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0 text-white">Performance</h5>
                <span class="h2 font-weight-bold mb-0 text-white">49,65%</span>
                </div>
                <div class="col-auto">
                <div class="icon icon-shape bg-white text-dark rounded-circle shadow">
                <i class="ni ni-spaceship"></i>
                </div>
                </div>
                </div>
                <p class="mt-3 mb-0 text-sm">
                <span class="text-white mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                <span class="text-nowrap text-light">Since last month</span>
                </p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
    <div class="card-header">
        <table style="width: 100%">
            <tr>
              <td style="width: 90%">
                <label style="font-size: 13px;font-weight:bold">Daily Activity</label>
              </td>
              <td>
                <i class="ni ni-calendar-grid-58 text-info " style="font-size: 25px"></i>
              </td>
            </tr>
          </table>
    </div>
    <div class="card-body">
    <div class="pl-lg-4">
        <div class="row">
        
        </div>
       
    </div>
    <hr class="my-4" />
    
    </div>
    </div>
    @include('setting.account.modal.change-password')
@endsection
@push('custom-js')
@include('setting.account.setting_account-js')
@endpush
