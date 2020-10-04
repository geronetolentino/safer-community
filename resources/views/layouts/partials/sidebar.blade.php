       <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">
            
            <nav id="sidebar">

                <div class="shadow-bottom"></div>

                <ul class="list-unstyled menu-categories" id="accordionExample">

                    <li class="menu">
                        <a href="{{ route('home') }}" {{ $navName=='Dashboard'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="home"></i>
                                <span> Dashboard</span>
                            </div>
                        </a>
                    </li>
                  
                    <li class="menu">
                        <a href="{{ route('logout') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="log-out"></i>
                                <span> Sign Out</span>
                            </div>
                        </a>
                    </li>

                    {{-- <li class="menu">
                        <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                                <span> Menu 2</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled" id="submenu" data-parent="#accordionExample">
                            <li>
                                <a href="javascript:void(0);"> Submenu 1 </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"> Submenu 2 </a>
                            </li>                           
                        </ul>
                    </li> --}}
                </ul>
                
            </nav>

        </div>
        <!--  END SIDEBAR  -->