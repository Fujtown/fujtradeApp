@extends('layouts.app') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<style>

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
                <h1>Refund Request</h1>
            </div>
            <div class="uk-width-1-1@m">
                <div class="uk-grid uk-child-width-1-1@m uk-margin-small-top uk-text-center" data-uk-grid="">

                    <div>
                        {{-- <h5 class="uk-margin-remove-bottom">Insert Information</h5> --}}
                        <form id="refundForm" class="uk-form uk-grid-small uk-margin-medium-top" data-uk-grid="">
                            <div data-uk-grid="" class="uk-form uk-grid-small uk-margin-medium-top">
                            @csrf
                            <div class="uk-width-1-2@s uk-inline">
                                <span class="uk-form-icon fas fa-money fa-sm">&nbsp;&nbsp;</span>
                                <input class="uk-input uk-border-rounded" id="refund_amount" name="refund_amount" value="" type="number" placeholder=" Refund Amount">
                                <span class="error" id="error-refund_amount"></span>
                            </div>

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

                            <div class="uk-width-1-2@s uk-inline">
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
                                <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded refund" id="update_info" type="button" name="submit">Send Request</button>
                            </div>
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
        $(document).on('click','.refund',function(){
            var data = new FormData(document.getElementById("refundForm"));
            var amount=$('#refund_amount').val();
            if(amount > 0)
            {
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: "{{ url('/customer_refund_request') }}",
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
                } else {
                    Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: 'An error occurred. Please try again.',
                      });
                }
            }
            });

            // Clear specific error messages when input becomes valid
    ['fname','lname' ,'email', 'phone', 'refund_amount'].forEach(function(field) {
        $('#' + field).on('input', function() {
            if (this.checkValidity()) {
                $('#error-' + field).text('');
            }
        });
    });
            }
            else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Refund amount cannot be zero',
                });
            }

        })
    </script>
    @endpush
@endsection
