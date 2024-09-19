@extends('layouts.app') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
   <!-- header end -->
        <!-- breadcrumb content begin -->
<style>
    .error {
    color: red;
    font-size: 0.8em;
}
</style>
        <!-- breadcrumb content end -->
    <main>
    <!-- section content begin -->
    <div class="uk-section">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-center in-contact-6">
                <div class="uk-width-1-1">

                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3612.385559758177!2d56.3230812!3d25.1226526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ef4f893d64b21d3%3A0xc860ab9f9930206d!2sFujtown!5e0!3m2!1sen!2sae!4v1705317648113!5m2!1sen!2sae" class="uk-width-1-1 uk-height-large uk-border-rounded google_map"  ></iframe>
                </div>
                <div class="uk-width-3-5@m">
                    <div class="uk-grid uk-child-width-1-3@m uk-margin-medium-top uk-text-center" data-uk-grid="">
                        <div>
                            <h5 class="uk-margin-remove-bottom">Address</h5>
                            <p class="uk-margin-small-top">Creative Tower, Office 808 - Fujairah, UAE</p>
                        </div>
                        <div>
                            <h5 class="uk-margin-remove-bottom">Email</h5>
                            <p class="uk-margin-small-top uk-margin-remove-bottom">hello@fujtown.com</p>
                            <p class="uk-text-small uk-text-muted uk-text-uppercase uk-margin-remove-top">for public inquiries</p>
                        </div>
                        <div>
                            <h5 class="uk-margin-remove-bottom">Call</h5>
                            <p class="uk-margin-small-top uk-margin-remove-bottom">050 370 2600</p>
                            <p class="uk-text-small uk-text-muted uk-text-uppercase uk-margin-remove-top">Mon - Fri, 9am - 6pm</p>
                        </div>
                    </div>
                    <hr class="uk-margin-medium">
                    <h4 class="uk-margin-remove-bottom uk-text-muted uk-text-center">Have a questions?</h4>
                  <h1 class="uk-margin-small-top uk-text-center">Let's <span class="in-highlight">get in touch</span></h1>
                    <form id="contactForm" class="uk-form uk-grid-small uk-margin-medium-top" data-uk-grid="">
                        @csrf
                        <div class="uk-width-1-2@s uk-inline">
                            <span class="uk-form-icon fas fa-user fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="name" name="name" type="text" placeholder="Full name">
                            <span class="error" id="error-name"></span>
                        </div>
                        <div class="uk-width-1-2@s uk-inline">
                            <span class="uk-form-icon fas fa-envelope fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="email" name="email" type="email" placeholder="Email address">
                            <span class="error" id="error-email"></span>
                        </div>
                        <div class="uk-width-1-1 uk-inline">
                            <span class="uk-form-icon fas fa-pen fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="subject" name="subject" type="text" placeholder="Subject">
                            <span class="error" id="error-subject"></span>
                        </div>
                        <div class="uk-width-1-1">
                            <textarea class="uk-textarea uk-border-rounded" id="message" name="message" rows="6" placeholder="Message"></textarea>
                            <span class="error" id="error-message"></span>
                        </div>
                        <div class="uk-width-1-1">
                            <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded send" id="sendemail" type="button" name="submit">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    </main>
@push('scripts')
<script>
    $(document).on('click','.send',function(){
        var data = new FormData(document.getElementById("contactForm"));

        $.ajax({
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
            url: "{{ url('/save_contact') }}",
            type: "POST",
            data: data,
            processData: false,
            contentType: false,
            success: function(response) {
                alert('Message sent successfully!');
                location.reload();
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
</script>
@endpush
@endsection

