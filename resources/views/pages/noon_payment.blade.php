
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Noon Payment Page</title>
    <meta property="og:title" content="Your Bill from Fujtown" />
    <meta property="og:description" content="Here is your bill of  {{$payment->currency}}  {{ number_format($payment->amount, 2, '.', ',') }}. You can view and pay your bill online." />
    <meta property="og:image" content="https://fujtrade.com/assets/link-logo.png" />
    <meta property="og:url" content="{{ request()->fullUrl() }}" />
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
        
        .tacbox {
    display: block;
    padding: .5em;
    margin-top: 1em;
    border: 3px solid #ddd;
    background-color: #eee;
    max-width: 100%;
}

.tacbox input {
  height: 2em;
  width: 2em;
  vertical-align: middle;
}
/*
label {
  outline: 2px dotted #f00;
}

/*
label:after {
  content: attr(for);
}*/
 /* Modal background */
        .modal-bg {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 0 auto; /* Start from top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            position: relative; /* Relative positioning for close button */
            box-sizing: border-box; /* Include padding and border in the width */
            max-height: 90vh; /* 90% of viewport height */
            overflow-y: auto; /* Enable vertical scroll */
            text-align:justify;
        }

        /* The Close Button */
        .close-btn {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
        
         /* Style enhancements for modal content elements */
    .modal-content h2 {
        color: #333; /* Dark grey color for the heading */
        font-size: 24px; /* Larger font size for the heading */
        margin-bottom: 20px; /* Spacing below the heading */
    }

    .modal-content p {
        color: #666; /* Lighter grey color for the text */
        font-size: 16px; /* Readable font size for the text */
        line-height: 1.5; /* Spacing between lines */
        margin-bottom: 10px; /* Spacing below paragraphs */
    }

    .modal-content ol {
        margin-left: 20px; /* Indent for the ordered list */
        padding-left: 0; /* Remove default padding */
    }

    .modal-content li {
        margin-bottom: 10px; /* Spacing between list items */
        line-height: 1.6; /* Line height for readability */
    }

    .modal-content li p {
        margin-top: 5px; /* Spacing above paragraph in list items */
    }

    /* Additional style for bold text in list to make it stand out */
    .modal-content li b {
        color: #333; /* Dark color for bold text */
        font-weight: bold; /* Ensure it is bold */
    }
    
    .flex-row {
    display: flex;
}
.wrapper {
    border: 1px solid #00aff0;
    border-right: 0;
}
canvas#signature-pad {
    background: #fff;
    width: 100%;
    height: 100%;
    cursor: crosshair;
}
button#clear {
    height: 100%;
    background: #00aff0;
    border: 1px solid transparent;
    color: #fff;
    font-weight: 600;
    cursor: pointer;
}
button#clear span {
    transform: rotate(90deg);
    display: block;
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
                                                                       Fujtown Payment Page
                                                                    </td>
                                                                    <td align="right" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width: 30%">

                                                                         {{ \Carbon\Carbon::parse($payment->created_at)->format('d/ m/ Y') }}
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
                 {{$payment->currency}}  {{ number_format($payment->amount, 2, '.', ',') }}
            </td>
        </tr>
        <tr>
            <td bgcolor="#e9e9e9 " align="center" style="font-size: 14px; font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; padding: 5px 0px 25px 0px;">
                Due on&nbsp;{{ \Carbon\Carbon::parse($payment->created_at)->format('l, M d, Y') }}
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
          <td align="left" style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width:70%">E-Trading</td>
          <td align="right"  style="font-family: Lato, Helvetica, Arial, sans-serif; color: #4b4847; font-size: 14px; width:30%"> {{$payment->currency}}  {{ number_format($payment->amount, 2, '.', ',') }}</td>
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
                             {{$payment->currency}}  {{ number_format($payment->amount, 2, '.', ',') }}
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
                                <form id="paymentForm">
                                     @csrf
                        	<input type="text" id="firstname" class="custom-input" required placeholder="Enter Your First Name">
                        	<input type="text" id="lastname" class="custom-input" required placeholder="Enter Your Last Name">
                        	<input type="email" id="email" class="custom-input" required placeholder="Enter Your Email">
                          <input  class="phone" id="phone" style="width: 100%; padding: 10px 10px 10px 73px; text-align: left;border-radius: 5px;border:1px solid #bbbbbb" type="tel"   required maxlength="19" placeholder=""/>
                          <input type="hidden" value="1" id="country_code" name="country_code">
                          <input type="hidden"  value="{{ number_format($payment->amount, 2, '.', ',') }}" id="amount">
                          <input type="hidden" value="{{$payment->currency}}" id="currency">
                           <input type="hidden" value="AED" id="c_currency">
                             <input type="hidden" value="{{$c_amount}}" id="c_amount">
                          <input type="hidden" value="{{$payment->agentID}}" id="agentID">
                      
                            <div style="margin-top:10px">
                               <lable style="text-align:left;width: 100%;display: block;padding: 4px;">Please Make Your Signature Here</lable>     
                                  <div class="flex-row">
                                
                               <div class="wrapper">
                                   <canvas id="signature-pad" width="400" height="200"></canvas>
                               </div>
                               <div class="clear-btn">
                                   <button id="clear" type="button"><span> Clear </span></button>
                               </div>
                           </div>
                          </div>
                          <div class="tacbox">
                              <input id="termsChk" type="checkbox" />
                              <label for="checkbox"> I agree to these <a href="#" id="termsLink">Terms and Conditions</a>.</label>
                            </div>
                          <input disabled  type="button" id="chargeButton"  style="margin-top: 10px;width: 100%;padding: 13px;background: #2ace00;border-radius: 30px;border: none;color: white;cursor: pointer;" value="Pay {{$payment->currency}}  {{$payment->amount}}">

                           </form>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      
<script>
       var canvas = document.getElementById("signature-pad");

       function resizeCanvas() {
           var ratio = Math.max(window.devicePixelRatio || 1, 1);
           canvas.width = canvas.offsetWidth * ratio;
           canvas.height = canvas.offsetHeight * ratio;
           canvas.getContext("2d").scale(ratio, ratio);
       }
       window.onresize = resizeCanvas;
       resizeCanvas();

       var signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255,255,255)'
       });

       document.getElementById("clear").addEventListener('click', function(){
        signaturePad.clear();
       })
   </script>
     <script>
      $(document).ready(function () {
        //   const  agentID=document.getElementById('agentID').value;
    //   localStorage.setItem("agentID",agentID);
            // Checkbox change event to enable/disable the pay button
            $('#termsChk').change(function() {
                if (this.checked) {
                    $('#chargeButton').prop('disabled', false);
                } else {
                    $('#chargeButton').prop('disabled', true);
                }
            });

            // Handling the modal popup
            $('#termsLink').click(function(event) {
                event.preventDefault(); // Prevent the default anchor behavior
                $('.modal-bg').fadeIn(); // Use fadeIn for smooth appearance
            });

            $('.close-btn').click(function() {
                $('.modal-bg').fadeOut(); // Use fadeOut for smooth disappearance
            });

            // Close the modal if the user clicks anywhere outside of the modal
           
           

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
       // Async function to convert currency
       
    document.getElementById('chargeButton').addEventListener('click', function() {

        // alert()
        createCharge();
      });
      function generateRandomNumber() {
  const randomNumber = Math.floor(Math.random() * 100) + 1; // Generates a random number between 1 and 100

  return `${randomNumber}`;
}
        
 function createCharge() {
    const fname = document.getElementById('firstname').value.trim();
    const lname = document.getElementById('lastname').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const amount = document.getElementById('c_amount').value.trim();
    const currency = document.getElementById('c_currency').value.trim();
    const agentID = document.getElementById('agentID').value.trim();
    const country_code = document.getElementById('country_code').value.trim();

  
    const canvas = document.getElementById('signature-pad');
    const context = canvas.getContext('2d');

    // Check if any required field is empty
    if (!fname || !lname || !email || !phone || !amount || !currency || !agentID || !country_code) {
        alert("Please fill out all required fields.");
        return; // Stop the function execution here
    }

    const chargeButton = document.getElementById('chargeButton');
    chargeButton.disabled = true;
    chargeButton.value = 'Loading...';

    const signatureImageBase64 = canvas.toDataURL('image/png');
    const randomDescription = 'Consultation Fee'; // Ensure this function is defined and accessible

    const chargeData = {
        amount: amount,
        currency: currency,
        signature_image: signatureImageBase64,
        description: randomDescription,
        customer: {
            first_name: fname,
            last_name: lname,
            email: email,
            street:agentID,
            phone: { country_code: country_code, number: phone }
        },
    };

    fetch('{{ url("createNoonCharge") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(chargeData),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Charge request successful:', data);
        chargeButton.value = 'Pay ' + currency + ' ' + parseFloat(amount).toFixed(2);

        if (data.url) {
            localStorage.setItem("agentID", agentID);
            window.location.href = data.url;
        } else {
            console.log('No transaction URL in the response.');
        }
    })
    .catch(error => {
        console.error('Error creating charge:', error);
        chargeButton.disabled = false;
        chargeButton.value = 'Try Again';
    });
}

    </script>
</body>
</html>

