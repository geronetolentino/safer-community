<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
    </style>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <link href="{{ asset('css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />

</head>
<body>
    
    <!-- BEGIN LOADER -->
    <div id="load_screen"> 
        <div class="loader"> 
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <main>
        @yield('content')
    </main>
    
    @include('layouts.partials.scripts')

</body>
</html>
