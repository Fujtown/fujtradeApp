@extends('layouts.app') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->

<style>

    /*** Table Styles **/


            </style>
<main>
    <div class="uk-section">
        <div class="uk-container" >
            <div class="uk-card uk-card-default uk-card-hover uk-card-body transaction_body">

            <h1 class="uk-margin-small-top uk-text-center uk-card-title">Checkout<span class="in-highlight"> Your Transactions Information</span></h1>
            <div uk-grid>


                <div class="uk-width-expand@m transaction_table">
                    <table role="table" class="table-fill">
                        <thead role="rowgroup">
                        <tr class="transaction_info">
                        <th class="text-left" colspan="3">Transaction Information</th>
                        <th colspan="3"><a href="#"  target="_blank"  id="downloadLink" class="download-btn">Download Agreement</a></th>
                        </tr>
                        <tr role="row">
                            <th role="columnheader">Name</th>
                            <th role="columnheader">Email</th>
                            <th role="columnheader">Amount</th>
                            <th role="columnheader">Currency</th>
                            <th role="columnheader">Date</th>
                            <th role="columnheader">Action</th>
                        </tr>
                        </thead>
                        <tbody role="rowgroup" class="table-hover">

                        </tbody>
                        </table>
                </div>
            </div>
            <!-- <button type="button" class="generate">Generate PDF</button> -->
            <!-- <div class="uk-grid uk-flex uk-flex-center in-contact-8">
                <h1 class="uk-margin-small-top uk-text-center">Customise<span class="in-highlight">Your Account Information</span></h1>

            </div> -->
        </div>
        </div>
    </div>
    <!-- section content begin -->

</main>
    @push('scripts')
    <script>
        $(document).ready(function() {
          //   $('#fetchDataButton').click(function() {
              function formatDate(milliseconds) {
              var timestamp = Number(milliseconds); // Your timestamp in milliseconds
          var date = new Date(timestamp); // Convert timestamp to a Date object
          // Function to add leading zeros
          function pad(number) {
              return (number < 10 ? '0' : '') + number;
          }
                          // console.log(milliseconds)
                         // Construct the UTC date string
          var hoursUTC = date.getUTCHours() % 12 || 12; // Convert 24h to 12h format UTC
          var minutesUTC = pad(date.getUTCMinutes());
          var ampmUTC = date.getUTCHours() >= 12 ? 'PM' : 'AM';
          var formattedDateUTC = pad(date.getUTCMonth() + 1) + '/' +
                                 pad(date.getUTCDate()) + '/' +
                                 date.getUTCFullYear() + ' ' +
                                 pad(hoursUTC) + ':' +
                                 minutesUTC + ' ' +
                                 ampmUTC;


                      // console.log("UTC Time: " + formattedDateUTC);
                      return formattedDateUTC;
                  }

                  var email = '{{$user->email}}';

                      $.ajax({
                        headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                      url: "{{ url('get_record_by_client') }}", // Change to your actual endpoint
                      type: 'POST',
                      data: { email: email },
                      success: function(response) {
                        const baseUrl = "{{ url('') }}";
                        $("tbody").empty();


                            // Iterate over transactions and append rows to the table body
                            response.map(function(transaction) {
                                const viewInvoiceUrl = `${baseUrl}/view_invoice/${transaction.id}`;
                                $("tbody").append(
                                    `<tr>
                                        <td role="cell">${transaction.first_name}</td>
                                        <td role="cell">${transaction.email}</td>
                                        <td role="cell">${transaction.amount}</td>
                                        <td role="cell">${transaction.currency}</td>
                                        <td role="cell">${formatDate(transaction.date)}</td>
                                        <td role="cell"><a href="${viewInvoiceUrl}" class="view_invoice" target="_blank">View Invoice</a></td>
                                    </tr>`
                                );
                            });

                          // Handle success scenario
                      },
                      error: function(error) {
                          console.error('Error:', error);
                          // Handle error scenario
                      }
                  });

                  var email = '{{$user->email}}';
              const storedUserAgreementString = localStorage.getItem('userAgreement');
                  const storedAgreement = storedUserAgreementString ? JSON.parse(storedUserAgreementString) : null;
                //   const store_ag_email = storedUserInfo.email;
                //   const store_ag_email = storedUserInfo.email ? storedUserInfo.email : null;
                const store_ag_email = storedAgreement?.client_email ?? null;
                  if (isObjectDefinedAndNotEmpty(storedAgreement) && email == store_ag_email) {
                      $('#downloadLink').attr('href', storedAgreement.agreement);
                  } else {

                      $.ajax({
                        headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                      url: "{{ url('download_client_agreement')}}", // Change to your actual endpoint
                      type: 'POST',
                      data: { email: email },
                      success: function(response) {
                          const storedUserAgreementString = localStorage.getItem('userAgreement');
                          const storedAgreement = storedUserAgreementString ? JSON.parse(storedUserAgreementString) : null;

                          // Check if the retrieved object is defined and not empty
                          if (isObjectDefinedAndNotEmpty(storedAgreement) && email == store_ag_email) {
                              // $('#name').text(storedAgreement.first_name);
                              $('#downloadLink').attr('href', storedAgreement.agreement);
                          } else {
                              $('#downloadLink').attr('href', response.pdf_url);
                              const userAgreement = {
                              agreement: response.pdf_url,
                              client_email: response.email,
                          };
                          const userAgreementString = JSON.stringify(userAgreement);
                          localStorage.setItem('userAgreement', userAgreementString);

                          }


                          // Handle success scenario
                      },
                      error: function(error) {
                          console.error('Error:', error);
                          // Handle error scenario
                      }
                  });
                  }

          function isObjectDefinedAndNotEmpty(obj) {
          // Check if the object is defined and not null
          if (typeof obj !== 'undefined' && obj !== null) {
              // Check if the object has at least one property
              return Object.keys(obj).length > 0;
          }
          return false;
      }

        });


        </script>
    @endpush
@endsection
