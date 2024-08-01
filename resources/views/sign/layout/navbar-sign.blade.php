<nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom" style="height: 50px; background-color : #4793AF !important">
    <div class="container-fluid">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
      <img src="{{asset('icon-white.png')}}" width="100px" alt="">
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center  ml-md-auto ">
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