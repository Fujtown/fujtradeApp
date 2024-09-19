@extends('layouts.adminauth') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
{{-- <div class="accountbg"></div> --}}
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                    <div class="text-center mt-2 mb-4">
                        <a href="{{route('admin')}}" class="logo logo-admin">
                            <img src="{{ asset('admin_assets/images/logo4.png') }}" height="120" alt="logo">
                        </a>
                    </div>

                    <div class="px-3 pb-3">
                        <form class="form-horizontal m-t-20" id="loginForm" action="javascript:void(0);">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" id="email" name="email" type="email" required="" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input class="form-control" id="password" name="password" type="password" required="" placeholder="Password">
                                </div>
                            </div>



                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-danger btn-block waves-effect waves-light login" type="button">Log In</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-7 m-t-20">
                                    <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> <small>Forgot your password ?</small></a>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @push('scripts')
<script>
    $(document).on('click','.login',function(){
        var data = new FormData(document.getElementById("loginForm"));

        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "{{ url('/admin_login') }}",
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
                    if(response.user_type == 'superadmin')
                    {
                        window.location.href = '{!! url('coffee/dashboard') !!}';
                    }
                    else if(response.user_type == 'admin')
                    {
                        window.location.href = '{!! url('coffee/admin/dashboard') !!}';
                    }
                    else if(response.user_type == 'agent')
                    {
                        window.location.href = '{!! url('coffee/agent/create_link') !!}';
                    }
                    else if(response.user_type == 'member')
                    {
                        window.location.href = '{!! url('coffee/member/dashboard') !!}';
                    }
                    else{
                        window.location.href = '{!! url('coffee/management/dashboard') !!}';
                    }

                }
            });
            },
            error: function(response) {
            if(response.status === 422) { // Validation error
                let errors = response.responseJSON.errors;
                Object.keys(errors).forEach(function (key) {
                    // $('#error-' + key).text(errors[key][0]);
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: errors[key][0],
                  });
                });
            }
            else {
                Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: response.responseJSON.message,
                  });
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
