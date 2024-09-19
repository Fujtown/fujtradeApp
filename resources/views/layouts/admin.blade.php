<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>  @if(session('user_type') == 'admin')
            Admin
        @elseif(session('user_type') == 'superadmin')
            Superadmin

        @elseif(session('user_type') == 'member')
            Member

        @elseif(session('user_type') == 'management')
            Management
        @else
        Agent
        @endif
         Dashboard</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('admin_assets/images/favicon.ico') }}">

        <!-- jvectormap -->
        <link href="{{ asset('admin_assets/plugins/fullcalendar/vanillaCalendar.css') }}" rel="stylesheet" type="text/css"  />

        <link href="{{ asset('admin_assets/plugins/morris/morris.css') }}" rel="stylesheet">


        <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/css/admin_custom.css') }}" rel="stylesheet" type="text/css">
          <!-- DataTables -->
          <link href="{{ asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
          <link href="{{ asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
          <!-- Responsive datatable examples -->
          <link href="{{ asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
          <link href="{{ asset('admin_assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    </head>

    <body>
            @if(session('user_type') == 'admin')
            @include('partials.admin_header')

            @elseif(session('user_type') == 'superadmin')
            @include('partials.superadmin_header')

            @elseif(session('user_type') =='member')
            @include('partials.member_header')

            @elseif(session('user_type') =='management')
            @include('partials.management_header')

            @else
            @include('partials.agent_header')
            @endif


            @include('partials.admin_loader')

            <div id="app">
                @yield('content')
            </div>

            @include('partials.admin_footer')

        {{-- <script src="{{ mix('js/app.js') }}"></script> --}}

    <script src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/waves.js') }}"></script>
    <script src="{{ asset('admin_assets/js/jquery.nicescroll.js') }}"></script>

    <script src="{{ asset('admin_assets/plugins/skycons/skycons.min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/fullcalendar/vanillaCalendar.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('admin_assets/plugins/morris/morris.min.js') }}"></script>




    <!-- App js -->
    <script src="{{ asset('admin_assets/js/app.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
    @stack('scripts')
</body>

</html>




