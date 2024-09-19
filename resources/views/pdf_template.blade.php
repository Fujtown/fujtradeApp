<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>PDF Template</title>
    <!-- Add any necessary CSS styles here -->
</head>
<style>
    @page { margin: 0px; }
    @page :second {
    margin: 15mm !important; /* Adjust the value to increase the margin as needed */
  }
    .title{
        text-align: center
    }
    body {
      font-family: 'Helvetica', sans-serif;
      margin: 0px;
    }
    .bold {
      font-weight: bold;
    }
    .agreement-text {
      text-align: justify;
      font-weight: bold;
    }
    .signature-image {
      width: 180px;
      height: 90px;
      position: relative;
      top: 30px;
    }
    .section {
      margin-bottom: 20px;
    }
    ol li{
        text-align: justify;
        list-style: none
    }
    .page-break {
    page-break-after: always !important;
  }
  .cover-img{
    margin: 0;
    padding: 0;
  }
  main{
    margin: 15mm;
  }
  .gap{
    margin-top: 100px;
  }
  .float{
    position: relative;
    top: 100px;
  }
  .subtitle{
    text-align: justify
  }
  </style>
<body>
    <img src="{{ public_path('assets/img/cover.png') }}" class="cover-img" width="100%" />
    <main>
        <h1 class="title">Investment and Trading Services Agreement</h1>
        <p class="subtitle">This Investment and Trading Services Agreement (the "Agreement") is entered into between Fujtrade,
            an initiative of Fujtown Trading LLC, hereinafter referred to as the "Company," and the undersigned client, hereinafter referred to as the "Client.</p>
            <ol>
                <li><strong>1. Investment Authorization:</strong> By entering into this Agreement, the Client authorizes the Company to manage, invest, and trade funds on their behalf via e-trading.</li><br>
                <li><strong>2. Investment Strategy:</strong> The Company will employ its best efforts to manage the Client's funds in accordance with the investment strategy agreed upon.</li><br>
                <li><strong>3. Risks and Disclosures:</strong> The Client acknowledges that all investments involve risks, and past performance is not indicative of future results. The Client agrees to bear all risks associated with the investment.</li><br>
                <li><strong>4. Fees and Charges:</strong> The Client agrees to pay the Company fees as outlined in a separate fee schedule provided by the Company. Any changes to the fee structure will be communicated to the Client in advance.</li><br>
            <li><strong>5. Account Information:</strong> The Client is responsible for providing accurate and up-to-date information for the establishment and maintenance of the investment account.</li><br>
            <li><strong>6. Withdrawals:</strong> The Client may request withdrawals subject to the terms and conditions outlined in the Company's withdrawal policy, refunds are indicative in the case that the funds invested has not yet been utilized.</li><br>
            <li><strong>7. Confidentiality:</strong> Both parties agree to keep confidential all non-public information obtained during the term of this Agreement.</li><br>
            <li><strong>8. Termination:</strong> Either party may terminate this Agreement with written notice. Termination does not affect any obligations arising before the termination date. The client does not have the right to request for the capital investment made if the investment is at a loss. Only profits will be transferred to the client if applicable.</li><br>
            <li><strong>9. Governing Law:</strong> This Agreement shall be governed by and construed in accordance with the laws of the UAE.</li><br>

            <li><strong>10. Dispute Resolution:</strong> Any disputes arising out of or in connection with this Agreement shall be resolved through arbitration in accordance with the rules of the UAE.</li><br>
            <div class="float">
            <li><strong>11. Amendments:</strong> This Agreement is not amendable, and can only be terminated upon the given terms.</li><br>

            <li><strong>12. Entire Agreement:</strong> This Agreement constitutes the entire understanding between the parties and supersedes all prior agreements, oral or written, relating to the subject matter herein.</li><br>
            <li><strong>13. Acceptance of Agreement:</strong> This Agreement is considered accepted by the client upon checking the tick box of the terms and conditions on the website, and upon initiating the first investment funds transfer.</li><br>
            <li><strong>14. Acceptance of Secure 3DS Transaction:</strong> This confirms that the Client has accepted that all transactions are made via secure 3DS payment processor, and that in the case that the Client does not have 3DS enabled upon making the payment, the transaction shall not be accepted. This is to ensure that the payments received are of clean origin and non-fraudulent. This is also to ensure that the Client is willing upon himself/herself to make the payment for the service requested, without any objection, on their own will in order to profit from the service provided.</li><br>
            <li><strong>15. Profit & Loss Liability:</strong> This Agreement is considered accepted by the client upon checking the tick box of the terms and conditions on the website, and upon initiating the first investment funds transfer.</li>
        </div>
            </ol>

            <div class="page-break"></div>
            <div class="float">
            <h3>IN WITNESS WHEREOF <small>the parties hereto have executed this Investment and Trading Services Agreement as of the Effective Date.</small></h3>
            <br><br><br>
            <div class="section">
            <span>Client's Name: </span><span class="bold">{{ $name }}</span>
            </div>
          
             
          <div class="section">
            <span>Client's Email: </span><span class="bold">{{ $email }}</span>
          </div>

          <div class="section">
            <span>Client's Phone #: </span><span class="bold">{{ $phone }}</span>
          </div>
          
             @if (!empty($customerSign))
             <div class="section">
            <span> <div style="background:white;display: flex;align-items: center;"><span>Client's Signature:</span>
            <img style="width: 200px;height: auto;mix-blend-mode: hard-light;object-fit: contain;position:relative;top:20px" src="{{ public_path('signature/' . $customerSign) }}" alt="Signature Stamp" ></div>
            </div>
            @else
            <br>
             <div class="section">
            <span> <div style="background:white;display: flex;align-items: center;"><span>Client's Signature:</span> <span>________________________</span>
           
            </div>
            <br>
             @endif

          <div class="section">
            <span>Date: </span><span class="bold">{{ $date }}</span>
          </div>
          <br><br><br>

          <div class="section agreement-text">
            THIS AGREEMENT HAS BEEN ACCEPTED AND AGREED UPON BY CLIENT UPON ACCOUNT OPENING AND FUNDS TRANSFER
          </div>
          <br>
          <div class="section">
            <span>Company Name: </span><span class="bold">FUJTOWN</span>
          </div>

          <div class="section">
            <span>Company Representative's Signature: </span>
            <!-- The image source path needs to be the location where the stamp image is stored -->
            <img src="{{ public_path('assets/img/stamp-fujtown.png') }}" alt="Signature Stamp" class="signature-image">
          </div>
          <br>
          <div class="section">
            <span>Date: </span><span class="bold">{{ $date }}</span>
          </div>
          </div>

    </main>
    <!-- Add the rest of your PDF content here -->
</body>
</html>
