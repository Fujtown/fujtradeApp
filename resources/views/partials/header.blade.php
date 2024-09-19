   <!-- header begin -->
   <header>
    <div class="uk-section uk-padding-small in-profit-ticker">
        <div class="uk-container">
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <div data-uk-slider="autoplay: true; autoplay-interval: 5000">
                        <ul class="uk-grid-large uk-slider-items uk-child-width-1-3@s uk-child-width-1-6@m uk-text-center" data-uk-grid>
                            <li>
                                <div class="in-icon-wrap small circle up">
                                    <i class="fas fa-angle-up"></i>
                                </div>
                                <div>
                                    XAUUSD <span class="uk-text-success">1478.81</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle down">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                                <div>
                                    GBPUSD <span class="uk-text-danger">1.3191</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle down">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                                <div>
                                    EURUSD <span class="uk-text-danger">1.1159</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle up">
                                    <i class="fas fa-angle-up"></i>
                                </div>
                                <div>
                                    USDJPY <span class="uk-text-success">109.59</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle up">
                                    <i class="fas fa-angle-up"></i>
                                </div>
                                <div>
                                    USDCAD <span class="uk-text-success">1.3172</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle up">
                                    <i class="fas fa-angle-up"></i>
                                </div>
                                <div>
                                    USDCHF <span class="uk-text-success">0.9776</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle down">
                                    <i class="fas fa-angle-down"></i>
                                </div>
                                <div>
                                    AUDUSD <span class="uk-text-danger">0.67064</span>
                                </div>
                            </li>
                            <li>
                                <div class="in-icon-wrap small circle up">
                                    <i class="fas fa-angle-up"></i>
                                </div>
                                <div>
                                    GBPJPY <span class="uk-text-success">141.91</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-section uk-padding-remove-vertical">
        <nav class="uk-navbar-container" id="navbar" data-uk-sticky="show-on-up: true; animation: uk-animation-slide-top;">
            <div class="uk-container" data-uk-navbar>
                <div class="uk-navbar-left uk-width-expand uk-flex uk-flex-between">
                    <a class="uk-navbar-item uk-logo" href="{{ url('/home') }}">
                        <img src="{{ asset('assets/img/in-lazy.gif') }}" data-src="{{ asset('assets/img/logo4.png') }}" style="" alt="logo" width="110" height="36" data-uk-img>
                    </a>
                    <ul class="uk-navbar-nav uk-visible@m" id="link">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('market') }}">Markets</a></li>
                        {{-- <li><a href="#">Blog</a></li> --}}
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('career') }}">Career</a>  </li>
                        <li><a href="{{ route('about') }}">About</a></li>
                    </ul>
                </div>
                <div class="uk-navbar-right uk-width-auto">

                    <div class="uk-navbar-item in-optional-nav">
                        @auth
                        @php
                            $imageUrl = Auth::user()->photo;
                        @endphp


                            <ul class="profile_ul">
                                @if(strpos($imageUrl, 'https://') === 0)

                                <a href="#" class="display-picture"><img src="{{ Auth::user()->photo }}" alt=""></a>
                            @else
                            <a href="#" class="display-picture"><img src="{{'assets/profile_photos/'.Auth::user()->photo}}" alt=""></a>
                            @endif
                                <!--Profile Image-->
                            </ul>
                            <div class="profile_card hidden"><!--ADD TOGGLE HIDDEN CLASS ATTRIBUTE HERE-->
                                <ul class="profile_menu"><!--MENU-->
                                    <li><a href="{{ route('profile') }}">Profile</a></li>
                                    <li><a href="{{ route('account') }}">Account</a></li>
                                    <li><a href="#">Settings</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="logout" type="submit">Logout</button>
                                        </form>
                                </ul>
                            </div>
                        @else
                            <div>
                                <a href="{{ url('/signin') }}" class="uk-button uk-button-link">Login</a>
                                <a href="{{ url('/signup') }}" class="uk-button uk-button-link">Sign up</a>
                            </div>
                        @endauth
                    </div>


                    <div class="theme-switch-wrapper">
                        <span id="theme-switch-moon" value="moon" class="theme-switch-icon"><img title="Switch to Night mode" src="{{ asset('assets/img/moon.png') }}" style="" alt=""></span> <!-- Moon Icon -->
                        <span id="theme-switch-sun" value="sun" class="theme-switch-icon" style="display:none;"><img title="Switch to day mode" src="{{ asset('assets/img/light.png') }}" style="width: 40px;" alt=""></span> <!-- Sun Icon -->
                        <input class="form-check-input" type="checkbox" id="theme-switch" style="display:none;">
                    </div>



                    {{-- <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="theme-switch">
                        <label class="form-check-label" for="theme-switch">Dark mode</label>
                    </div> --}}
                </div>
            </div>
        </nav>

    </div>
</header>
<!-- header end -->
