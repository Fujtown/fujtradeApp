@extends('layouts.app') <!-- Extending the master layout -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content') <!-- Defining the content section -->
<main class="main">
    <style>
        .card-comm1{
            background:linear-gradient(180deg, #343434 0%, #000 100%);
width: 24%;
margin: auto;
height: 130px;
text-align: center;
padding: 0;
border-radius: 5px;
position: relative;
        }
        .card-img{
            width: 50px;
        padding-top: 20px;
        }
     .details{
            position: absolute;
        bottom: 0;
        width: 100%;
        color: white;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 15px;
        }
        .details table tr{
            text-align: center;
            color: white;
        }
        .details table{
            width: 100%;
        }
        .card-comm2{
            background: linear-gradient(180deg, #BBAC91 0%, #5E5649 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }
        .card-comm3{
            background: linear-gradient(180deg, #2B1115 0%, #0B0405 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }
        .card-comm4{
            background: linear-gradient(180deg, #603813 0%, #130B04 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }
        .card-comm5{
            background:linear-gradient(180deg, #60A4EF 0%, #0B3A6A 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }
        .card-comm6{
            background:linear-gradient(180deg, #39A23F 0%, #297E2D 36.67%, #051B06 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }
        .card-comm7{
            background:linear-gradient(180deg, #cddc39 0%, #2e4e0d 100%, #689f38 100%);
            width: 24%;
            margin: auto;
            height: 130px;
            text-align: center;
            padding: 0;
            border-radius: 5px;
            position: relative;
        }

        @media only screen and (max-width: 768px) {
.card-comm1,.card-comm2,.card-comm3,.card-comm4,.card-comm5,.card-comm6,.card-comm7 {
  width: 90%;
  margin-left: 35px;
}
}

    </style>
    <!-- slideshow content begin -->
    <div class="uk-section uk-padding-remove-vertical">
        <div class="in-slideshow uk-visible-toggle dark-slide" data-uk-slideshow>
            <ul class="uk-slideshow-items">
                <li>
        <div class="uk-container">
            <div class="uk-grid" data-uk-grid>
                <div class="uk-width-1-2@m">
                    <div class="uk-overlay">
                        <h1>Get more <span class="in-highlight">freedom</span> in the markets.</h1>
                        <h4>Let top <span class="in-highlight">traders</span> do the job for you!</h4>
                        <p class="uk-text-lead uk-visible@m">All types of e-trading from a single account</p>
                        <div class="in-slideshow-button">
                            <a href="#open_sec" class="uk-button uk-button-primary uk-border-rounded">Open account</a>
                            <!-- <a href="#" class="uk-button uk-button-default uk-border-rounded uk-margin-small-left uk-visible@m">Discover account</a> -->
                        </div>
                        <p>*Trading is highly speculative and carries a high level of risk.</p><br>

                        <!-- <p class="uk-text-small"><span class="uk-text-primary">*</span>Trading in Forex/ CFDs is highly speculative and carries a high level of risk.</p> -->
                    </div>
                </div>
                <div class="uk-position-center">
                    <img src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-slideshow-image-1.png') }}" alt="slideshow-image" width="862" height="540" data-uk-img>
                </div>
            </div>
        </div>
    </li>
            </ul>
            <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
            <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
            <div class="uk-container in-slideshow-feature uk-visible@m">
                <div class="uk-grid uk-flex uk-flex-center">
                    <div class="uk-width-3-4@m">
                        <div class="uk-child-width-1-4" data-uk-grid>
                            <div class="uk-flex uk-flex-middle">
                                <div class="in-icon-wrap small circle uk-box-shadow-small uk-margin-small-right">
                                    <i class="fas fa-drafting-compass"></i>
                                </div>
                                <div>
                                    <p class="uk-text-bold uk-margin-remove">Enhanced Tools</p>
                                </div>
                            </div>
                            <div class="uk-flex uk-flex-middle">
                                <div class="in-icon-wrap small circle uk-box-shadow-small uk-margin-small-right">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div>
                                    <p class="uk-text-bold uk-margin-remove">Trading Guides</p>
                                </div>
                            </div>
                            <div class="uk-flex uk-flex-middle">
                                <div class="in-icon-wrap small circle uk-box-shadow-small uk-margin-small-right">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div>
                                    <p class="uk-text-bold uk-margin-remove">Fast execution</p>
                                </div>
                            </div>
                            <div class="uk-flex uk-flex-middle">
                                <div class="in-icon-wrap small circle uk-box-shadow-small uk-margin-small-right">
                                    <i class="fas fa-percentage"></i>
                                </div>
                                <div>
                                    <p class="uk-text-bold uk-margin-remove">5% Commission</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slideshow content end -->
    <!-- section content begin -->
    <div id="tsparticles" style="display: none">
        <img src="{{ asset('assets/img/layer2.svg') }}" alt="">
    </div>


    <div class="uk-section uk-section-muted in-padding-large-vertical@s in-profit-1">
        <div class="uk-container">
            <div class="uk-grid-divider" data-uk-grid>
                <div class="uk-width-expand@m in-margin-top-20@s">
                    <h2>Why Fujtrade is a trusted commercial broker for e-trading</h2>
                    </div>
                <div class="uk-width-2-3@m">
                    <div class="uk-child-width-1-2@s uk-child-width-1-2@m" data-uk-grid>
                        <div class="uk-flex uk-flex-middle">
                            <div class="uk-margin-right">
                                <img src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-profit-icon-1.svg') }}" alt="profit-icon" width="72" height="72" data-uk-img>
                            </div>
                            <div>
                                <p class="uk-text-bold uk-margin-remove">Wide Range of Trading Instruments</p>
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <div class="uk-margin-right">
                                <img src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-profit-icon-2.svg') }}" alt="profit-icon" width="72" height="72" data-uk-img>
                            </div>
                            <div>
                                <p class="uk-text-bold uk-margin-remove">Unparalleled Trading Conditions</p>
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-middle">
                            <div class="uk-margin-right">
                                <img src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-profit-icon-3.svg') }}" alt="profit-icon" width="72" height="72" data-uk-img>
                            </div>
                            <div>
                                <p class="uk-text-bold uk-margin-remove">A Mix Of Traditional And Modern Trading</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- section content begin -->
    <div style="display: none" class="element">
        <img src="{{ asset('assets/img/el3.png') }}" alt="">
    </div>
    <div class="uk-section uk-padding-large in-padding-large-vertical@s uk-background-contain in-profit-2" data-src="{{ asset('assets/img/in-profit-decor-3.svg') }}" data-uk-img>
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-center">
                <div class="uk-width-1-2@m uk-text-center">
                    <h2>Experience more than Trading.</h2>

                    <i class="fas fa-chevron-down uk-text-primary"></i>
                </div>
                <div class="uk-width-5-6@m">
                    <div class="uk-child-width-1-2@s uk-child-width-1-2@m uk-margin-medium-top" data-uk-grid>
                        <div>
                            <div class="in-pricing-1">
                                <div class="uk-card uk-card-default uk-box-shadow-medium">
                                    <div class="uk-card-media-top">
                                        <img class="uk-width-1-1 uk-align-center" src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-profit-content-1.jpg') }}" width="460" height="368" alt="sample-image" data-uk-img>
                                      <span></span>
                                    </div>
                                    <div class="uk-card-body">
                                        <div class="in-heading-extra in-card-decor-1">
                                            <h2 class="uk-margin-remove-bottom">Economic</h2>
                                            <p class="uk-text-lead">Analysis</p>
                                        </div>
                                        <p class="uk-margin-small-top">For FujTrade, a e-trading platform specializing in various financial instruments, conducting an economic analysis is vital for strategic planning, risk management, and offering value to its users. Here’s a concise summary of how economic analysis benefits FujTrade</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="in-pricing-1">
                                <div class="uk-card uk-card-default uk-box-shadow-medium">
                                    <div class="uk-card-media-top">
                                        <img class="uk-width-1-1 uk-align-center" src="/assets/img/in-lazy.gif" data-src="{{ asset('assets/img/in-profit-content-2.jpg') }}" width="460" height="368" alt="sample-image" data-uk-img>
                                      <span></span>
                                    </div>
                                    <div class="uk-card-body">
                                        <div class="in-heading-extra in-card-decor-2">
                                            <h2 class="uk-margin-remove-bottom">Technical</h2>
                                            <p class="uk-text-lead">Analysis</p>
                                        </div>
                                        <p class="uk-margin-small-top">Technical analysis is a critical component for trading platforms like FujTrade, offering users insights into market trends, asset price movements, and potential trading opportunities based on historical market data and statistical analysis. Here's a concise overview of how technical analysis is employed at FujTrade.</p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-1-1">
                            <div class="uk-grid uk-grid-divider uk-grid-match in-profit-tradestatus" data-uk-grid>
                                <div class="uk-width-1-1 uk-width-auto@m">
                                    <div class="uk-flex uk-flex-left uk-flex-center@m">
                                        <div class="uk-grid uk-grid-small uk-flex-middle">
                                            <div class="uk-width-auto">
                                                <div class="in-icon-wrap circle primary-color">
                                                    <i class="fas fa-chart-line fa-2x"></i>
                                                </div>
                                            </div>
                                            <div class="uk-width-expand">
                                                <h1 class="uk-margin-remove-bottom">324,978,126</h1>
                                                <p class="uk-text-uppercase uk-text-primary uk-text-small uk-margin-remove-top">Trades Opened at Profit</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-width-1-1 uk-width-expand@m uk-flex-middle">
                                    <p class="uk-text-lead">Trade & Invest in Stocks, Currencies, Indices, and Commodities (CFDs).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- section content begin -->
    <div id="tsparticles" style="display: none">
        <img src="{{ asset('assets/img/layer.svg') }}" alt="">
    </div>

    <div class="uk-section uk-section-secondary uk-padding-large uk-background-contain uk-background-bottom-center in-padding-large-vertical@s in-profit-3" style="background-repeat: no-repeat;background-position: center;" data-src="{{ asset('assets/img/in-section-profit-3.png') }}" data-uk-img>
        <div class="uk-container uk-margin-small-bottom">
            <div class="uk-grid-large" data-uk-grid>
                <div class="uk-width-1-2@m custom-index">
                    <h2>We are committed to meeting your e-trading needs</h2>
                    <p class="uk-text-lead" style="text-align: justify;">At Fujtrade (Known as Fujtown), we dedicate ourselves to offering unparalleled e-trading services to our clients. Our commitment to excellence and customer satisfaction has been the cornerstone of our success. We take pride in engaging with over 5000 customers, providing them with top-notch e-trading experiences.
                    </p>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-child-width-1-2@s uk-child-width-1-3@m uk-margin-small-top" data-uk-grid>
                        <div>
                            <h1 class="uk-heading-bullet">
                                <span class="count" data-counter-end="5">Customers Trust Us</span>5K+
                            </h1>
                            <p class="blur-bg">Fujtrade is a trusted name in e-trading and commercial brokerage. We have successfully built a large and satisfied customer base, serving more than 5000 clients who rely on us for their trading needs.</p>
                        </div>
                        <div>
                            <h1 class="uk-heading-bullet">
                                High Success Rate
                            </h1>
                            <p class="blur-bg">Our clients enjoy a high success rate in their trading endeavors, thanks to our robust and expert guidance. </p>
                        </div>
                        <div>
                            <h1 class="uk-heading-bullet">
                                Dedicated to Your Trading Success
                            </h1>
                            <p class="blur-bg">Our team at Fujtrade is dedicated to helping you achieve your trading goals. We understand the intricacies of e-trading and commercial brokerage and strive to provide you with the resources and support necessary to navigate the market successfully.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- section content begin -->
    <div class="uk-section uk-padding-remove-bottom in-offset-bottom-40 in-profit-4" id="open_sec">
        <div class="uk-container uk-margin-top">
            <div class="uk-grid uk-flex uk-flex-center" data-uk-grid>
                <div class="uk-width-5-6@m">
                    <div class="uk-grid uk-flex-middle" data-uk-grid>
                        <div class="uk-width-expand@m">
                            <h2>Connect to global capital markets</h2>
                        </div>
                        <div class="uk-width-3-5@m">
                            <p class="uk-text-lead">Currently serving more than 10+ countries including the UK, Singapore, Australia, Malaysia, and some parts of Europe.</p>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div id="currency-cards-container" class="uk-child-width-1-2@s uk-child-width-1-5@m in-profit-stockprice" data-uk-grid>
                        <div class="card-comm1">
                         <img class="card-img" src="{{ asset('assets/img/oil.jpg') }}" alt="">
                         <div class="details">
                            <table>
                             <tbody>
                                 <tr>
                                     <td>USOUSD</td>
                                     <td>$ 77.836</td>
                                 </tr>
                                 <tr><td>US Spot</td>
                                     <td>7.25%</td>
                                 </tr>
                             </tbody>
                            </table>
                         </div>
                        </div>
                        <div  class="card-comm2">
                          <img class="card-img"  src="{{ asset('assets/img/cotton.jpg') }}" alt="">
                         <div class="details">
                             <table>
                              <tbody>
                                  <tr>
                                      <td>Cotton</td>
                                      <td>$ 9244</td>
                                  </tr>
                                  <tr><td>Cotton Spot</td>
                                      <td>12.95%</td>
                                  </tr>
                              </tbody>
                             </table>
                          </div>
                     </div>
                        <div class="card-comm3">
                          <img class="card-img" src="{{ asset('assets/img/coca.jpg') }}" alt="">
                         <div class="details">
                             <table>
                              <tbody>
                                  <tr>
                                      <td>COCOA</td>
                                      <td>$ 5658.3</td>
                                  </tr>
                                  <tr><td>Ny Cococa Spot</td>
                                      <td>31.83%</td>
                                  </tr>
                              </tbody>
                             </table>
                          </div>
                     </div>
                     <div class="card-comm4">
                         <img class="card-img"  src="{{ asset('assets/img/coffee.jpg') }}" alt="">
                        <div class="details">
                            <table>
                             <tbody>
                                 <tr>
                                     <td>COFFEE</td>
                                     <td>$ 18790.9</td>
                                 </tr>
                                 <tr><td>Coffee Arabica Spot</td>
                                     <td>5.19%</td>
                                 </tr>
                             </tbody>
                            </table>
                         </div>
                    </div>
                    <div class="card-comm5">
                     <img class="card-img"  src="{{ asset('assets/img/natgas.jpg') }}" alt="">
                    <div class="details">
                        <table>
                         <tbody>
                             <tr>
                                 <td>NATGAS</td>
                                 <td>$ 1716.75</td>
                             </tr>
                             <tr><td>Natural Gas</td>
                                 <td>-37.75%</td>
                             </tr>
                         </tbody>
                        </table>
                     </div>
                </div>

                    <div class="card-comm6">
                     <img class="card-img"  src="{{ asset('assets/img/soya.jpg') }}" alt="">
                    <div class="details">
                        <table>
                         <tbody>
                             <tr>
                                 <td>SOYA</td>
                                 <td>$ 1143.75</td>
                             </tr>
                             <tr><td>soyabean</td>
                                 <td>-7.05%</td>
                             </tr>
                         </tbody>
                        </table>
                     </div>
                </div>
                    <div class="card-comm7">
                     <img class="card-img"  src="{{ asset('assets/img/sugar.png') }}" alt="">
                    <div class="details">
                        <table>
                         <tbody>
                             <tr>
                                 <td>Sugar</td>
                                 <td>$ 22.62</td>
                             </tr>
                             <tr><td>sugar</td>
                                 <td>-0.21%</td>
                             </tr>
                         </tbody>
                        </table>
                     </div>
                </div>
                     </div>
                </div>
                <div class="uk-width-5-6@m uk-margin-medium-bottom">
                    <div class="uk-grid-large uk-flex-middle" data-uk-grid>
                        <div class="uk-width-auto@m">
                            <h4 class="uk-margin-remove-bottom uk-text-primary">Ready to trade?</h4>
                            <p class="uk-margin-remove-top">Get started with your trading account today.</p>
                        </div>
                        <div class="uk-width-expand@m">
                            <form class="uk-grid-small" data-uk-grid>
                                <div class="uk-width-1-1 uk-width-expand@m">
                                    <input class="uk-input uk-border-rounded dark-input" type="text" id="email" placeholder="Email address...">
                                </div>
                                <div class="uk-width-1-1 uk-width-expand@m">
                                    <input id="checkbox_terms" type="checkbox" />
                                    <label for="checkbox"> I agree to these <a href="#ex1" rel="modal:open" class="term_link">Terms and Conditions</a>.</label>
                                  </div>
                                <div class="uk-width-1-1 uk-width-auto@m">
                                    <button type="button" id="open_account"  class="uk-button uk-button-primary uk-border-rounded uk-width-expand">Open Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-1 uk-margin-medium-top">
                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    <!-- Terms & condition model -->
      <div id="ex1" class="modal">
        @include('partials.term_contract')
        <a href="#" rel="modal:close" class="modal_close">Close</a>
      </div>
    </main>
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
<!-- first include any tsParticles plugin needed -->
   <script>
//     $(document).ready(function() {
//     $.ajax({
//         url: 'https://marketdata.tradermade.com/api/v1/live?currency=EURGBP,GBPJPY,EURUSD,GBPUSD,USDJPY,USDCHF,AUDUSD,USDCAD,XAUUSD&api_key=MamjTqERYEg5GonVz_7f',
//         type: 'GET',
//         dataType: 'json',
//         success: function(response) {
//             // Parse and display each currency data
//             $.each(response.quotes, function(index, currency) {
//                 var currencyPair = currency.base_currency + currency.quote_currency;
//                 var currencyValue = currency.mid;
//                 var changeDirection = 'up'; // Placeholder for direction logic

//                 // Create and append the currency card
//                 $('#currency-cards-container').append(
//                     '<div><div class="uk-card uk-card-body uk-card-small uk-card-default uk-border-pill">' +
//                     '   <span class="uk-float-left" style="position: relative;top: 10px;">' +
//                     '   <h5>'+currencyPair+'</h5>'+
//                     '   </span>' +
//                     '   <span style="position: relative;top: 10px;" class="uk-float-right ' + changeDirection + '">' +
//                     '       <i class="fas fa-arrow-' + (changeDirection === 'up' ? 'up' : 'down') + '"></i>' + currencyValue.toFixed(5) +
//                     '   </span>' +
//                     '</div></div>'
//                 );
//             });
//         },
//         error: function(error) {
//             console.log('Error fetching currency data:', error);
//         }
//     });
// });


    $(document).ready(function(){
        // Get the CSRF token value from the meta tag

//         $('#open_account').click(function() {
//             var csrfToken = $('meta[name="csrf-token"]').attr('content');

// // Set up your AJAX request with the CSRF token
// $.ajaxSetup({
//     headers: {
//         'X-CSRF-TOKEN': csrfToken
//     }
// });
//     $.ajax({
//         url: '{{ url('/generate_pdf') }}',
//         type: 'POST',
//         data: {
//             name: 'John Doe',
//             date: '2024-01-11',
//             email: 'john@example.com',
//             phone: '1234567890'
//         },
//         success: function(response) {
//             if (response.success) {
//                 // Redirect or handle the generated PDF URL here
//                 window.location.href = response.pdf_url;
//             } else {
//                 alert('Error generating PDF');
//             }
//         },
//         error: function() {
//             alert('Error generating PDF');
//         }
//     });
// });
       $('#open_account').on('click',function () {
        $(this).prop("disabled",true);
        $(this).text('Loading Please Wait...');
        if (!$('#checkbox_terms').is(':checked')) {
            alert('Please checked Terms and Conditions before Open Account');
        }
        else{
            let data = {};
        let email=$('#email').val();
        // alert(email)
        data={
            email:email
        }
            localStorage.setItem('user_set_data',JSON.stringify(data));
            let userInfo = localStorage.getItem('user_set_data');
            if (userInfo) {
            let filter = JSON.parse(userInfo);

            window.location.href="{{ url('/signup') }}";

            }
        //     if (userInfo) {
        //     let filter = JSON.parse(userInfo);

        //     // Check if filter is an array and not empty
        //     if (filter && Object.keys(filter).length > 0) {
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ url('/open_account') }}",
        //         contentType: 'application/json',
        //         data: JSON.stringify({
        //         email,
        //         "_token": "{{ csrf_token() }}"
        //     }),
        //         success: function (response) {
        //             if(response.status=='success')
        //             {
        //                 alert(response.message);
        //             $('#open_account').prop("disabled",false);
        //             $('#open_account').text('Open Account');
        //             location.reload()
        //             }
        //             else{
        //                 alert(response.message);
        //                 $('#open_account').prop("disabled",false);
        //             $('#open_account').text('Open Account');
        //             }

        //         }
        //     });
        //     } else {
        //         alert('Email');
        //     }
        // } else {
        //     alert('No user data found');
        // }
        }

     })

    })

   </script>

@endpush

@endsection
