@extends('layouts.app') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<main>
    <style>
        /* Style the tab */
/* Container for the tabs and tab content */
.tab-container {
  display: flex;
  width: 100%;
  padding-top: 50px;
}

/* Container for the tab links */
.tab-links {
  flex: 1;
  padding-right: 20px; /* Adjust the spacing as needed */
}

/* Style the tab buttons */
.tablink {
  display: block;
  background-color: #f1f1f1;
  color: black;
  padding: 10px 15px;
  width: 100%;
  text-align: left;
  border: none;
  outline: none;
  cursor: pointer;
  transition: 0.3s;
  border-bottom: 1px solid #ddd;
  padding:30px;
}

/* Change background color of buttons on hover and active */
.tablink:hover, .tablink.active {
   background-color: #37a7f8;
  color: white; /* Change text color for better contrast if needed */
}

/* Style the tab content */
.tab-content {
  flex: 3; /* Adjust the ratio between tab links and content as needed */
  padding-left: 20px; /* Adjust the spacing as needed */
}

.tabcontent {
  display: none;
  padding: 20px;
  /*border: 1px solid #ccc;*/
  height: 100%;
}

/* Initially open tab */
#InvestmentAgreement {
  display: block;
}
h5{
    width:100%;
}


/* Media query for mobile devices */
@media (max-width: 768px) {
  .tab-container {
    flex-direction: column;
  }

  .tab-links {
    flex: none;
    width: 100%; /* Full width on mobile */
    padding-right: 0; /* Remove right padding on mobile */
    
  }

  .tab-content {
    flex: none;
    width: 100%; /* Full width on mobile */
    padding-left: 0; /* Remove left padding on mobile */
  }

  .tablink {
    padding: 10px; /* Adjust tab padding on mobile */
    border-bottom: 1px solid #ddd; /* Ensure the border is consistent */
    padding:30px;
  }

  .tabcontent {
    border: 1px solid #ccc; /* Adjust borders for mobile */
    border-top: none; /* Remove top border for mobile */
  }
}

    </style>
 <!-- Tab links -->
<div class="tab-container">

  <!-- Tab links -->
  <div class="tab-links">
    <button class="tablink active" onclick="openTab(event, 'InvestmentAgreement')">Investment and Trading Services Agreement</button>
    <button class="tablink" onclick="openTab(event, 'ProductStatement')">Product Disclosure Statement</button>
    <button class="tablink" onclick="openTab(event, 'FinancialGuide')">Financial Services Guide (FSG)</button>
  </div>

  <!-- Tab content -->
  <div class="tab-content">
    <div id="InvestmentAgreement" class="tabcontent">
      <div uk-grid>
              <h2>Investment and Trading Services Agreement</h2>
              <p>This Investment and Trading Services Agreement (the "Agreement") is entered into between Fujtrade, an initiative of Fujtown Trading LLC,
                hereinafter referred to as the "Company," and the undersigned client, hereinafter referred to as the "Client."</p>
              <ol>
                <li><b>Investment Authorization</b>: <p> By entering into this Agreement, the Client authorizes the Company to manage, invest, and trade funds on their behalf via e-trading.</p></li>
                <li><b>Investment Strategy</b>: <p>The Company will employ its best efforts to manage the Client's funds in accordance with the investment strategy agreed upon.</p></li>
                <li><b>Risks and Disclosures</b>: <p>The Client acknowledges that all investments involve risks, and past performance is not indicative of future results.
                    The Client agrees to bear all risks associated with the investment.</p></li>
                <li><b>Fees and Charges</b>: <p>The Client agrees to pay the Company fees as outlined in a separate fee schedule provided by the Company.
                     Any changes to the fee structure will be communicated to the Client in advance.</p></li>
                <li><b>Account Information</b>: <p>The Client is responsible for providing accurate and up-to-date information for the establishment and maintenance of the investment account.</p></li>
                <li><b>Withdrawals</b>: <p>    The Client may request withdrawals subject to the terms and conditions outlined in the Company's withdrawal policy,
                    refunds are indicative in the case that the funds invested has not yet been utilized.</p></li>
                <li><b>Confidentiality</b>: <p>Both parties agree to keep confidential all non-public information obtained during the term of this Agreement.</p></li>
                <li><b>Termination</b>: <p>    Either party may terminate this Agreement with written notice. Termination does not affect any obligations arising before the termination date.
                     The client does not have the right to request for the capital investment made if the investment is at a loss. Only profits will be transferred to the client if applicable.</p></li>
                <li><b>Governing Law</b>: <p>This Agreement shall be governed by and construed in accordance with the laws of the UAE.</p></li>
                <li><b>Dispute Resolution</b>: <p>Any disputes arising out of or in connection with this Agreement shall be resolved through arbitration in accordance with the rules of the UAE.</p></li>
                <li><b>Amendments</b>: <p>This Agreement is not amendable, and can only be terminated upon the given terms.</p></li>
                <li><b>Entire Agreement</b>: <p>This Agreement constitutes the entire understanding between the parties and supersedes all prior agreements, oral or written, relating to the subject matter herein.</p></li>
                <li><b>Acceptance of Agreement</b>: <p>This Agreement is considered accepted by the client upon checking the tick box of the terms and conditions on the website, and upon initiating the first investment funds transfer.</p></li>
                <li><b>Acceptance of Secure 3DS Transaction</b>: <p>This confirms that the Client has accepted that all transactions are made via secure 3DS payment processor, and that in the case that the Client does not have 3DS enabled upon making the payment, the transaction shall not be accepted. This is to ensure that the payments received are of clean origin and non-fraudulent.
                    This is also to ensure that the Client is willing upon himself/herself to make the payment for the service requested, without any objection, on their own will in order to profit from the service provided. </p></li>

                    <li><b>Profit & Loss Liability</b>: <p>This confirms that the Client, on their own willingness, to hand over their trading rights to the Company in the hope that they profit from the capital they have invested.
                         The company is not liable for any loss or profit retained from any trade services initiated,
                        nor does the Client have any right of claiming any right to the capital they have invested. </p></ol>

            </div>
    </div>

    <div id="ProductStatement" class="tabcontent">
       <div id="pds" uk-grid>
                <h2>Product Disclosure Statement</h2>


                <p><b>Introduction:</b> <br>Welcome to Fujtrade, the online trading platform designed to empower you to invest in financial markets conveniently and efficiently. Before you begin trading on our platform, it's important that you understand the key features, risks, and costs associated with our services. This Product Disclosure Statement (PDS) aims to provide you with all the necessary information to make informed decisions about using our platform.</p>



                <p><b>About Fujtrade: </b>Fujtrade is an online trading platform that allows users to buy and sell a wide range of financial instruments, including stocks, bonds, options, and exchange-traded funds (ETFs). Our platform provides access to global markets and advanced trading tools to help you manage your investments effectively.</p>

                <h5>Key Features:</h5>

                <ul>
                    <li>User-friendly Interface: Our platform is designed to be intuitive and easy to navigate, making it accessible to both novice and experienced traders.</li>
                    <li>Market Access: We offer access to a wide range of financial markets, including equities, fixed income, commodities, and forex, allowing you to diversify your investment portfolio.</li>
                    <li>Advanced Trading Tools: Fujtrade provides a suite of advanced trading tools, including real-time market data, charting tools, technical analysis indicators, and customizable trading algorithms.</li>
                    <li>Educational Resources: We offer educational resources, including articles, tutorials, and webinars, to help you enhance your trading knowledge and skills.</li>
                    <li>Customer Support: Our dedicated customer support team is available to assist you with any questions or issues you may encounter while using our platform.</li>
                </ul>

                <h5>Risks:</h5>
                <ul>
                    <li>Market Risk: Investing in financial markets involves inherent risks, including the risk of losing money due to market fluctuations.</li>
                    <li>Liquidity Risk: Some securities may have limited liquidity, which can affect your ability to buy or sell them at desired prices.</li>
                    <li>Credit Risk: There is a risk that issuers of bonds or other debt securities may default on their obligations, leading to potential losses for investors.</li>
                    <li>Operational Risk: Our platform relies on technology and may be subject to disruptions, cyber-attacks, or other operational risks that could impact your ability to trade.</li>
                    <li>Regulatory Risk: Changes in regulations or legal frameworks governing financial markets may affect the value of your investments or the availability of certain products.</li>
                </ul>

              <p> <b> Fees and Charges:</b><br>

                Fujtrade charges fees for various services, including brokerage fees, transaction fees, account maintenance fees, and inactivity fees. Please refer to our fee schedule for detailed information on applicable charges.</p>

<p><b>How to Get Started:</b><br>

    To start trading on Fujtrade, simply sign up for an account on our website and complete the account verification process. Once your account is approved, you can deposit funds and begin trading immediately.</p>

<p>
 <b>Conclusion:</b> <br>

By using Fujtrade, you acknowledge that you have read and understood this Product Disclosure Statement and agree to abide by its terms and conditions. If you have any questions or require further clarification, please contact our customer support team for assistance.
</p>

<p><b>Disclaimer:</b><br>
    Trading involves risk, and past performance is not indicative of future results. The information provided in this Product Disclosure Statement is for informational purposes only and should not be construed as investment advice. You should carefully consider your investment objectives, financial situation, and risk tolerance before making any investment decisions. Fujtrade does not guarantee the accuracy or completeness of the information provided and shall not be liable for any errors or omissions.</p>

            </div>
    </div>

    <div id="FinancialGuide" class="tabcontent">
        <div uk-grid>
                <h2>Financial Services Guide (FSG)</h2>

<p><b>About Fujtrade:</b>

    Fujtrade is an online trading platform designed to provide users with access to global financial markets. This Financial Services Guide (FSG) is intended to assist you in making informed decisions about the financial services we offer.</p>
    <ul></ul>
    <h5>Our Services:</h5>
    <p>Fujtrade offers a range of services, including:</p>
    <ul>
        <li>Trading Platform: Our platform provides access to a diverse range of financial instruments, including stocks, bonds, options, futures, and exchange-traded funds (ETFs).</li>
        <li>Market Data: We offer real-time market data, research reports, and analysis tools to help you make informed investment decisions.</li>
        <li>Trading Tools: Fujtrade provides advanced trading tools, including charting software, technical analysis indicators, and customizable trading algorithms.</li>
        <li>Educational Resources: We offer educational resources, including articles, tutorials, and webinars, to help you enhance your trading knowledge and skills.</li>
    </ul>

    <h5>Our Commitment to You:</h5>

<p>At Fujtrade, we are committed to:</p>

<ul>
    <li>Transparency: We strive to provide clear and accurate information about our services, fees, and the risks associated with trading.</li>
    <li>Fair Dealing: We are committed to treating our clients fairly and ethically, and we aim to act in your best interests at all times.</li>
    <li>Customer Support: Our dedicated customer support team is available to assist you with any questions or issues you may encounter while using our platform.</li>
</ul>

<h5>Risks:</h5>
<p>Trading involves risks, including the risk of losing money. It's important to understand the risks associated with trading financial instruments, including: </p>
<ul>

        <li>Market Risk: The value of investments can fluctuate due to market conditions and other factors beyond your control.</li>
        <li>Liquidity Risk: Some securities may have limited liquidity, which can affect your ability to buy or sell them at desired prices.</li>
        <li>Credit Risk: There is a risk that issuers of bonds or other debt securities may default on their obligations, leading to potential losses for investors.</li>
        <li>Operational Risk: Our platform relies on technology and may be subject to disruptions, cyber-attacks, or other operational risks that could impact your ability to trade.</li>
</ul>

<p><b>Fees and Charges:</b><br>

    Fujtrade charges fees for various services, including brokerage fees, transaction fees, account maintenance fees, and inactivity fees. Please refer to our fee schedule for detailed information on applicable charges.</p>

<p><b>Complaints Handling:</b><br>

    If you have a complaint or concern about our services, please contact our customer support team at [Contact Information]. We are committed to resolving complaints promptly and fairly.</p>

<p>
   <b> How to Contact Us:</b>

    If you have any questions about our services or would like more information, please contact us at:</p>
<br>
<p class="contact-no">092244200</p>
<br>
<h5>Conclusion:</h5>
<p>
    By using Fujtrade's services, you acknowledge that you have received and understood this Financial Services Guide (FSG). If you have any questions or require further clarification, please do not hesitate to contact us.</p>


              </div>
    </div>
  </div>

</div>

    </main>
    
    
<script>
// Execute JavaScript after the document has loaded
document.addEventListener("DOMContentLoaded", function() {
  // Get the first tablink and simulate a click on it
  document.querySelector(".tablink").click();
});
   function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  
  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  
  // Get all elements with class="tablink" and remove the class "active"
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  
  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

</script>    
@endsection
