@extends('layouts.app') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<style>
    .profile-pic {
  color: transparent;
  transition: all 0.3s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  transition: all 0.3s ease;
  margin-top: 10px;
}
.profile-pic input {
  display: none;
}
.profile-pic img {
  position: absolute;
  object-fit: cover;
  width: 165px;
  height: 165px;
  box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.35);
  border-radius: 100px;
  z-index: 0;
}
.profile-pic .-label {
  cursor: pointer;
  height: 165px;
  width: 165px;
}
.profile-pic:hover .-label {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.8);
  z-index: 10000;
  color: #fafafa;
  transition: background-color 0.2s ease-in-out;
  border-radius: 100px;
  margin-bottom: 0;
}
.profile-pic span {
  display: inline-flex;
  padding: 0.2em;
  height: 2em;
}
.error {
    color: red;
    font-size: 0.8em;
}
</style>
<main>
    <!-- section content begin -->
    <div class="uk-section">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-center in-contact-6">
                <h1>Profile page</h1>
            </div>
            <div class="uk-width-3-3@m">
                <div class="uk-grid uk-child-width-1-3@m uk-margin-medium-top uk-text-center" data-uk-grid="">
                    <div>
                        <h5 class="uk-margin-remove-bottom">Profile Photo</h5>
                        {{-- @php
                        dd($user->fname);
                    @endphp --}}
                    <form id="infoForm"  enctype="multipart/form-data" >
                            <div class="profile-pic">
                                <label class="-label" for="file">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Image</span>
                                </label>

                                <input id="file" type="file" name="profile_photo" onchange="loadFile(event)"/>
                                @if($user->account_type=='google')
                                <img src="{{$user()->photo}}" id="output" width="200" />
                                @else
                               <img src="{{'assets/profile_photos/'.$user->photo}}" name="profile_photo" alt="" id="output" width="200">
                                 @endif
                            </div>
                    </div>
                    <div>
                        <h5 class="uk-margin-remove-bottom">Personal Information</h5>
                            <div data-uk-grid="" class="uk-form uk-grid-small uk-margin-medium-top">
                            @csrf
                            <div class="uk-width-1-2@s uk-inline">
                                <span class="uk-form-icon fas fa-info fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="name" name="fname" value="{{$user->fname}}" type="text" placeholder=" First Name">
                                <span class="error" id="error-fname"></span>
                            </div>
                            <div class="uk-width-1-2@s uk-inline">
                                <span class="uk-form-icon fas fa-info fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="lname" name="lname" value="{{$user->lname}}" type="text" placeholder=" Last Name">
                                <span class="error" id="error-lname"></span>
                            </div>
                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-user fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="email" name="username" type="text" value="{{$user->username}}" placeholder=" Username">
                                <span class="error" id="error-username"></span>
                            </div>

                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-envelope fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="email" name="email" type="email" value="{{$user->email}}"  placeholder=" Email address">
                                <span class="error" id="error-email"></span>
                            </div>

                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-phone fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="email" name="phone" type="text" value="{{$user->phone}}" placeholder=" Phone #">
                                <span class="error" id="error-phone"></span>
                            </div>


                            <div class="uk-width-1-1">
                                <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded update_info" id="update_info" type="button" name="submit">Update Information</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div>
                        <h5 class="uk-margin-remove-bottom">Change Password</h5>
                        <form id="passwordForm" class="uk-form uk-grid-small uk-margin-medium-top" data-uk-grid="">
                            @csrf

                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-key fa-sm"></span>
                                <input class="uk-input uk-border-rounded" id="current_password" name="current_password" type="text" placeholder=" Enter your current password">
                            </div>
                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-key fa-sm"></span>
                                <input class="uk-input uk-border-rounded" id="new_password" name="new_password" type="text" placeholder=" Enter New password">
                                <span class="error" id="error-new_password"></span>
                            </div>

                            <div class="uk-width-1-1 uk-inline">
                                <span class="uk-form-icon fas fa-key fa-sm"></span>
                                <input class="uk-input uk-border-rounded" id="c_new_password" name="new_password_confirmation" type="text" placeholder=" Confirm New password">
                                <span class="error" id="error-c_new_password"></span>
                            </div>


                            <div class="uk-width-1-1">
                                <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded change_password" id="change_password"  type="button" name="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).on('click','.update_info',function(){
            var data = new FormData(document.getElementById("infoForm"));

            $.ajax({
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "{{ url('/update_customer') }}",
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
                    location.reload();
                }
            });
                },
                error: function(response) {
                if(response.status === 422) { // Validation error
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $('#error-' + key).text(errors[key][0]);
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
            });

            // Clear specific error messages when input becomes valid
    ['name', 'email', 'subject', 'message'].forEach(function(field) {
        $('#' + field).on('input', function() {
            if (this.checkValidity()) {
                $('#error-' + field).text('');
            }
        });
    });
        })

        //change password script

        $(document).on('click','.change_password',function(){
            var data = new FormData(document.getElementById("passwordForm"));

            $.ajax({
                headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "{{ url('/change_password') }}",
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
                    location.reload();
                }
            });
                },
                error: function(response) {
                if(response.status === 422) { // Validation error
                    let errors = response.responseJSON.errors;
                    Object.keys(errors).forEach(function (key) {
                        $('#error-' + key).text(errors[key][0]);
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
            });

            // Clear specific error messages when input becomes valid
    ['old_password', 'new_password', 'c_new_password'].forEach(function(field) {
        $('#' + field).on('input', function() {
            if (this.checkValidity()) {
                $('#error-' + field).text('');
            }
        });
    });
        })
    </script>
    <script>
var loadFile = function (event) {
  var image = document.getElementById("output");
  image.src = URL.createObjectURL(event.target.files[0]);
};

    </script>
    @endpush
@endsection
