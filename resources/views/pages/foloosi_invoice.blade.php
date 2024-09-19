<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice</title>
<style>
  body {
    font-family: Trebuchet MS;
    margin: 0;
    padding: 0;
    font-size: 12px;
  }
  .invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    font-size: 16px;
    line-height: 24px;
    color: #555;
  }
  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
  }
  .invoice-box table td {
    padding: 5px;
    vertical-align: top;
  }
  .invoice-box table tr td:nth-child(2) {
    text-align: right;
  }
  .invoice-box table tr.top table td {
    padding-bottom: 15px;
  }
  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }
  .invoice-box table tr.information table td {
    padding-bottom: 40px;
  }
  .invoice-box table tr.heading td {
    background: #3b4e87;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
    text-align: left;
    color: white;
    padding-left: 5px;
  }
  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }
  .invoice-box table tr.item td{
    border: 1px solid #eee;
    text-align: left
  }
  .invoice-box table tr.item.last td {
    border-bottom: none;
  }
  .invoice-box table tr.total td:nth-child(2) {
    /* border-top: 2px solid #eee; */
    font-weight: bold;
  }
  @media only screen and (max-width: 668px) {
    .invoice-box{
        padding: 10px;
        font-size: 12px
    }
    .invoice-box table tr.top table td {
      /* width: 100%; */
      /* display: block; */
      text-align: center;
    }
    .invoice-box table tr.information table td {
      width: 100%;
      display: block;
      text-align: center;
    }
    .bill_to{
        width: 100% !important;
    }
    .logo-img{
        max-width: 200px !important;
    }
    .stamp{
        width: 100px !important;
    }
    .payment-link{
        left: 2px;
    }
  }
  .company_name{
    font-weight: bold;
    font-size: 20px;
    font-family: arial;
    text-transform: uppercase;
    color: #2C3A65;
  }
  td{
    color: black
  }
  .invoice{
    color: #7A8DC5;
    font-size: 20px;
    font-weight: bold;
    text-transform: uppercase;
    text-align: right
  }
  .invoice_table{
    /* width: 60% !important; */
    float: right;
    padding: 0;
    margin: 0;
    line-height: 1px !important;
    position: relative;
    top: 5px;
  }
  .invoice_col_head{
    text-align: right;
    position: relative;
    top: 5px;
  }
  .invoice_col_body{
    border: 1px solid gainsboro;
    text-align: center !important;
    font-size: 12px;
    font-weight: 600;
  }
  .invoice_col_body .value{
    position: relative;
    top: 5px;
  }
  .invoice_main_table tbody tr:nth-child(odd){
    background-color: #F2F2F2
  }
  .invoice_main_table tr td{
    padding: 0;
  }
  .total{
    position: relative;
    top: 20px;
  }
  .bill_to{
    background: #3B4E87;color: white;width: 70%;display: block;
  }
  .logo-img{
    max-width: 270px;
  }
  .stamp{
    width: 160px; position: absolute;transform: rotate(350deg); bottom: 15px;
  }
  .payment-link{
    border: 1px solid;position: relative;top: 20px;
  }
  @media print{
    body{
  -webkit-print-color-adjust:exact !important;
  print-color-adjust:exact !important;
}
    .invoice-box{
        border:none;
        box-shadow: none
    }
  }
</style>
</head>
<body>
<div class="invoice-box">
  <table cellpadding="0" cellspacing="0">
    <tr class="top">
      <td colspan="4">
        <table>
          <tr>

            <td>
                <span class="company_name">Fujtown</span><br>
                FEWA Building, Office 808<br>
                P. O. Box 9060, Fujairah - UAE <br><br>
                Mobile: 050-3711700 <br>
                Website: www.fujtown.com
              </td>

            <td>
                <table cellpadding="0" cellspacing="0" class="invoice_table">
                    <tr>
                    <td colspan="2" class="invoice">Invoice</td>
                    </tr>
                    <tr>
                    <td class="invoice_col_head">DATE</td>
                    <td  class="invoice_col_body"><span class="value">{{$formattedDate}}</span></td>
                    </tr>
                    <tr>
                        <td class="invoice_col_head">INVOICE</td>
                        <td  class="invoice_col_body"><span class="value">{{$payment->id}}</span></td>
                    </tr>
                    <tr>
                        <td class="invoice_col_head">CUSTOMER ID</td>
                        <td class="invoice_col_body"><span class="value">FUJNVTL</span></td>
                    </tr>
                    <tr>
                        <td class="invoice_col_head">DUE DATE</td>
                        <td class="invoice_col_body" style="background: #D2D9EC"></td>
                    </tr>

                </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>

    <tr class="information">
      <td colspan="4">
        <table>
          <tr>
            <td>

                <span class="bill_to"><span style="padding-left: 10px;">BILL TO</span></span><br>
                <div style="line-height: 1.8">
                <span style="    font-size: 25px;">To:</span> <span style="    font-size: 18px;">{{$payment->customer_name}}</span><br>
                <span style="font-weight: 600;">Email:</span> <span>{{$payment->customer_email}}</span><br>
                <span style="font-weight: 600;">Phone:</span><span>{{$payment->customer_phone_number}}</span>
             </div>
            </td>
            <td class="title">
                <img src="{{asset('assets/img/fujtown.png')}}" class="logo-img">
              </td>
          </tr>
        </table>
      </td>
    </tr>
    <table class="invoice_main_table"  cellpadding="0" cellspacing="0">
        <tr class="heading">
            <td width="60%"> Description </td>
            <td width="20%">Unit Price</td>
            <td width="20%" style="text-align: right;padding-right:5px">Amount </td>
            </tr>

           <tbody>
            <tr class="item">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right">  &nbsp;</td>
                </tr>
            <tr class="item">
            <td style="font-size: 24px;font-weight:bold;padding: 5px;" colspan="3"> Fujtown Service  </td>
            </tr>
            <tr class="item">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td style="text-align: right">  &nbsp;</td>
                </tr>

            <tr class="item">
            <td> Investment Portfolio Review & Recommendations </td>
            <td> {{number_format($payment->request_amount, 2, '.', ',') . ' '. $payment->request_currency}} </td>
            <td style="text-align: right">   {{number_format($payment->request_amount, 2, '.', ',') . ' '. $payment->request_currency}}</td>
            </tr>


            <tr class="item">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">  &nbsp;</td>
            </tr>
            <tr class="item">
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">  &nbsp;</td>
            </tr>
           </tbody>
       <tfoot>
        <tr class="total">
            <td style="text-align: right"><img class="stamp" src="{{asset('assets/img/STAMP.png')}}" alt=""> ____________ FUJTOWN SIGN</td>
            <td colspan="2"> Total: 	 {{number_format($payment->request_amount, 2, '.', ',') . ' '. $payment->request_currency}} </td>
          </tr>
          <tr class="total">
            <td class="payment-link">
               <span style="    background: #3b4e87;display: block;color: white;">Payment Link below:- </span>
                <span style="    padding: 20px 5px;display: block;"><a href="https://fujtrade.com/payment_captured/{{$payment->id}}">https://fujtrade.com/payment_captured/{{$payment->id}}</a></span>
            </td>
            <td colspan="2" style="text-align: center;padding-top: 15px;"> Make all cheque payable to <br><span>FUJTOWN LLC SPC</span></td>

          </tr>
       </tfoot>


    </table>

    <div class="footer" style="    margin-top: 60px;text-align: center;color: black;">
        <div class="pull-right">
            If you have any questions about this invoice, please contact <br>
            Navas, 09-22-44-200, 050-370-2600, marketing@fujtown.com <br>
            <span style="font-size: 20px;font-weight: bold;">Thank You For Your Business!</span><br>
            <span>Be a star with #fujtown</span>
            <br>
            <span>Fujtown.com All Rights Reserved.</span>
        </div>
        <div class="clearfix"></div>
    </div>
