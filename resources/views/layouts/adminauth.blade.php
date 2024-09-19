<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Admin Login</title>
        <meta content="Admin Login" name="description" />
        <meta content="Mannatthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
         <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('admin_assets/images/favicon.ico') }}">
    
        <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet" type="text/css">

    </head>


<body>
<style>
  html, body {
  height: 100%;
}

html {
  font-size: 10px;
}

body {
    background: rgb(244,226,156);
background: -moz-linear-gradient(-45deg, rgba(244,226,156,0) 0%, rgba(59,41,58,1) 100%), -moz-linear-gradient(left, rgba(244,226,156,1) 0%, rgba(130,96,87,1) 100%);
background: -webkit-linear-gradient(-45deg, rgba(244,226,156,0) 0%,rgba(59,41,58,1) 100%), -webkit-linear-gradient(left, rgba(244,226,156,1) 0%,rgba(130,96,87,1) 100%);
background: -o-linear-gradient(-45deg, rgba(244,226,156,0) 0%,rgba(59,41,58,1) 100%), -o-linear-gradient(left, rgba(244,226,156,1) 0%,rgba(130,96,87,1) 100%);
background: -ms-linear-gradient(-45deg, rgba(244,226,156,0) 0%,rgba(59,41,58,1) 100%), -ms-linear-gradient(left, rgba(244,226,156,1) 0%,rgba(130,96,87,1) 100%);
background: linear-gradient(135deg, rgba(244,226,156,0) 0%,rgba(59,41,58,1) 100%), linear-gradient(to right, rgba(244,226,156,1) 0%,rgba(130,96,87,1) 100%);

position: absolute;
width: 100%;
height: 100vh;
}
    .wrapper-page .card{
        background: rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    box-shadow: 0px 20px 20px 20px rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .text-muted{
        color: #fff !important;
    }
    .form-control{
        padding: 1.75rem .75rem !important;
    }
</style>
    <div id="app">
        @yield('content')
    </div>


    <!-- footer end -->
<!-- to top begin -->

<!-- to top end -->

<!-- javascript -->
<script src="{{ asset('admin_assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/waves.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('admin_assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- Optional: If you have a separate JS file for custom scripts, you can include it here --}}
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}

    @stack('scripts')
</body>

</html>
