<!doctype html>
<html lang="en">


<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium HTML5 Template by Indonez">
    <meta name="keywords" content="blockit, uikit3, indonez, handlebars, scss, javascript">
    <meta name="author" content="Indonez">
    <meta name="theme-color" content="#E9E8F0">
    <!-- preload assets -->
    <link rel="preload" href="{{ asset('assets/fonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/montserrat-v14-latin-600.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/lato-v16-latin-regular.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/fonts/lato-v16-latin-700.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style">
    <link rel="preload" href="{{ asset('assets/js/vendors/uikit.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('assets/js/utilities.min.js') }}" as="script">
    <link rel="preload" href="{{ asset('assets/js/config-theme.js') }}" as="script">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/css/intlTelInput.css"  />
    <!-- stylesheet -->
    <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <!-- uikit -->
    <script src="{{ asset('assets/js/vendors/uikit.min.js') }}"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon">
    <!-- touch icon -->
    <link rel="apple-touch-icon-precomposed" href="/assets/img/apple-touch-icon.png">
    <title>Sign in </title>
</head>


<body>

    <div id="app">
        @yield('content')
    </div>


    <!-- footer end -->
<!-- to top begin -->

<!-- to top end -->

<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/utilities.min.js') }}"></script>
<script src="{{ asset('assets/js/config-theme.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{ asset('assets/js/auth.js') }}"></script>

{{-- Optional: If you have a separate JS file for custom scripts, you can include it here --}}
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}

    @stack('scripts')
</body>

</html>
