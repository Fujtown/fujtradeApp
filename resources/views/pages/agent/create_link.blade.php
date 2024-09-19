@extends('layouts.admin') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<style>
    /* .d-none{
        display: none;
    } */
</style>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Fujtrade</a></li>
                            <li class="breadcrumb-item active">New Link</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create New Link</h4>
                    <br>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" value="{{$limit_amount}}" id="limit_amount">
                                <form id="createLink" action="">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">Select Link Type</label>
                                        <div class="col-sm-8">
                                            <select name="payment_type" class="custom-select paymentType">
                                                <option value="close">Close</option>
                                                <option value="open">Open</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Select Currency</label>
                                        <div class="col-sm-8">
                                            <select name="currency" id="currency" class="custom-select">
                                                <option value="USD">USD ($)</option>
                                                <option value="AED">AED (aed)</option>
                                                <option value="EUR">EUR (€)</option>
                                                <option value="GBP">GBP (£)</option>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Amount</label>
                                        <div class="col-sm-8">
                                            <input name="amount" class="form-control" type="number" value="" id="amount">
                                        </div>
                                    </div>
                                    
                                     <div class="form-group row">
                                      <label for="kycUpload" class="col-sm-4 col-form-label">Upload KYC</label>
                                      <div class="col-sm-8">
                                        <input type="file" name="kyc_files[]" id="kycUpload" class="form-control" multiple>
                                      </div>
                                    </div>
                                     <input type="hidden" name="temp_inv" id="temp_inv">
                                    <input type="hidden" value="" id="result">

                                    <div class="form-group row">
                                        <div class="col-md-4">&nbsp;</div>
                                        <div class="col-sm-8">
                                           <input type="button" class="btn btn-info generate"  style="display:none;" value="Generate">
                                        </div>
                                    </div>
                                </form>
                                <input type="hidden" id="share_link">
                                <div class="share">
                                   <!-- <a href="whatsapp://send?text=The text to share!" data-action="share/whatsapp/share">Share via Whatsapp</a> -->
<h2>Share Link?</h2>

<ul class="list-inline share" data-social-share>
            <li>
                <a id="copy-link" data-text="Copy Link" style="border: none;cursor: pointer;" ><img style="width: 24px;" src="{{ asset('admin_assets/icons/copy.png') }}" /></a>
            </li>
            <li>
              <a href="javascript:void(0)" data-social="whatsapp" data-text="From Page Bottom Share Section">
                <img src="{{asset('admin_assets/icons/whatsapp.png')}}" alt="">
              </a>
            </li>
            <li>
              <a href="javascript:void(0)" data-social="telegram" data-text="From Page Bottom Share Section">
                <img src="{{asset('admin_assets/icons/telegram.png')}}" alt="">
              </a>
            </li>
          </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end col -->

                </div><!--end row-->


            </div><!--end col-->


        </div><!--end row-->




    </div> <!-- end container -->
</div>
<!-- end wrapper -->
@push('scripts')

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 {{-- <script src="{{asset('admin_assets/js/share.js')}}"></script> --}}
  <script>
  document.addEventListener('DOMContentLoaded', function () {
       var num = Math.floor(Math.random() * 100000) + 1;
    //   alert(num)
      document.getElementById('temp_inv').value=num;
    const kycUpload = document.getElementById('kycUpload');
    const generateButton = document.querySelector('.generate');

   document.getElementById('kycUpload').addEventListener('change', function() {
    var formData = new FormData();
    var files = document.getElementById('kycUpload').files;
     var inv_num = document.getElementById('temp_inv').value;
    var generateButton = document.querySelector('.generate'); // Get the generate button

    for (var i = 0; i < files.length; i++) {
        formData.append('kyc_files[]', files[i]);
    }

    // Append other form data as needed
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('temp_inv', inv_num);
    fetch('{{ route("agent.uploadKyc") }}', {
        method: 'POST',
        body: formData,
    })
    .then(response => {
        if(response.ok) {
            // If the HTTP status code is 200-299
            return response.json(); // Parse JSON body of the response
        }
        throw new Error('Network response was not ok.'); // Handle HTTP response errors
    })
    .then(data => {
        console.log(data.message);
        if (data.success === true) {
            Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: data.message,
                            didClose: () => {
                                generateButton.style.display = 'inline-block';
                            }
                            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        generateButton.style.display = 'none'; // Optionally hide the button on error
    });
});

  });
</script>
<script>
    $(document).ready(function() {
        $('.share').hide();
    })
       //Fetch data from Payment gateway and store into database
       $('.generate').click(function() {
                    $(".generate").attr( "disabled", "disabled" );
                    $(".generate").text('Loading...');
                    var data = new FormData(document.getElementById("createLink"));

                    $.ajax({
                        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                         url: '{{ url('coffee/agent/store_link') }}',
                         type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                        //   alert(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
                            didClose: () => {
                                $('.share').show();
                                $('#share_link').val(response.url);
                                // location.reload();
                                $(".generate").removeAttr("disabled");
                                $(".generate").text('Generate');
                                $('#amount').val('');
                                $('.generate').css('display', 'none');
                            }
                            });

                            // Refresh your table or UI here
                        },
                        error: function(error) {
                            Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.responseJSON.message,
                        didClose: () => {

                            $(".generate").removeAttr("disabled");
                            $(".generate").text('Generate');
                            }
                        });
                        }
                    });
                });


    navigator.isMobileTablet = (function () {
	var check = false;
	(function (a) {
		if (
			/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
				a
			) ||
			/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
				a.substr(0, 4)
			)
		)
			check = true;
	})(navigator.userAgent || navigator.vendor || window.opera);
	return check;
})();

jQuery('a[data-social]').on('click', function (e) {
    e.preventDefault();

    var BASE_URL = $('#share_link').val();
    var ele = jQuery(this);
    var isMobileTablet = navigator.isMobileTablet;
    var shareUrl = "";
    var socialType = ele.attr('data-social');
    var title = document.title;
    var url = BASE_URL + "bnat/" + "?";
    var urlQueryParams;
    var queryParams;
    var sharePlace = ele.attr('data-text');
    switch (socialType) {
      case 'whatsapp':
        url = url + jQuery.param({
          utm_campaign: 'BNAT-Share-' + socialType,
          utm_source: socialType,
          utm_medium: 'referral',
        });
        if(navigator.isMobileTablet){
          shareUrl = 'https://api.whatsapp.com/send?text=' + url;
        }else{
         shareUrl = 'https://web.whatsapp.com/send?text=' + encodeURIComponent(url);
        }
        break;



      case 'telegram':
        url = url + jQuery.param({
          utm_campaign: 'BNAT-Share-' + socialType,
          utm_source: socialType,
          utm_medium: 'referral'
        });
        queryParams = jQuery.param({
          url: url,
          text: title
        });
        shareUrl = "https://telegram.me/share/url?" +queryParams;
        break;


      default:
        ;
    }

    window.open(shareUrl, "BNAT Social Sharing", "width=550, height=420, left=" + (screen.availWidth - 500) / 2 + ", top=" + (screen.availHeight - 500) / 2 + ", location=0, menubar=0, toolbar=0, status=0, scrollbars=1, resizable=1");
  });

     // When the "Copy Text" button is clicked
     $(document).on('click','#copy-link',function() {
                //  alert()
                // var id=$(this).data('id');
                // Get the text to copy
                var textToCopy = $('#share_link').val();

                // Create a temporary input element
                var tempInput = $("<input>");
                $("body").append(tempInput);

                // Set the input element's value to the text you want to copy
                tempInput.val(textToCopy).select();

                // Execute the copy command
                document.execCommand('copy');

                // Remove the temporary input element
                tempInput.remove();

                // Show a success message (you can customize this part)
                alert("URL copied to clipboard: " + textToCopy);
            });



</script>

<script>

    // Async function to convert currency
async function convertCurrency(fromCurrency, toCurrency, amount) {
     const formattedAmount = parseFloat(amount.replace(/,/g, ''));
     const apiKey = "{{ env('CURRENCY_API_KEY') }}";
    const url = `https://v6.exchangerate-api.com/v6/${apiKey}/pair/${fromCurrency}/${toCurrency}/${formattedAmount}`;

    try {
        const response = await fetch(url);
        const data = await response.json();
        if (data.result === "success") {
            return data.conversion_result;
        } else {
            console.error('Currency conversion error:', data['error-type']);
            return null;
        }
    } catch (error) {
        console.error('Fetch error:', error);
        return null;
    }
}

// Use async event handler for the blur event on the #amount input
var limit_amount=$('#limit_amount').val();
if(limit_amount > 0) {
$('#amount').on('blur', async function(){
    var amount = $(this).val();
    var currency = $('#currency').val();

    // If the selected currency is USD, apply a direct limit
    if(currency === 'USD') {
        let limit = 500;
        if(amount < limit) {
            alert(`Amount should be greater than ${limit_amount} USD`);
            $(this).val('');
        }
    } else {
        // For other currencies, convert the limit first
        let convertedLimit = await convertCurrency('USD', currency, limit_amount);
        if(convertedLimit !== null) {
            $('#result').val(convertedLimit.toFixed(2));
            let convert_amount = parseFloat($('#result').val());
            console.log(convert_amount);
            if(amount < convert_amount) {
                alert(`Amount should be greater than ${convert_amount.toFixed(2)} ${currency}`);
                $(this).val('');
            }
        }
    }
});
}

</script>
@endpush
@endsection
