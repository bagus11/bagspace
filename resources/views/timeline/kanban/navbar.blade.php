<nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom" style="height: 50px; background-color : #4793AF !important">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
      <img src="{{asset('icon-white.png')}}" width="100px" alt="">
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center  ml-md-auto ">
        </ul>
        <ul class="nav nav-tabs mx-4 mt-2" role="tablist" style="border-bottom: none;">
          <li class="nav-item">
              <a class="nav-link active" id="kanban-tab" data-toggle="tab" href="#kanban" role="tab" aria-controls="kanban" aria-selected="true">Kanban</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="gantt-tab" data-toggle="tab" href="#gantt" role="tab" aria-controls="gantt" aria-selected="false">Gantt Chart</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="gantt-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Detail Information</a>
          </li>
          <li class="nav-item">
            <div class="btn-group" style="float:right">
              <button type="button" class="btn btn-sm btn-tool dropdown-toggle px-2" id="btn_history_remark" title="Participant" style="margin-top:3px" data-toggle="dropdown">
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
          </li>
      </ul>
        <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
          <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="media align-items-center">
                <span class="avatar avatar-sm rounded-circle">
                 @php
                     $auth= auth()->user()->avatar;
                 @endphp
                  <img alt="Image placeholder" src="{{asset('storage/users-avatar/'.$auth)}}">
                </span>
                <div class="media-body  ml-2  d-none d-lg-block">
              
                </div>
              </div>
            </a>
            <div class="dropdown-menu  dropdown-menu-right">
              <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Welcome {{auth()->user()->name}}</h6>
              </div>
             
              <a href="#!" class="dropdown-item" style="font-size: 10px !important">
                <i class="ni ni-settings-gear-65"></i>
                <span>Settings</span>
              </a>
              <a href="#!" class="dropdown-item" style="font-size: 10px !important">
                <i class="ni ni-calendar-grid-58"></i>
                <span>Activity</span>
              </a>
         
              <form id="logout-form" method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="ni ni-user-run"></i>
                  <span style="font-size: 10px !important">Logout</span>
                </a>
                <button type="submit" style="display: none;"></button>
            </form>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>