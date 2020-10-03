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

                    @if(Auth::user()->type == 1)

                    <li class="menu">
                        <a href="{{ route('pa.municipality') }}" {{ $navName=='Municipality'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="grid"></i>
                                <span> Municipalities</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('pa.hospital') }}" {{ $navName=='Hospital'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="activity"></i>
                                <span> Hospitals</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('pa.establishment') }}" {{ $navName=='Establishment'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="hexagon"></i>
                                <span> Establishments</span>
                            </div>
                        </a>
                    </li>

                    @elseif(Auth::user()->type == 2)

                    <li class="menu">
                        <a href="{{ route('ma.barangay') }}" {{ $navName=='Barangay'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="grid"></i>
                                <span> Barangays</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('ma.residents') }}" {{ $navName=='Residents'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Residents</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('ma.establishment') }}" {{ $navName=='Establishment'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="hexagon"></i>
                                <span> Establishments</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('ma.visitors') }}" {{ $navName=='Visitors'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Visitors</span>
                            </div>
                        </a>
                    </li>

                    @elseif(Auth::user()->type == 3)

                    <li class="menu">
                        <a href="{{ route('br.residents') }}" {{ $navName=='Residents'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Residents</span>
                            </div>
                        </a>
                    </li>

                    @elseif(Auth::user()->type == 4) 

                    <li class="menu">
                        <a href="{{ route('rs.travel') }}" {{ $navName=='Travel'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="navigation"></i>
                                <span> Travel History</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('rs.access.logs') }}" {{ $navName=='Info Access Logs'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="shield"></i>
                                <span> Info Access Logs</span>
                            </div>
                        </a>
                    </li>

                    {{-- <li class="menu">
                        <a href="{{ route('rs.documents') }}" {{ $navName=='Documents'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="archive"></i>
                                <span> Health Documents</span>
                            </div>
                        </a>
                    </li> --}}

                    {{-- <li class="menu">
                        <a href="{{ route('rs.visits') }}" {{ $navName=='Visitors'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="clipboard"></i>
                                <span> Visit Requests</span>
                            </div>
                        </a>
                    </li> --}}

                    @elseif(Auth::user()->type == 5)
                             
                    <li class="menu">
                        <a href="{{ route('hp.patient') }}" {{ $navName=='Patient'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="archive"></i>
                                <span>Patients</span>
                            </div>
                        </a>
                    </li>

                    @elseif(Auth::user()->type == 6)

                    {{-- <li class="menu">
                        <a href="{{ route('es.employee') }}" {{ $navName=='Employees'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Employees</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('es.visitors') }}" {{ $navName=='Visitors'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="clipboard"></i>
                                <span> Visitor Logs</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu">
                        <a href="{{ route('es.scanner') }}" {{ $navName=='Scanner'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="camera"></i>
                                <span> Scanners</span>
                            </div>
                        </a>
                    </li> --}}

                    {{-- <li class="menu">
                        <a href="{{ route('es.visitor.scanner') }}" {{ $navName=='Scanner'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="camera"></i>
                                <span> Quick Scan</span>
                            </div>
                        </a>
                    </li> --}}
                    
                    <li class="menu">
                        <a href="{{ route('es.branch') }}" {{ $navName=='Branches'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="grid"></i>
                                <span> Branch</span>
                            </div>
                        </a>
                    </li>
                    
                    <li class="menu">
                        <a href="{{ route('es.employee') }}" {{ $navName=='Employees'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="users"></i>
                                <span> Employees</span>
                            </div>
                        </a>
                    </li>

                    @endif

                    <li class="menu">
                        <a href="{{ route('account') }}" {{ $navName=='My Profile'?'data-active=true':'' }} aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <i data-feather="user"></i>
            
                                <span> My Profile</span>
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