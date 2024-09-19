<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<meta charset="utf-8">
	<title>Payment Status</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://jthemes.net/themes/html/wizard-form/popup/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://jthemes.net/themes/html/wizard-form/popup/assets/css/fontawesome-all.css">
	<link rel="stylesheet" href="https://jthemes.net/themes/html/wizard-form/popup/assets/css/style.css">
</head>

<body>
<style>
    @media only screen and (max-width: 668px) {
        .popup-wrapper.popup-wrapper-style-one .popup-text h1{
            font-size: 50px
        }
    }
</style>
 <!-- Start of popup section
 	============================================= -->
 	<section id="popup-one" class="popup-one-section">
 		<div class="container">
 			<div class="popup-wrapper popup-wrapper-style-one">
 				<div class="popup-close text-center">x</div>
 				<div class="popup-text text-center">
 				     @if($status === 'success')
 					<h1 id="status">Captured</h1>
                    <p id="paymentStatusMessage"> Thank you for your payment!</p>
                     @elseif($status === 'failed')
                     <h1 id="status">Failed</h1>
                    <p id="paymentStatusMessage">There was an issue with your payment. Please try again.</p>
                          
                        @else
                         <h1 id="status">Failed</h1>
                    <p id="paymentStatusMessage">Payment status is unknown. Please contact support if you think this is an error.</p>
                           
                        @endif   
                         
                        
                    

 					<a class="d-block text-center home" href="/home">Home</a>
 				</div>

 			</div>
 		</div>
 	</section>
 <!-- End of popup section
 	============================================= -->

 	<script src="https://jthemes.net/themes/html/wizard-form/popup/assets/js/jquery-3.3.1.min.js"></script>
 	<script src="https://jthemes.net/themes/html/wizard-form/popup/assets/js/bootstrap.min.js"></script>
 	<script src="https://jthemes.net/themes/html/wizard-form/popup/assets/js/main.js"></script>
