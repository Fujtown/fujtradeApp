@extends('layouts.admin') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->

<div class="wrapper">
    <div class="container-fluid">


        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">List Of Links Payment</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th class="desktop">#</th>
                                        <th class="desktop">Amount</th>
                                        <th class="desktop mobile-l">Customer Details</th>
                                        <th class="desktop desktop">Status</th>
                                        <th class="desktop mobile-l">Reason</th>
                                        <th class="desktop mobile-l">Date</th>
                                    </tr>
                                    </thead>


                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div><!--end row-->


            </div><!--end col-->


        </div><!--end row-->

          <!-- Button trigger modal -->




    </div> <!-- end container -->
</div>
<!-- end wrapper -->
@push('scripts')
 <!-- Required datatable js -->
 <script src="{{asset('admin_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
 <!-- Buttons examples -->
 <script src="{{asset('admin_assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/jszip.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/pdfmake.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/vfs_fonts.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/buttons.html5.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/buttons.print.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
 <!-- Responsive examples -->
 <script src="{{asset('admin_assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
 <script src="{{asset('admin_assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 <script>
    $(document).ready(function() {

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

 var table=$('#datatable-buttons').DataTable({
    scrollX: true,
    "dom": 'Bfrtip',
            "serverSide": false,
            "bSortable": true,
            "lengthChange": true,
            "responsive": true,
            "ajax": function(data, callback, settings) {

            $.ajax({
                url: '{{ url('coffee/agent/get_link_payments_status') }}',
                type: 'GET',
                success: function(response) {
                    callback({data: response});
                },
                error:function(response)
                {
                    let errorMsg =$.parseJSON(response.responseText);
                    // console.log()
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: errorMsg.message,
                  });
                }
            });
        },
        columns: [
            { data: null, render: function (data, type, row, meta) {
                return meta.row + 1; // for indexing starting from 1
            }},
            { data: null, render: function(data, type, row) {
                return row.amount + ' ' + row.currency;
            }},
            { data: null, render: function(data, type, row) {
                return row.first_name + ' ' + row.last_name + '<br>' +
                       row.email + '<br>' +
                       row.country_code + ' ' + row.number;
            }},
            { data: 'status', render: function(data, type, row) {
            return  '<span style="font-weight: bold;">'+data+'</span>';
          }},
            { data: 'message', render: function(data, type, row) {
            return  '<span style="font-weight: bold;">'+data+'</span>';
          }},
          { data: 'date', render: function(data, type, row) {
            return formatDate(data); // Format the date
          }},


        ],

            buttons: [
                {
                        extend: 'print',
                        message: 'Print',
                        text: 'Print',
                },
                {
                        extend: 'copy',
                        message: 'Copy',
                        text: 'Copy',
                },
                {
                        extend: 'excelHtml5',
                        title: 'Export List'
                },
                {
                        extend: 'pdfHtml5',
                        title: 'Fujtrade Payment List',
                        customize:  function (doc) {
                            doc.pageOrientation = 'landscape';
                doc.defaultStyle.fontSize = 8;
                doc.content[1].table.widths = Array(doc.content[1].table.body[0].length).fill('auto');
                doc.pageMargins = [20, 60, 20, 30];
                }
                }
                ,{
                        extend: 'colvis',
                        text: 'Columns Visibilty'
                }
            ]

        // order: [[1, 'desc']] // Optional: if you want to order by a specific column by default
    });




    });
</script>

@endpush
@endsection
