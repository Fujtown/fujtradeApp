@extends('layouts.auth') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<div class="page-loader">
    <div></div>
    <div></div>
    <div></div>
</div>
<style>
    #loginForm{
            z-index: 1;
    position: relative;
    }
</style>
<!-- page loader end -->
<section class="container">
    <div class="login-container">
        <div class="circle circle-one"></div>
        <div class="form-container">
            <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
            <h1 class="opacity">LOGIN</h1>
            <form id="loginForm">
                @csrf
                <input type="email" name="email" id="email" placeholder="EMAIL" />
                <span class="error" id="error-email"></span>
                <input type="password" name="password" id="password" placeholder="PASSWORD" />
                <span class="error" id="error-password"></span>
                <button class="opacity login" type="button" name="submit">LOGIN</button>
            </form>
            <div class="register-forget opacity">
                <a href="/signup">REGISTER</a>
                <a href="{{ route('forgot_password') }}" >FORGOT PASSWORD</a>
            </div>
        </div>
        <div class="circle circle-two"></div>
    </div>
    <div class="theme-btn-container"></div>
</section>
@push('scripts')
<script>
    $(document).on('click','.login',function(){
        var data = new FormData(document.getElementById("loginForm"));
        $(".login").attr( "disabled", "disabled" );
                    $(".login").text('Loading...');
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "{{ url('/login') }}",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response.message,
                didClose: () => {
                    // Redirect to the home page
                    window.location.href = '/home';
                }
            });
            },
            error: function(response) {
            if(response.status === 422) { // Validation error
                let errors = response.responseJSON.errors;
                Object.keys(errors).forEach(function (key) {
                    $('#error-' + key).text(errors[key][0]);
                });

                $(".login").removeAttr("disabled");
                $(".login").text('LOGIN');
            }
            else {
                Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: response.responseJSON.message,
                  });

                $(".login").removeAttr("disabled");
                $(".login").text('LOGIN');
            }
        }
        });

        // Clear specific error messages when input becomes valid
        ['email', 'password'].forEach(function(field) {
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
