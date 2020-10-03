<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @include('layouts.partials.favicon')

    <link href="{{ asset('css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/loader.js') }}"></script>

    @include('layouts.partials.styles')

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <style>
        .layout-px-spacing {
            min-height: calc(100vh - 166px)!important;
        }
        .form-group label, label {
            font-size: 15px;
            color: #515151;
            letter-spacing: 1px;
        }
        .table > tbody > tr > td {
            vertical-align: middle;
            color: #515365;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .table-hover:not(.table-dark) tbody tr:hover {
            background-color: #f1f2f3 !important;
        }
        table.dataTable { 
            margin-top: 0px !important;
        }
        .table > tbody::before {
            line-height: 0px;
            content: "";
            color: unset;
            display: block;

        }
        .error {
            color: #e7515a !important;
            font-size: 13px !important;
            font-weight: 700;
            letter-spacing: 1px;
        }
        #userProfileDropdown {
            color: #e4e5ee;
        }
        .btn-group .dropdown-menu a.dropdown-item {
            color: #888ea8 !important;
        }
        .ellipsis {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .widget-content-area {
            border-radius: 6px;
        }
        .widget {
            box-shadow: unset !important;
        }
    </style>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body>

   {{--  @php 
        $userLevels = [
            1 => 'Provincial Admin',
            2 => 'Municipal Admin',
            3 => 'Barangay Admin',
            4 => 'Resident',
            5 => 'Hospital',
            6 => 'Establishment',
        ]
    @endphp --}}

    <!-- BEGIN LOADER -->
    <div id="load_screen"> 
        <div class="loader"> 
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    @include('layouts.partials.navbar')

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('layouts.partials.sidebar')
        
        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                @include('alerts')

                @yield('content')

            </div>
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="">
                        &copy; 2020 All Rights Reserved. 
                        <a href="https://www.tmdcitsolutions.com/" target="blank">TMDC IT Solutions</a> | 
                        <a href="https://bnshosting.net/" target="blank">Bitstop Network Services</a> | 
                        <a href="{{ route('privacy-policy') }}" class="text-primary" target="blank">Privacy Policy</a>
                    </p>
                </div>
                <div class="footer-section f-section-2">
                    <p class="">Coded with <i data-feather="heart"></i> | Version {{ env('APP_VERSION') }}</p>
                </div>
            </div>
        </div>
        <!--  END CONTENT PART  -->

    </div>
    <!-- END MAIN CONTAINER -->

    @include('layouts.partials.scripts')

</body>
</html>
