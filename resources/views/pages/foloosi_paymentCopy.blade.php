
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Foloosi Payment Page</title>
    <meta name="csrf-token" content="HmTaGqjkTd1F2b3hXRZlrhsUhnauVPY46KP5qaA7">
    <meta property="og:title" content="Your Bill from Fujtown" />
    <meta property="og:description" content="Here is your bill of GBP 250. You can view and pay your bill online." />
    <meta property="og:image" content="https://fujtrade.com/assets/link-logo.png" />
    <meta property="og:url" content="https://fujtrade.com/payment/255145" />
    <meta property="og:type" content="website" />
     <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
	 <link rel="stylesheet" id="ls-google-fonts-css" href="https://fonts.googleapis.com/css?family=Lato:100,300,regular,700,900" type="text/css" media="all">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/css/intlTelInput.css"  />

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style type="text/css">
        /* CLIENT-SPECIFIC STYLES */

        .iti__flag {background-image: url("/assets/img/flags.png");}

@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  .iti__flag {background-image: url("https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/img/flags@2x.png");}
}
.iti{
  width: 100%;
}
 .custom-input {
	margin:5px 0;
	padding:10px 5px;
	width:100%;
	outline:none;
	border:1px solid #bbb;
	border-radius:5px;
	display:inline-block;
	-webkit-box-sizing:border-box;
	   -moz-box-sizing:border-box;
	        box-sizing:border-box;
    -webkit-transition:0.2s ease all;
	   -moz-transition:0.2s ease all;
	    -ms-transition:0.2s ease all;
	     -o-transition:0.2s ease all;
	        transition:0.2s ease all;
}

        #outlook a {
            padding: 0;
        }
        /* Force Outlook to provide a "view in browser" message */

			 .sub-container{
            width: 480px;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }
            /* Force Hotmail to display emails at full width */

            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
                line-height: 100%;
            }
        /* Force Hotmail to display normal line spacing */

        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        /* Prevent WebKit and Windows mobile changing default text sizes */

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        /* Remove spacing between tables in Outlook 2007 and up */

        img {
            -ms-interpolation-mode: bicubic;
        }
        /* Allow smoother rendering of resized image in Internet Explorer */
        /* RESET STYLES */

        body {
            margin: 0;
            padding: 0;
            background: #BBD2C5;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #536976, #BBD2C5);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #536976, #BBD2C5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0;
            padding: 0;
            width: 100% !important;
        }
        /* iOS BLUE LINKS */

        .appleBody a {
            color: #68440a;
            text-decoration: none;
        }

        .appleFooter a {
            color: #999999;
            text-decoration: none;
        }

        a:link {
            color: #00aff0;
            text-decoration: none;
        }

        a:visited {
            color: #00aff0;
            text-decoration: none;
        }

        a:hover {
            color: #00aff0;
            text-decoration: none;
        }

        a:active {
            color: #00aff0;
            text-decoration: underline;
        }

        .buttonLink a:link {
            color: #ffffff;
            text-decoration: none;
        }

        .buttonLink a:visited {
            color: #ffffff;
            text-decoration: none;
        }

        .buttonLink a:hover {
            color: #ffffff;
            text-decoration: none;
        }

        .buttonLink a:active {
            color: #ffffff;
            text-decoration: underline;
        }
        /* MOBILE STYLES */

        @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {

		 .sub-container{
                width: 95%;
            }

            /* ALLOWS FOR FLUID TABLES */
            table[class="wrapper"] {
                width: 100% !important;
            }
            /* ADJUSTS LAYOUT OF LOGO IMAGE */
            td[class="logo"] {
                text-align: left;
                padding: 20px 0 20px 0 !important;
            }

                td[class="logo"] img {
                    margin: 0 auto !important;
                }
            /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                max-width: 100% !important;
                height: auto !important;
            }
            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: left !important;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="no-pad"] {
                padding: 0 0 20px 0 !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 50px 15px 0 15px !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 90% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }



        }
    </style>
    <script type="text/javascript">
        $(document).ready(function () {
            if (navigator.userAgent.indexOf("mobile-version") > -1) {
                var top = $("#billRow").offset().top;
                top += 30;
                $("#billRow").offset({
                    top: top
                });
            }
        });
    </script>
</head>

<body style=" width: 100% !important; height: 100%;">
    <!--[if mso]><style type="text/css ">body, table, td, a {font-family:  Helvetica, Arial, sans-serif !important;}</style><![endif]-->
    <table class="main_table" style=" width: 100%; font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847;">
        <tbody>
            <tr id="billRow ">
                <td width="100% " align="center">
                    <!--[if mso]><center><table><tr><td width="500 "><![endif]-->
                    <div class="sub-container">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                                <tr>
                                    <td bgcolor="#f6f6f6 " align="center" style="padding: 5px;">
                                        <!-- View End -->
                                        <!-- Header 2 -->
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="padding: 15px 10px 15px 10px">
                                                        <table cellpadding="0 " cellspacing="0 " border="0" width="100%" style="padding: 15px 0;">
                                                            <tbody>
                                                                <tr style="padding: 0 10px">
                                                                    <td align="left" id="billLabel" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width: 70%">
                                                                       Foloosi Payment Page
                                                                    </td>
                                                                    <td align="right" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width: 30%">

                                                                        14/ 03/ 2024
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- Header 3 -->
                                        <!--STATUS-->
                                        <!-- Main Table -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td bgcolor="#f6f6f6 " align="center">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-radius: 3px; border-left: 1px solid #e9e9e9; border-right: 1px solid #e9e9e9;" class="responsive-table">
<tbody>
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td>
<table width="100%" cellspacing="0" cellpadding="0">
    <tbody>
		<!-- tax -->
        <tr>
            <td bgcolor="#e9e9e9 " align="center" style="padding-top: 30px">
                <img alt="Fujtown " src="https://www.gotapnow.com/web/tapimgEmail.aspx?cst=1263747" width="70" height="70" style="display: block; font-family: Helvetica, Arial, sans-serif; color: #666666; font-size: 16px; margin: auto;" border="0">
            </td>
        </tr>
        <tr>
            <td bgcolor="#e9e9e9" align="center" style="font-size: 16px; font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; padding-top: 5px;">
                Fujtown
            </td>
        </tr>
        <tr>
            <td bgcolor="#e9e9e9 " align="center" style="font-size: 36px; font-family: Lato, Helvetica, Arial, sans-serif; font-weight: 300; color: #4b4847; padding-top: 10px;">
                GBP  250.00
            </td>
        </tr>
        <tr>
            <td bgcolor="#e9e9e9 " align="center" style="font-size: 14px; font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; padding: 5px 0px 25px 0px;">
                Due on&nbsp;Thursday, Mar 14, 2024
            </td>
        </tr>
		<!--businesscontact-->
    </tbody>
</table>
</td>
</tr>
<tr>
<td bgcolor="#ffffff " style="padding: 25px 5% 0 5%;">
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tbody>
        <tr><td style="padding: 0px 0px 10px 0px;"><table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>
          <td align="left" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width:70%">Consultation</td>
          <td align="right"  style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width:30%"> GBP  250.00</td>
        </tr></table></td></tr>

        <tr>
            <td style="padding: 10px 0px; border-top: 1px solid #4b4847; border-bottom: 1px solid #4b4847;">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="left" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width: 70%">
                                Total
                            </td>
                            <td align="right" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width: 30%">
                             GBP  250.00
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td style="padding: 20px 0px;"></td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 0px 0px 5px 0px; font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px;">

                        	<input type="text" id="firstname" class="custom-input" required placeholder="Enter Your First Name">
                        	<input type="text" id="lastname" class="custom-input" required placeholder="Enter Your Last Name">
                        	<input type="email" id="email" class="custom-input" required placeholder="Enter Your Email">
                          <input  class="phone" id="phone" style="width: 100%; padding: 10px 10px 10px 73px; text-align: left;border-radius: 5px;border:1px solid #bbbbbb" type="tel"   required maxlength="19" placeholder=""/>
                          <input type="hidden" value="1" id="country_code" name="country_code">
                          <input type="hidden"  value="250.00" id="amount">
                          <input type="hidden" value="GBP" id="currency">
                          <input type="hidden" value="9" id="agentID">
                          <input type="button" onclick="initializeFoloosiPayment()" id="chargeButton"  style="margin-top: 10px;width: 100%;padding: 13px;background: #326bd1;border-radius: 30px;border: none;color: white;cursor: pointer;" value="Pay GBP  250">

                        </td>
                    </tr>



    </tbody>
                            </table>
                            </td>
                            </tr>
                            <!--referencenumber-->
                            <!--comments-->
                            <tr>
                            <td bgcolor="#f6f6f6">
                            <img class="img-max" style="width: 100%;" src="https://www.gotapnow.com/web/tmem/zigzag.png" />
                            </td>
                            </tr>

                            </tbody>
                            </table>
                            </td>
                            </tr>

                            </tbody>
                            </table>
                            </td>
                            </tr>

                            </tbody>
                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <!-- EmailFooter End -->
                                            <tr>
                                                <td align="center" style="font-size: 12px; line-height: 18px; font-family: Lato, Helvetica, Arial, sans-serif; color: #aaaaaa;">
                                                    Copyright &copy; 2024 Fujtrade. All rights reserved.
                                                </td>
                                            </tr>
                                          
                                        </table>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <!--[if mso]></td></tr></table></center><![endif]-->
                </td>
            </tr>

        </tbody>
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/intlTelInput.min.js"></script>
    <script type="text/javascript" src="https://www.foloosi.com/js/foloosipay.v2.js"></script>
     <script>
      $(document).ready(function () {

            // Initialize the intlTelInput library
   var input = document.querySelector(".phone");
   var iti = window.intlTelInput(input, {
       separateDialCode: true,

       utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/18.2.1/js/utils.min.js", // Make sure to include this script
               preferredCountries: ['us', 'gb', 'ae'], // Prioritize US, UK, and UAE
        dropdownContainer: document.body
   });

   // Update the hidden input with the selected country code
   input.addEventListener("countrychange", function () {
       var country_code = iti.getSelectedCountryData().dialCode;
       document.querySelector("#country_code").value = country_code;
   });

      });
</script>
    <script>
  <script>
  
function initializeFoloosiPayment() {
    const form = document.getElementById('paymentForm');

    const data = {
        transaction_amount: form.transaction_amount.value,
        currency: form.currency.value,
        customer_name: form.customer_name.value,
        customer_email: form.customer_email.value,
        customer_mobile: form.customer_mobile.value,
        customer_address: form.customer_address.value,
        customer_city: form.customer_city.value,
        customer_unique_identifier: form.customer_email.value,
    };

    fetch("https://api.foloosi.com/aggregatorapi/web/initialize-setup", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'merchant_key': 'test_$2y$10$TMIVMBba1E-1b2Li4lGCfuy-Tk3WetSd17RwbUcgaoYXidJznGN4S' // Replace with your merchant key
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(d => {
        if (d && d.data && d.data.reference_token) {
            var options = {
                "reference_token": d.data.reference_token,
                "merchant_key": "test_$2y$10$TMIVMBba1E-1b2Li4lGCfuy-Tk3WetSd17RwbUcgaoYXidJznGN4S", // Replace with your merchant key
            };
            var fp1 = new Foloosipay(options);
            fp1.open();

            
        } else {
            console.error("Failed to initialize payment");
        }
    })
     foloosiHandler(response, function (e) {
          if(e.data.status == 'success'){
            //responde success code
            console.log(e.data.data);
            handlePaymentSuccess(e.data.data.transaction_no,e.data.status);
          }
          if(e.data.status == 'error'){
            //responde success code
            console.log(e.data.status);
             handlePaymentSuccess(e.data.data.transaction_no,e.data.status);
          }
          if(e.data.status == 'closed'){
            //Payment Popup Closed
            console.log(e.data);
          }
        });
        
        function handlePaymentSuccess(transaction_no,status) {
    // Example AJAX call to Laravel route for saving payment data
    // Construct the datas object, converting empty strings to null
let datas = {
    transaction_no: transaction_no || null
};
    fetch('/save-Foloosipayment-data', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(datas)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success data saved:', data);
        window.location.href = '/foloosi-success?status=' + encodeURIComponent(status);
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
            
}
</script>
</body>
</html>

