@extends('layouts.auth') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<div class="page-loader">
    <div></div>
    <div></div>
    <div></div>
</div>
<!-- page loader end -->
<style>

    .iti__flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/img/flags.png");}

@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
.iti__flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/img/flags@2x.png");}
}
.iti{
width: 100%;
}
.iti__country{
color: black !important;
}
.login-container form input{
margin: 0.7rem 0 !important;
padding: 11px;
}
body{
overflow: hidden;
}
.title{
font-size: 1.5rem;
opacity: .8;
}
.google-sign-in-button {
cursor: pointer;
transition: background-color .3s, box-shadow .3s;

padding: 12px 16px 12px 42px;
border: none;
border-radius: 3px;
box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 1px 1px rgba(0, 0, 0, .25);

color: #757575;
font-size: 14px;
font-weight: 500;
font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen,Ubuntu,Cantarell,"Fira Sans","Droid Sans","Helvetica Neue",sans-serif;

background-image: url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0ibm9uZSIgZmlsbC1ydWxlPSJldmVub2RkIj48cGF0aCBkPSJNMTcuNiA5LjJsLS4xLTEuOEg5djMuNGg0LjhDMTMuNiAxMiAxMyAxMyAxMiAxMy42djIuMmgzYTguOCA4LjggMCAwIDAgMi42LTYuNnoiIGZpbGw9IiM0Mjg1RjQiIGZpbGwtcnVsZT0ibm9uemVybyIvPjxwYXRoIGQ9Ik05IDE4YzIuNCAwIDQuNS0uOCA2LTIuMmwtMy0yLjJhNS40IDUuNCAwIDAgMS04LTIuOUgxVjEzYTkgOSAwIDAgMCA4IDV6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNNCAxMC43YTUuNCA1LjQgMCAwIDEgMC0zLjRWNUgxYTkgOSAwIDAgMCAwIDhsMy0yLjN6IiBmaWxsPSIjRkJCQzA1IiBmaWxsLXJ1bGU9Im5vbnplcm8iLz48cGF0aCBkPSJNOSAzLjZjMS4zIDAgMi41LjQgMy40IDEuM0wxNSAyLjNBOSA5IDAgMCAwIDEgNWwzIDIuNGE1LjQgNS40IDAgMCAxIDUtMy43eiIgZmlsbD0iI0VBNDMzNSIgZmlsbC1ydWxlPSJub256ZXJvIi8+PHBhdGggZD0iTTAgMGgxOHYxOEgweiIvPjwvZz48L3N2Zz4=);
background-color: white;
background-repeat: no-repeat;
background-position: 12px 11px;
width: 100%;
display: block;
margin-bottom: 10px;
}

.google-sign-in-button:hover {
box-shadow: 0 -1px 0 rgba(0, 0, 0, .04), 0 2px 4px rgba(0, 0, 0, .25);
}

.google-sign-in-button:active {
background-color: #eeeeee;
}

.google-sign-in-button:active {
outline: none;
    box-shadow:
    0 -1px 0 rgba(0, 0, 0, .04),
    0 2px 4px rgba(0, 0, 0, .25),
    0 0 0 3px #c8dafc;
}

.error {
    color: white;
    font-size: 0.8em;
}

</style>
<!-- page loader begin -->
<div class="page-loader">
    <div></div>
    <div></div>
    <div></div>
</div>
<!-- page loader end -->
<section class="container">
    <div class="login-container">
        <div class="circle circle-one"></div>
        <div class="form-container">
            <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
            <h1 class="opacity title">CREATE ACCOUNT</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form id="customerForm">
                @csrf
                <input type="text" name="fname" id="fname" required placeholder="FIRST NAME" />
                <span class="error" id="error-fname"></span>
                <input type="text" id="lname" name="lname" required placeholder="LAST NAME" />
                <span class="error" id="error-lname"></span>
                <input type="text" id="username" name="username" required placeholder="USERNAME" />
                <span class="error" id="error-username"></span>
                <input type="email" id="email" name="email" required placeholder="EMAIL" />
                <span class="error" id="error-email"></span>
                <input  class="phone" id="phone" name="phone" required style="width: 100%; padding: 10px 10px 10px 73px; text-align: left;border-radius: 5px;" type="tel"
                required maxlength="19" placeholder=""/>
                <span class="error" id="error-phone"></span>
                <input type="hidden" value="1" name="country_code" required id="country_code" name="country_code">
                <span class="error" id="error-country_code"></span>
                <input type="password" required id="password" name="password" placeholder="PASSWORD" />
                <span class="error" id="error-password"></span>
                <button class="opacity register" type="button" name="submit">SIGN UP</button>
            </form>

             <!-- login form end -->
             <!--<p class="uk-heading-line"><span>Or registered with</span></p>-->
            <!-- <div class="uk-margin-medium-bottom">
                <a href="{{ route('google.login') }}" class="google-sign-in-button" >
                    Sign in with Google
                  </a>
               </div>-->
             <span class="uk-text-small">Already have an account? <a href="/signin">Login</a></span><br>
            <a class="go_back" href="/home">Go Back</a>
        </div>
        <div class="circle circle-two"></div>
    </div>
    <div class="theme-btn-container"></div>
</section>
@push('scripts')
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/intlTelInput.min.js"></script>
<script>
    $(document).ready(function () {
      let userInfo = localStorage.getItem('user_set_data');
      if (userInfo) {
  let filter = JSON.parse(userInfo);
  $('#email').val(filter.email)
      }

          // Initialize the intlTelInput library
 var input = document.querySelector(".phone");
 var iti = window.intlTelInput(input, {
     separateDialCode: true,

     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/utils.min.js", // Make sure to include this script
             preferredCountries: ['us', 'gb', 'ae'], // Prioritize US, UK, and UAE
      dropdownContainer: document.body
 });

 // Update the hidden input with the selected country code
 input.addEventListener("countrychange", function () {
     var country_code = iti.getSelectedCountryData().dialCode;
     document.querySelector("#country_code").value = country_code;
 });

    });
</script>
<!-- Add the following script tag at the end of your HTML file -->
<script>
  $(document).ready(function () {

      // Event listener for form submission
      $("#submitBtn").click(function () {
          // Get form data
          var formData = {
              fname: $("#fname").val(),
              lname: $("#lname").val(), // Add other form fields
              username: $("#username").val(), // Add other form fields
              email: $("#email").val(), // Add other form fields
              phone: $("#phone").val(), // Add other form fields
              country_code: $("#country_code").val(), // Add other form fields
              password: $("#password").val(), // Add other form fields
              // ...
          };

          // Send form data to the server using AJAX
          $.ajax({
              type: "POST",
              url: "/save_account", // Update the URL with your server endpoint
              data: JSON.stringify(formData),
              contentType: "application/json",
              success: function (response) {
                  console.log("Data sent successfully");
                    // Display a success SweetAlert2 message
                  Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: response.message, // Assuming your server sends a message in the response
                  });

                  // Reset the form inputs
                  $('#formId')[0].reset(); // Replace 'formId' with the actual ID of your form

              },
              error: function (error) {
                  console.error("Error sending data:", error);
                    // Display an error SweetAlert2 message
                  Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'Failed to submit data. Please try again.',
                  });
                  // Handle errors
              }
          });
      });
  });
</script>
<script>
    $(document).on('click','.register',function(){
        var data = new FormData(document.getElementById("customerForm"));
        $(".register").attr( "disabled", "disabled" );
                    $(".register").text('Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "{{ url('/save_customer') }}",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: 'Awesome !',
                    text: 'Account Created successfully you can login now !',
                    type: 'success',
                    didClose: () => {
                        // Redirect to the home page
                        window.location.href = '/signin';
                    }
                });
            },
            error: function(response) {
            if(response.status === 422) { // Validation error
                let errors = response.responseJSON.errors;
                Object.keys(errors).forEach(function (key) {
                    $('#error-' + key).text(errors[key][0]);
                });

                    $(".register").removeAttr("disabled");
                    $(".register").text('REGISTER');
            } else {
                Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'An error occurred. Please try again.',
                  });

                  $(".register").removeAttr("disabled");
                  $(".register").text('REGISTER');
            }
        }
        });

        // Clear specific error messages when input becomes valid
['fname','lname','username' ,'email', 'phone', 'country_code', 'password'].forEach(function(field) {
    $('#' + field).on('input', function() {
        if (this.checkValidity()) {
            $('#error-' + field).text('');
        }
    });
});
    })
</script>
@endpush
@endsection
