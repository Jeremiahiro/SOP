<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME')}} | @yield('title')</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    {{-- <script src="{{ asset('frontend/js/moment-with-locales.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('frontend/js/rescalendar.min.js') }}"></script> --}}

    <script src="{{ asset('frontend/jquery/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('frontend/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('frontend/jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js" crossorigin="anonymous"></script>

    <!-- ADMIN links-->
    <link rel="apple-touch-icon" style="width: 10px !important; height: 10px !important;" href="{{asset('frontend/img/logo.png')}}">
    <link rel="shortcut icon" style="width: 10px !important; height: 10px !important;"  href="{{asset('frontend/img/logo.png')}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/cs-skin-elastic.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/css/style.css') }}">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
    <!--admin links end-->


    {{-- bootstrap --}}
    <link href="{{ asset('frontend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/tourGuide.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('frontend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/shepherd.js@5.0.1/dist/js/shepherd.js"></script>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    {{--  <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/rescalendar.min.css') }}" rel="stylesheet"> --}}

    <script src="{{ asset('frontend/jquery/tabToggle.js')}}"></script>
    <script src="{{ asset('frontend/jquery/followToggle.js')}}"></script>

    <script src="{{ asset('frontend/js/moment-with-locales.min.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" crossorigin="anonymous"></script>
    

   <style>
    #weatherWidget .currentDesc {
        color: #ffffff!important;
    }
        .traffic-chart {
            min-height: 335px;
        }

        .rightie{
            right: 0px !important;    
        }

        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

    </style>

    {{-- @laravelPWA --}}
    @yield('custom-style')

</head>

<body>
    <div id="" >
      
            @php
                $route = \Route::current()->getName();
            @endphp
            @if ($route == 'home' || $route == 'login' || $route == 'register' || $route == 'password.request' ||
             $route == 'password.confirm' || $route == 'password.reset' || $route == 'verification.notice' || $route == 'dashboard.index'
             || $route == 'dashboard.show' || $route == 'dashboard.edit')
            @else
                @include('admin.partials.header')
            @endif

            @include('partials.alert.alert')

            <div id="right-panel" class="right-panel">
            @yield('content')
            
           {{-- @include('admin.partials.footer') --}}
        @auth
        @include('partials.modals.views.sideNav')
        @include('partials.modals.views.settings')
        @include('partials.modals.views.userFollowers')
        @include('partials.modals.views.userFollowings')
        @endauth
            </div>
         <!-- /#right-panel -->
      
    </div>

      <!-- Scripts -->
      <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
      <script src="{{ asset('adminAssets/js/main.js') }}"></script>

       <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="assets/js/init/weather-init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="{{ asset('adminAssets/js/init/fullcalendar-init.js') }}"></script>


    @yield('script')

</body>

</html>
