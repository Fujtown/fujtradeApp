


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>
      Tap - Bill & Collect (@Fujtown)
 </title>

    <script src="https://pgp.payments.tap.company/gosell/v2/Scripts/jquery-1.10.2.min.js"></script>
    <link href="https://pgp.payments.tap.company/gosell/v2/css/loading.css" rel="stylesheet" />
    <link href="https://pgp.payments.tap.company/gosell/v2/css/styles.css?v=4" rel="stylesheet" />
    <link href="https://pgp.payments.tap.company/gosell/v2/css/iui.css" rel="stylesheet" />
    <link href="https://pgp.payments.tap.company/gosell/v2/css/iui_ext.css" rel="stylesheet" />
    <link href="https://pgp.payments.tap.company/gosell/v2/css/intlTelInput.css?v=1.9" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />

</head>
<body id="body" style="padding-top: 1px; background-color: #fcfcfc">
    <div id="formContainer">
        <form method="post" action="./tap.aspx?dest=tap&amp;inv=SOf%2fGCP%2fCy7WmCecOXDToet1JFxLWBIe&amp;sess=knTTv8AAprQ%3d&amp;token=SOf%2fGCP%2fCy7WmCecOXDToTBVdCIx8X3p&amp;for=share" id="form2">


<script src="/WebResource.axd?d=iLj-5DLfbwZkqsSbC0-CLsIxSX8hAkAe3tWnAdes83e_3ncG9BliEfQq1rNAGsLG4zn2BjBFc2J9_WvI5zE-vG6qcX3yxRsFMcR7CLHS0a01&amp;t=638259470771233176" type="text/javascript"></script>


<script src="/ScriptResource.axd?d=b5H-xUcYxy5KBj0g1f_fNhEMdainzz82Q1q6_xq6h2ugoAsm_KgCsiDAl9ETG_cei2PbIbOb_GKNIGPZQl42XuNFj9U8pKzzl5LWticyx9nRv5oE5gX3sjma4am3KQanbGB9pU2H7R66JmJdcYMf01ap-gu3Bks5QXZb-PA5JpE1&amp;t=5d0a842b" type="text/javascript"></script>
<script src="/ScriptResource.axd?d=t7fX_Rg6zKh2MvR34franZrK9wz3yYb-ZCP21XeI4LJEnxH4XEOac5by1-YOvTd5V8fGvug9KA2bFSDIisVUepnuLfQr72d5cDIbmeRgNvBs_n-_4Wl28u3CVom7BJ27I9dlOkJLM7AOvjYMjXyNcuPTRm1o6zLzZn2Rw0ozHAOKR7srcI5O1qRG5yzRhsqZ0&amp;t=5d0a842b" type="text/javascript"></script>
<div class="aspNetHidden">

	<input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="86539358" />
	<input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEdAAXKWUPLcqPB6MU/JE4G7Y00tAgYaPZxv+u4VQd/yeqMI5O2Gnt0Do0At4+AheBSxrM9ZqdnhWwG6Z2wYT7hIKvkJXTsdokE2Q2EOD1Q+ovHhQ6DYOkg73SzugtBtMhHEgSAlQH0jPubEnoC6zISyksA" />
</div>


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
                                <label id="lblamount" style="margin-top: 2px; color: #60606a">{{ $details->currency }} {{ $details->amount }}</label>
                                
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
                                    <img src="https://gocollect.io/images/success.png" id="statusimg" style="margin-left: -4px; vertical-align: middle; text-align: center" class="taplogopg" alt="Tap" />
                                    <br />
                                    <br />
                                    <p id="statusdesc" style="text-align:center;color:#2bce01;font-size:14px;">Your payment has been captured</p>
                                </div>
                                <fieldset id="referenceFields" style="background-color:#fff;border-color:#2bce01;">
                                    <div id="billnoDiv" class="row" style="height: 39px">
                                        <a href="javascript:void(0);" class="label_start fontcolor" style="padding-left: 10px">Bill No
                            <label id="lblbillnumber" style="float: right; margin-top: 2px; color: #60606a">{{ $details->ch_id }}</label>
                                        </a>
                                    </div>
                                    <div class="row" style="height: 39px">
                                        <a style="padding: 8px 10px 2px" href="javascript:void(0);">
                                            <img src="https://gocollect.io/images/receipt.png" style="margin-left: -8px; margin-top: -6px; height: 35px; width: 35px" />
                                            <span id="lblreceiptnumber" style="float: right; margin-top: 3px; color: #60606a">{{ $details->receipt }}</span>
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
                <!-- Start Tap logo in the footer -->
                <div style="text-align: center">
                    <a href="javascript:void(0);" style="cursor: default">
                        <img style="width: 30px" src="https://gocollect.io/images/taplogo.png" /></a>
                </div>
                <!-- End Tap logo in the footer -->
                <!-- Start Tap footer -->
             
                <!-- End Tap footer -->
                <div style="height: 5px"></div>
                <!-- Start Thwate SSL Logo -->
              
                <!-- End Thwate SSL Logo -->
                <br />
            </div>
            <!-- End Main Panel -->


        </form>
    </div>


</body>
</html>
