
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
 					<h1 id="status">Please wait...</h1>
                    <p id="paymentStatusMessage"></p>
                     <input type="hidden" id="noon_id" value="{{ $noon_id }}">

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

     <script>
//         $(document).ready(function() {
//     if (localStorage.getItem('pageLoaded')) {
//         // Prevent further code execution or alert the user
//         alert('You cannot refresh the page.');
//         // Potentially redirect them away or disable the page
//         window.location.href = '{{ url('home') }}';
//     } else {
//         // Set the flag that the page has been loaded
//         localStorage.setItem('pageLoaded', 'true');
//     }
// });
        // Perform AJAX request when the page loads
        document.addEventListener('DOMContentLoaded', function () {
            var agentID=localStorage.getItem("agentID");

            $(".home").attr( "disabled", "disabled" );
                    $(".home").text('Loading...');
          performAjaxRequest('{{ $noon_id }}',agentID);
          getLastPayment('{{ $noon_id }}');
        });

        function displayPaymentStatusMessage(status) {
    var statusMessage = '';
            // console.log(status)
    switch (status) {
        case 'CAPTURED':
            statusMessage = 'Payment has been successfully captured.';
            break;
        case 'AUTHORIZED':
            statusMessage = 'Payment has been authorized.';
            break;
        case 'INITIATED':
            statusMessage = 'Payment initiation is in progress.';
            break;
        case 'INPROGRESS':
            statusMessage = 'Payment is currently in progress.';
            break;
        case 'ABANDONED':
            statusMessage = 'Payment has been abandoned.';
            break;
        case 'CANCELLED':
            statusMessage = 'Payment has been canceled.';
            break;
        case 'DEFERRED':
            statusMessage = 'Payment has been deferred.';
            break;
        case 'EXPIRED':
            statusMessage = 'Payment has expired.';
            break;
        case 'FAILED':
            statusMessage = 'Payment has failed.';
            break;
        case 'VOID':
            statusMessage = 'Payment has been voided.';
            break;
        case 'TIMEDOUT':
            statusMessage = 'Payment has timed out.';
            break;
        case 'UNKNOWN':
            statusMessage = 'Payment status is unknown.';
            break;
        default:
            statusMessage = 'Invalid payment status.';
            break;
    }

    document.getElementById("paymentStatusMessage").innerHTML = statusMessage;

    // Display the status message in the console or on the page
    console.log(statusMessage);
}

        function performAjaxRequest(noon_id,agentID) {
            
          const options = {
            method: 'GET',
            headers: {
              accept: 'application/json'
            }
          };

          fetch(`{{ url('save_noon_payment_data') }}?noon_id=${noon_id}`, options)
            .then(response => response.json())
            .then(data => {
              console.log('Charge details:', data);
            })
            .catch(err => console.error(err));
        }

        function getLastPayment(noon_id) {
          const options = {
            method: 'GET',
            headers: {
              accept: 'application/json'
            }
          };

          fetch(`{{ url('get_noon_last_payment') }}?noon_id=${noon_id}`, options)
            .then(response => response.json())
            .then(data => {
                console.log(data.status)
              if(data.status)
              {

                document.getElementById("status").innerHTML=data.status;
                var paymentStatus =data.status;
                displayPaymentStatusMessage(paymentStatus);

                $(".home").removeAttr("disabled");
                    $(".home").text('HOME');
              }
              // Handle the response data as needed
            })
            .catch(err => console.error(err));
        }
      </script>
 </body>
 </html>


