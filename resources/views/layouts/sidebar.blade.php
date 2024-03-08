<aside class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header align-items-center">
          <a class="navbar-brand" href="javascript:void(0)">
              <img src="{{asset('icon.png')}}" class="navbar-brand-img" alt="...">
          </a>
      </div>
      <!-- Sidebar items -->
      <div class="navbar-inner">
          <!-- Collapse -->
          <div class="collapse navbar-collapse" id="sidenav-collapse-main">
              <ul class="navbar-nav">
                @php
                $menus = DB::table('menu')
                    ->join('permissions', 'permissions.name','=','menu.permission_name')
                    ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                    ->join('roles', 'roles.id','role_has_permissions.role_id')
                    ->join('model_has_roles', 'model_has_roles.role_id', 'roles.id')
                    ->select('menu.*')
                    ->where('status',1)
                    ->where('model_has_roles.model_id', auth()->user()->id)
                    ->orderBy('order','asc')
                    ->get();
            @endphp

            @foreach ($menus as $item)
                @if($item->type == 1)
                   
                    <li class="nav-item">
                      <a class="nav-link" href="{{$item->link}}">
                        <i class="{{$item->icon}}"></i>
                        <span class="nav-link-text" style="font-family: Poppins;font-size:11px;margin-top:10px">{{$item->name}}</span>
                      </a>
                    </li>
                @else
                
                  <li class="nav-item">
                        @php
                            $submenus = DB::table('submenu')->select('submenu.*')
                                    ->join('permissions','permissions.name','=','submenu.permission_name')
                                    ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                                    ->join('roles', 'roles.id','role_has_permissions.role_id')
                                    ->join('model_has_roles', 'model_has_roles.role_id', 'roles.id')
                                    ->where('submenu.id_menu', $item->id)
                                    ->where('submenu.status', 1)
                                    ->where('model_has_roles.model_id', auth()->user()->id)
                                    ->orderBy('order','asc')
                                    ->get();
                        @endphp
                          <a class="nav-link" href="#navbar-{{$item->link}}" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-{{$item->link}}">
                          <i class="{{$item->icon}}"></i>
                              <span class="nav-link-text" style="font-family: Poppins;font-size:11px;margin-top:10px">{{$item->name}}</span>
                          </a>
                        <div class="collapse" id="navbar-{{$item->link}}">
                          <ul class="nav nav-sm flex-column">
                            @foreach ($submenus as $row)
                              <li class="nav-item">
                                <a href="{{$row->link}}" class="nav-link">
                                  <i class="ni ni-{{$row->icon}}"></i>
                                <span class="sidenav-normal" style="font-family: Poppins;font-size:11px;margin-top:10px"> {{$row->name}} </span>
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                    </li>   
                @endif
            @endforeach
                  <!-- Dashboard Link -->
                  <!-- End Dropdown Example -->
              </ul>
          </div>
      </div>
  </div>
</aside>