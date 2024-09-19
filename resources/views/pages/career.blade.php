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

                <div class="uk-width-3-5@m">

                    <!-- <hr class="uk-margin-medium"> -->
                    <h4 class="uk-margin-remove-bottom uk-text-muted uk-text-center">Work with us</h4>
                  <h1 class="uk-margin-small-top uk-text-center">Let's <span class="in-highlight">Submit Your CV</span></h1>
                    <form id="contactForm" class="uk-form uk-grid-small uk-margin-medium-top" data-uk-grid="">

                        <div class="uk-width-1-1@s uk-inline">
                            <span class="uk-form-icon fas fa-user fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="name" name="name" type="text" placeholder="Full name">
                            <span class="error" id="error-name"></span>
                        </div>
                        <div class="uk-width-1-1@s uk-inline">
                            <span class="uk-form-icon fas fa-envelope fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="email" name="email" type="email" placeholder="Email address">
                            <span class="error" id="error-email"></span>
                        </div>
                        <div class="uk-width-1-1@s uk-inline">
                            <span class="uk-form-icon fas fa-graduation-cap fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="email" name="profession" type="text" placeholder="Enter Your Profession">
                            <span class="error" id="error-email"></span>
                        </div>
                        <div class="uk-width-1-1 uk-inline">
                            <span class="uk-form-icon fas fa-pen fa-sm"></span>
                            <!-- <input class="uk-input uk-border-rounded" id="subject" name="subject" type="text" placeholder="Describe Your Career"> -->
                            <textarea name=""  class="uk-input uk-border-rounded"  id="" cols="5" style="height: 100px;" rows="15" placeholder="Tell Us About Your Self"></textarea>
                            <span class="error" id="error-subject"></span>
                        </div>

                        <div class="uk-width-1-1@s uk-inline">
                            <span class="uk-form-icon fas fa-file fa-sm"></span>
                            <input class="uk-input uk-border-rounded" id="email" name="cv" type="file" placeholder="Select CV">
                            <span class="error" id="error-email"></span>
                        </div>

                        <div class="uk-width-1-1">
                            <button class="uk-width-1-1 uk-button uk-button-primary uk-border-rounded send" id="sendemail" type="button" name="submit">Submit CV</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    </main>

@endsection

