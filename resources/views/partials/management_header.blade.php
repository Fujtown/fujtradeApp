<header id="topnav">
    <style>
        #topnav .topbar-main,#topnav .navbar-custom{
            background-color: #607D8B;
        }
        #topnav .navigation-menu > li > a i{
            background-color: #1c4254;
        }
        .notification-list .noti-title{
            background-color: #2b4e60;
        }
        .btn-primary{
            background-color: #607D8B;
            border: 1px solid #607D8B;
        }
        .page-item.active .page-link {
            background-color: #607D8B;
            border-color: #607D8B;
        }
    </style>
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                <!--Zoter-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="{{route('coffee.agent.dashboard')}}" class="logo">
                    <img src="{{ asset('admin_assets/images/logo.png') }}" alt="" class="logo-large">
                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">

                <ul class="list-inline float-right mb-0">

                    <!-- language-->




                    <!-- User-->
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('admin_assets/images/users/avatar-1.jpg')}}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            @php
                                $user = Auth::guard('admin')->user();
                            @endphp
                            <div class="dropdown-item noti-title">
                                <h5>Welcome {{$user->username}}</h5>
                            </div>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                            <a class="dropdown-item" href="#"><span class="badge badge-success float-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('coffee.agent.logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                        </div>
                    </li>
                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>

            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu text-center">

                    <li class="has-submenu ">
                        <a href="{{route('coffee.management.dashboard')}}"><i class="mdi mdi-airplay"></i>Home</a>
                    </li>
                    <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>Settings</a>
                        <ul class="submenu">
                            <li> <a href="#">Update Content</a></li>
                            {{-- <li><a href="{{route('coffee.agent.new_link')}}">New Link</a></li> --}}
                        </ul>
                    </li>

                </ul>


                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
