<!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-light">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="collapse navbar-collapse show" id="navbar-mobile">
                    <ul class="nav navbar-nav mr-auto float-left">

                        <li class="nav-item mobile-menu d-md-none mr-auto">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ft-menu font-large-1"></i></a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                                <i class="ft-menu"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block">
                            <a class="nav-link nav-link-expand" href="#">
                                <i class="ficon ft-maximize"></i>
                            </a>
                        </li>
                        
                    </ul>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item">
                            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"> <span
                                    class="avatar avatar-online"><img
                                        src="{{ url('assets/dashboard/app-assets/images/portrait/small/avatar-s-19.png')}}"
                                        alt="avatar"></span></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="arrow_box_right">
                                    <a class="dropdown-item" href="#">
                                        {{-- <i class="ft-user"></i> --}}
                                        Edit Profile
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                    
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </form>
                    
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </div>
    </nav>
<!-- END: Header-->