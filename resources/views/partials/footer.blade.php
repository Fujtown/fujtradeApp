<script>
    const themeSwitcher = document.querySelector('input[type=checkbox]');
const darkCircle = document.querySelector('.darkCircle');
const lightCircle = document.querySelector('.lightCircle');
const body = document.querySelector('body');

themeSwitcher.addEventListener('change', () => {
// Using jQuery
// $.ajax({
//     url: '/set-session', // The URL to your route
//     type: 'POST',
//     data: {
//         key: 'mode',  // Replace with your session key
//         value: 'yourSessionValue' // Replace with your session value
//     },
//     headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
//     },
//     success: function(response) {
//         console.log(response);
//     },
//     error: function(error) {
//         console.error(error);
//     }
// });

});

</script>
<footer>
    <div class="uk-section uk-section-secondary uk-padding-large uk-padding-remove-horizontal uk-margin-medium-top footer-section">
        <div class="uk-container">
            <div class="uk-child-width-1-2@s uk-child-width-1-4@m uk-flex uk-margin-small-top" data-uk-grid="">
                <div>
                    <h4 class="uk-heading-bullet">Overview</h4>
                    <ul class="uk-list uk-link-text">
                        <li><a href="#">Stock indices</a></li>
                        <li><a href="#">Commodities</a></li>
                        <li><a href="#">Forex</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="uk-heading-bullet">Company</h4>
                    <ul class="uk-list uk-link-text">
                        <li><a href="{{ route('about') }}">About</a></li>
                        <!-- <li><a href="#">Blog</a></li> -->
                        <li><a href="{{ route('career') }}">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="uk-heading-bullet">Legal</h4>
                    <ul class="uk-list uk-link-text">
                        <li><a href="{{ route('terms') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('terms') }}#pds">Product Disclosure Statement</a></li>
                        <li><a href="{{ route('terms') }}#fsg">Financial Services Guide</a></li>
                        <!-- <li><a href="#">Privacy &amp; Policy</a></li> -->
                        <!-- <li><a href="#">Contact</a></li> -->
                    </ul>
                </div>

                <div class="uk-flex-first uk-flex-last@m" style="text-align: center;display: flex;flex-direction: column;align-items: center;">
                    <div class="footer-logo">
                        <img class="uk-display-block" src="{{ asset('assets/img/logo4.png') }}" style="" alt="footer-logo" width="150" height="36" data-uk-img="">
                    </div>
                    <ul class="uk-list uk-link-text uk-margin-remove-top">
                        <li><a href="#"><i class="fas fa-envelope uk-margin-small-right"></i>hello@fujtown.com</a></li>
                        <li><a href="#"><i class="fas fa-map-marker-alt uk-margin-small-right"></i>Fujairah, UAE</a></li>
                    </ul>
                </div>
            </div>
            <div class="uk-grid uk-flex uk-flex-center uk-margin-large-top uk-margin-small-bottom" data-uk-grid="">
                <div class="uk-width-5-6@m uk-margin-bottom">
                    <div class="footer-warning in-margin-top-20@s">
                        <h5 class="uk-text-small uk-text-uppercase"><span>E Trading</span></h5>
                        <p class="uk-text-small">Online Trading is a method that facilitates buying and selling of financial instruments such as mutual funds, equities, bonds, Sovereign gold bonds, derivatives, stocks, ETFs and commodities through an electronic interface, and buying and selling shares, bonds, foreign currencies, cryptocurrencies, and other financial instruments online.</p>
                    </div>
                </div>
                <div class="uk-width-5-6@m uk-margin-bottom">
                    <div class="footer-warning in-margin-top-20@s">
                        <h5 class="uk-text-small uk-text-uppercase"><span>Risk Warning</span></h5>
                        <p class="uk-text-small">Trading derivatives and leveraged products carries a high level of risk, including the risk of losing substantially more than your initial investment. It is not suitable for everyone. Before you make any decision in relation to a financial product you should obtain and consider our Product Disclosure Statement (PDS) and Financial Services Guide (FSG) available on our website and seek independent advice if necessary </p>
                    </div>
                </div>
                <div class="uk-width-1-2@m">
                    <p class="copyright-text">© Fujtrade Inc 2024. All rights reserved.</p>
                </div>
                <div class="uk-width-1-2@m uk-flex uk-flex-right@m">
                    <!-- social media begin -->
                    <div class="uk-flex social-media-list">
                        <div><a href="https://www.instagram.com/fujtown/" class="color-instagram text-decoration-none"><i class="fab fa-instagram"></i> Instagram</a></div>
                    </div>
                    <!-- social media end -->
                </div>
            </div>
        </div>
    </div>
</footer>
