<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                <!--Zoter-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="{{route('coffee.dashboard')}}" class="logo">
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
                            <a class="dropdown-item" href="#"><i class="mdi mdi-wallet m-r-5 text-muted"></i> My Wallet</a>
                            <a class="dropdown-item" href="#"><span class="badge badge-success float-right">5</span><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{url('coffee/logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
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
                        <a href="{{route('coffee.dashboard')}}"><i class="mdi mdi-airplay"></i>Home</a>
                    </li>
                    

                     <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>All Payments</a>
                        <ul class="submenu">
                            <li> <a href="{{route('coffee.all_payments')}}">All TAP Payments</a></li>
                            <li><a href="{{route('coffee.all_foloosi_payments')}}">All Foloosi Payments</a></li>
                        </ul>
                    </li>
    
                    @php
                    $user = Auth::guard('admin')->user();
                    $user_id = $user->id;
                    @endphp
                    @if ($user_id !== 34)
                    <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>Links</a>
                        <ul class="submenu">
                           <li> <a href="{{route('coffee.noon_links')}}">Noon Links</a></li>
                           <li> <a href="{{route('coffee.all_links')}}">Links</a></li>
                            <!--<li><a href="{{route('coffee.new_link')}}">New TAP Link</a></li>-->
                            <li><a href="{{route('coffee.create_noon_link')}}">New Noon Link</a></li>
                            <li><a href="{{route('coffee.create_networkInt_link')}}">New Network Int Link</a></li>
                            <!--<li><a href="{{route('coffee.new_foloosi_link')}}">New Foloosi Link</a></li>-->
                        </ul>
                    </li>
                     <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>Agents</a>
                        <ul class="submenu">
                            <li> <a href="{{route('coffee.all_agents')}}">All Agents</a></li>
                            <li><a href="{{route('coffee.create_agent')}}">New Agent</a></li>
                        </ul>
                    </li>
                      <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>KYC</a>
                        <ul class="submenu">
                            <li> <a href="{{route('coffee.all_kyc')}}">All Customers KYC's</a></li>
                            <li><a href="{{route('coffee.create_kyc')}}">Upload KYC</a></li>
                        </ul>
                    </li>
                    <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>Refunds</a>
                        <ul class="submenu">
                             <li> <a href="{{route('coffee.all_tap_refunds')}}">All TAP Refunds</a></li>
                            <li> <a href="{{route('coffee.dispute_refunds')}}">Dispute From TAP</a></li>
                            <li> <a href="{{route('coffee.all_kyc')}}">Directly From Client</a></li>
                            <li> <a href="{{route('coffee.requested_refunds')}}">Requested Refunds</a></li>
                        </ul>
                    </li>
                    @endif
                   
                  
                    
                     <li class="has-submenu ">
                        <a href="#"><i class="mdi mdi-airplay"></i>Reports</a>
                        <ul class="submenu">
                             <li> <a href="{{route('coffee.agent_payment_report')}}">Agent Payment Report</a></li>
                            <li> <a href="{{route('coffee.payment_ledger')}}">All Payments Ledger</a></li>
                            <li> <a href="{{route('coffee.foloosi_payment_ledger')}}">Foloosi Payment Ledger</a></li>
                            <li> <a href="{{route('coffee.agent_tap_paymentledger')}}">Tap Payment By Agent</a></li>
                        </ul>
                    </li>



                </ul>


                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
