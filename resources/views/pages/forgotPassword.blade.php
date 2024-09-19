@extends('layouts.auth') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<style>
    /* Add a loading style to the button */
#submitButton.loading {
background-color: #ccc; /* Change to your loading background color */
cursor: not-allowed;
/* Add any other styling for the loading state */
}
.title{
font-size: 1.2rem;
opacity: .8;
text-align: center;
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
            <h1 class="opacity title">CHANGE YOUR PASSWORD</h1>
            <form id="resetPasswordForm">
                <input type="password" id="newPassword" placeholder="Enter your new password" />
                <input type="password" id="confirmPassword" placeholder="Confirm your new password" />
                <button class="opacity" id="submitButton" type="submit" name="submit">RESET PASSWORD</button>
            </form>
            <div class="register-forget opacity">
                <span>Remember your password? <a href="/signin" style="text-decoration: underline;">Log in here</a></span>
            </div>
        </div>
        <div class="circle circle-two"></div>
    </div>
    <div class="theme-btn-container"></div>
</section>

@endsection
