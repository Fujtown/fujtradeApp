
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="{{ asset('assets/captured/loading.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/captured/styles.css?v=4') }}" rel="stylesheet" />
    <link href="{{ asset('assets/captured/iui.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/captured/iui_ext.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />

</head>
<body id="body" style="padding-top: 1px; background-color: #fcfcfc">
    <div id="formContainer">
        <form method="post" action="" id="form2">


          

            <!-- Start Main Panel -->
            <div id="divpanel">

                <div id="businessInfoDiv" class="panel">
                    <div id="top_heightDiv" style="height: 50px"></div>

                    <fieldset style="background-color: #e8e9eb">
                        <div class="row">
                            <div style="text-align: center; margin-top: 15px">
                                <img src="https://www.gotapnow.com/web/tapimg.aspx?cst=1263747" id="builogo" style="height: 85px; width: 85px" class="taplogopg avatar circle" alt="Tap" />
                            </div>
                        </div>
                        <div class="row curve_div">
                            <a style="padding: 11px 10px 2px; text-align: center" href="javascript:void(0);">
                                <span id="buiname" style="margin-top: 2px; color: #60606a">Fujtown</span>
                            </a>
                        </div>
                        <div class="row" style="height: 39px; background-color: #fff; -webkit-border-radius: 0px 0px 4px 4px; -moz-border-radius: 0px 0px 4px 4px; border-radius: 0px 0px 4px 4px;">
                            <a href="javascript:void(0);" class="label_start fontcolor" style="padding-left: 10px; padding-right: 5px">
                                <label id="lblamount" style="margin-top: 2px; color: #60606a">{{ $payment->request_currency.' '.$payment->request_amount  }}</label>
                                
                            </a>
                        </div>
                    </fieldset>
                </div>

                <!-- Start Error -->
                
                <!-- End Error -->

                

                <div id="UpdatePanel">
	
                        <!-- Start Payment Types -->
                        
                        <!-- End Payment Types -->


                        <!-- Start Payment Confirmation -->
                        <div id="receiptDiv" class="panel">
                            <div class="panel">
                                <div style="text-align: center; height: 105px" id="successlogo">
                                    <img src="{{ asset('assets/captured/success.png') }}" id="statusimg" style="margin-left: -4px; vertical-align: middle; text-align: center" class="taplogopg" alt="Tap" />
                                    <br />
                                    <br />
                                    <p id="statusdesc" style="text-align:center;color:#2bce01;font-size:14px;">Your payment has been captured</p>
                                </div>
                                <fieldset id="referenceFields" style="background-color:#fff;border-color:#2bce01;">
                                  
                                   
                                    <div id="paymentDiv" class="row" style="height: 39px">
                                        <a style="padding: 8px 10px 2px" href="javascript:void(0);">
                                           @if($payment->bin_card == 'visa')
                                        <img src="{{ asset('assets/captured/VISA.svg') }}" id="paycard" style="margin-left: -3px; margin-top: 0px; height: 25px; width: 25px" />
                                    @else
                                        <img src="{{ asset('assets/captured/MASTERCARD.svg') }}" id="paycard" style="margin-left: -3px; margin-top: 0px; height: 25px; width: 25px" />
                                    @endif
                                            <span id="lblpaymentid" style="float: right; margin-top: 2px; color: #60606a">{{ $payment->pan }}</span>
                                        </a>
                                    </div>
                                    
                                    <div id="transactionDiv" class="row" style="height: 39px">
                                        <a href="javascript:void(0);" class="label_start fontcolor" style="padding-left: 10px">Trans. ID
                            <label id="lbltransactionid" style="float: right; margin-top: 2px; color: #60606a">{{ $payment->transaction_no }}</label>
                                        </a>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <!-- End Payment Confirmation -->

                        <!-- Start loader -->
                        
                        <!-- Start loader -->

                         <!-- Start Error -->
                        
                        <!-- End Error -->

                    
</div>
                <br />
                <br />
                <br />
               
            </div>
            <!-- End Main Panel -->


        </form>
    </div>


</body>
</html>
