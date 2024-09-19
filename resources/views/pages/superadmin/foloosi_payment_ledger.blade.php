@extends('layouts.admin') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->

<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Fujtrade</a></li>
                            <li class="breadcrumb-item active">Foloosi Payments Ledger</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List Of Foloosi Pyaments Ledger</h4>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-primary pull-right" id="sync_data">Sync Data</button>
                                <h4 class="mt-0 header-title">List Of Foloosi Pyaments Ledger</h4>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group mb-0">
                                            <h6 class="sub-title my-3">Date Range</h6>
                                            <div>
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text"  id="min-date" class="form-control" name="start" placeholder="Start Date" />
                                                    <input type="text"  id="max-date" class="form-control" name="end" placeholder="End Date" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="sub-title my-3">Filter By Status</h6>
                                        <select name="" class="form-control status" id="">
                                            <option value="">Select Status</option>
                                            <option value="success">CAPTURED</option>
                                            <option value="failed">FAILED</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <h6 class="sub-title my-3">&nbsp;</h6>
                                        <button class="btn btn-info" id="search">Search</button>
                                        <button class="btn btn-warning" id="reset">Reset</button>
                                    </div>
                                </div>
                            <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Transaction</th>
                                        <th>Card</th>
                                        <th>Customer</th>
                                        <th>Response</th>
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




    </div> <!-- end container -->
</div>
<!-- end wrapper -->
@push('scripts')
 <!-- Required datatable js -->
 <script src="{{ asset('admin_assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
 <!-- Buttons examples -->
 <script src="{{ asset('admin_assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/jszip.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/pdfmake.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/vfs_fonts.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/buttons.html5.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/buttons.print.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
 <!-- Responsive examples -->
 <script src="{{ asset('admin_assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
 <script src="{{ asset('admin_assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<script>
    $(document).ready(function() {
        $('#min-date').datepicker({
            format: 'yyyy-mm-dd',
        toggleActive: true,
        orientation: 'auto bottom'
    });

    $('#max-date').datepicker({
        format: 'yyyy-mm-dd',
        toggleActive: true,
        orientation: 'auto bottom'
    });

    function formatDate(fordate) {
        var date = new Date(fordate);

// Get components of the date
var year = date.getFullYear();
var month = date.getMonth() + 1; // Months are 0-indexed
var day = date.getDate();
var hours = date.getHours();
var minutes = date.getMinutes();
var seconds = date.getSeconds();
var ampm = hours >= 12 ? 'PM' : 'AM';

// Convert 24-hour time to 12-hour time
hours = hours % 12;
hours = hours ? hours : 12; // the hour '0' should be '12'
minutes = minutes < 10 ? '0'+minutes : minutes;
seconds = seconds < 10 ? '0'+seconds : seconds;

// Format the output
var formattedDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;

                return formattedDate;
            }

 var table=$('#datatable-buttons').DataTable({
    "dom": 'Bfrtip',
            "serverSide": false,
            "bSortable": true,
            "lengthChange": true,
            "responsive": true,
            "ajax": function(data, callback, settings) {
            var minDate = $('#min-date').val();
            var maxDate = $('#max-date').val();
            var status  = $('.status').val();
            // console.log(status)
                     var ajaxData = {};

                    if (minDate && maxDate && status =='') {
                        ajaxData.min_date = minDate;
                        ajaxData.max_date = maxDate;
                    }
                    else if(minDate && maxDate && status) {
                        ajaxData.min_date = minDate;
                        ajaxData.max_date = maxDate;
                        ajaxData.status = status;
                    }
                    else if(status)
                    {
                        ajaxData.status = status;
                    }

            $.ajax({
                url: '{{ url('coffee/get_foloosi_paymentsLedger') }}',
                type: 'GET',
                data: ajaxData,
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
            { data: 'request_amount', render: function(data, type, row) {

                return data + ' ' + row.request_currency;
            }},
            { data: 'created_at_foloosi', render: function(data, type, row) {
            return formatDate(data); // Format the date
          }},
            { data: 'transaction_no' },
            { data: 'bin_card' },
            { data: null, render: function(data, type, row) {
                return row.customer_name + '<br>' +
                       row.customer_email + '<br>' +
                       row.customer_phone_number;
            }},
            { data: 'status' }
           
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

                $('#search').on('click',function(){
                    var min_date=$('#min-date').val();
                    var max_date=$('#max-date').val();
                    var status=$('.status').val();
                    table.ajax.reload(null, false);
                })

                //Dropdown filtering
                $('.status').on('change',function(){
                    var min_date=$('#min-date').val();
                    var max_date=$('#max-date').val();
                    if(min_date =='' && max_date =='')
                    {
                        const status=$(this).val();
                         table.ajax.reload(null, false);
                    }

                })

                //resest filtering
                $('#reset').on('click',function(){
                    // alert()
                    $('#min-date').val('');
                    $('#max-date').val('');
                    table.ajax.reload(null, false);
                })

                //Fetch data from Payment gateway and store into database
                $('#sync_data').click(function() {
                    $("#sync_data").attr( "disabled", "disabled" );
                    $("#sync_data").text('Loading...');

                    $.ajax({
                        url: '{{ url('coffee/fetch_and_save_foloosi_data') }}', // Your Node.js endpoint
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(response) {

                       Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        didClose: () => {

                            $("#sync_data").removeAttr("disabled");
                            $("#sync_data").text('Sync Data');
                            // Redirect to the home page
                            table.ajax.reload(null, false);
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

                            $("#sync_data").removeAttr("disabled");
                            $("#sync_data").text('Sync Data');
                            // Redirect to the home page
                            table.ajax.reload(null, false);
                            }
                        });
                        }
                    });
                });

    });
</script>
@endpush
@endsection
