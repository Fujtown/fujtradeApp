<!doctype html>
<html lang="en">

<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Premium HTML5 Template by Indonez">
    <meta name="keywords" content="blockit, uikit3, indonez, handlebars, scss, javascript">
    <meta name="author" content="Indonez">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>

    <!-- stylesheet -->

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('theme') === 'dark') {
                var link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = "{{ asset('assets/css/dark.css') }}"; // Use Blade syntax for the asset URL
                document.head.appendChild(link);
            }
        });
    </script>
    <!-- uikit -->
    <script src="{{ asset('assets/js/vendors/uikit.min.js') }}"></script>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/assets/img/favicon.ico') }}" type="image/x-icon">
    <!-- touch icon -->
    <link rel="apple-touch-icon-precomposed" href="{{ asset('assets/assets/img/apple-touch-icon.png') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>@yield('title', 'Fujtrade')</title>
</head>

<body>
    @include('partials.header')
    @include('partials.loader')

    <div id="app">
        @yield('content')
    </div>

    @include('partials.footer')

    <script src="{{ mix('js/app.js') }}"></script>
    <!-- footer end -->
<!-- to top begin -->
<a href="#" class="to-top uk-visible@m" data-uk-scroll>
    Top<i class="fas fa-chevron-up"></i>
</a>
<!-- to top end -->

<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" defer></script>
<script src="{{ asset('assets/js/utilities.min.js') }}"></script>
<script src="{{ asset('assets/js/config-theme.js') }}"></script>
<script src="{{ asset('assets/js/darkmode.js') }}"></script>

{{-- Inline script can be included directly or extracted to a separate JS file --}}
 <script>
        let card = document.querySelector(".profile_card"); //declearing profile card element
let displayPicture = document.querySelector(".display-picture"); //declearing profile picture

displayPicture.addEventListener("click", function() { //on click on profile picture toggle hidden class from css
card.classList.toggle("hidden")})
    </script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });

    // When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

// Get the navbar
var navbar = document.getElementById("navbar");
var link = document.getElementById("link");


// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
    link.classList.add("sticky-link")
  } else {
    navbar.classList.remove("sticky");
    link.classList.remove("sticky-link")
  }
}


</script>

{{-- Optional: If you have a separate JS file for custom scripts, you can include it here --}}
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}

    @stack('scripts')
</body>

</html>
