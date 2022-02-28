

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" onclick="ChangeLang(event)" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="d-flex flex-row" >
                    <span class="mr-2">
                        <img src="{{Session::get('lang_icon')}}" width="28" height="20" alt="flag">
                    </span>
                    <span class="mr-2 d-none d-lg-inline font-weight-bold text-dark text-xl" >{{Session::get('lang_name')}}</span>
                </div>
            </a>
            <!-- Dropdown - User Information -->
        </li>
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        @auth
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-3 d-flex justify-content-center align-items-center">
                    <i class="fa fa-user-tie text-primary" style="font-size: 1.5rem"></i>
                </span>
                <span class="d-none d-lg-inline text-dark font-weight-bold text-xl">{{ Auth::user()->name }}</span>

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400" onclick="OpenLogOutModal(event)"></i>
                    {{trans('common.auth_logout_label')}}
                </a>
            </div>
        </li>
        @endauth
    </ul>
</nav>



