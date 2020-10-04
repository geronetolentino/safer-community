-    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-item theme-brand flex-row  text-center">
                <li class="nav-item theme-logo">
                    <a href="index.html">
                        {{-- <img src="{{ asset('img/logo.svg') }}" class="navbar-logo" alt="logo"> --}}
                    </a>
                </li>
                <li class="nav-item theme-text">
                    <a href="{{ route('home') }}" class="nav-link">{{ env('APP_NAME') }} <small> | {{ strtoupper(Auth::user()->type) }} [ {{ Auth::user()->fullAddress }} ]</small> </a>
                </li>
            </ul>

            <ul class="navbar-item flex-row ml-md-auto">

                <li class="nav-item dropdown notification-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="bell"></i>
                        <span class="badge badge-success"></span>
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="notificationDropdown">
                        <div class="notification-scroll">
                            @foreach($notifications as $notification)
                            <div class="dropdown-item">
                                <div class="media">
                                    {{-- <i data-feather="tag"></i> --}}
                                    <div class="media-body">
                                        <div class="notification-para">
                                            <span class="user-name">{{ $notification->title }}</span> <br>
                                            {!! $notification->message !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown user-profile-dropdown">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        {{ Auth::user()->name }} 
                    </a>
                    <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                        <div class="">
                            <div class="dropdown-item">
                                <a class="" href="{{ route('account') }}">
                                    <i data-feather="user"></i>
                                    My Profile
                                </a>
                            </div>
                            <div class="dropdown-item">
                                <a class="" href="{{ route('logout') }}"> 
                                    <i data-feather="log-out"></i>
                                    Sign Out
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->

    <!--  BEGIN NAVBAR  -->
    <div class="sub-header-container">
        <header class="header navbar navbar-expand-sm">
            <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                <i data-feather="menu"></i>
            </a>

            <ul class="navbar-nav flex-row">
                <li>
                    <div class="page-header">
                        <div class="page-title">
                            <h3>{{ $pageName ?? '' }}</h3>
                        </div>
                    </div>
                </li>
            </ul>
           
        </header>
    </div>
    <!--  END NAVBAR  -->