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
                            <li class="breadcrumb-item active">All Noon Links</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List Of Created Noon Links</h4>
                    <div class="row mobile-width">
                        <div class="col-md-5 col-sm-12">
                            <div class="form-group mb-0">
                                <h6 class="sub-title my-3">Date Range</h6>
                                <div>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" autocomplete="off" id="min-date" class="form-control" name="start" placeholder="Start Date" />
                                        <input type="text" autocomplete="off" id="max-date" class="form-control" name="end" placeholder="End Date" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <h6 class="sub-title my-3">Filter By Status</h6>
                            <select name="" class="form-control status" id="">
                                <option value="">Select Status</option>
                                <option value="open">Open</option>
                                <option value="close">Close</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <h6 class="sub-title my-3">&nbsp;</h6>
                            <button class="btn btn-info" id="search">Search</button>
                            <button class="btn btn-warning" id="reset">Reset</button>
                        </div>
                    </div><br>
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
                                {{-- <a href="{{route('coffee.new_link')}}" class="btn btn-primary pull-right" id="sync_data">New Link</a> --}}
                                <h4 class="mt-0 header-title">List Of Created Noon Links</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Link Type</th>
                                        <th>Link Payment</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
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

        <!-- Modal -->
        <div class="modal fade" id="exampleModalform" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form id="updateLink" action="#">
                    <input type="hidden" name="id" class="link_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Link</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Select Link Type</label>
                            <div class="col-sm-8">
                                <select name="payment_type" class="custom-select update-paymentType paymentType">
                                    <option value="open">Open</option>
                                    <option value="close">Close</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Amount</label>
                            <div class="col-sm-8">
                                <input name="amount" class="form-control update-amount" type="text" value="" id="example-text-input">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label">Select Currency</label>
                            <div class="col-sm-8">
                                <select name="currency" class="custom-select update-currency">
                                    <option value="AED">AED</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary update-btn">Update</button>
                    </div>
                </div>
            </form>
            </div>
        </div>


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
    function formatDate(org_date) {
     // Convert to a Date object
     var date = new Date(org_date);

        // Options to define the format
        var options = { year: 'numeric', month: 'short', day: 'numeric' };

        // Format the date
        var formattedDate = date.toLocaleDateString('en-US', options);

        // Replace '-' with spaces if needed (optional)
         // Adjust the format by removing comma, and rearranging components
    formattedDate = formattedDate.replace(/, /g, '-'); // Remove comma and space
    formattedDate = formattedDate.replace(/ /g, '-'); // Replace remaining spaces with hyphens

    // Split and rearrange to match desired format: 2024-Feb-03
    var parts = formattedDate.split('-');
    formattedDate = `${parts[2]}-${parts[0]}-${parts[1]}`;

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
                url: '{{ url('coffee/agent/get_all_noon_links') }}',
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
            { data: 'amount'},
            { data: 'currency'},
            { data: 'payment_type' },
             { data: 'link_payment', render: function(data, type, row) {
            return '<p style="text-transform:uppercase">'+data+'</p>'; // Format the date
          }},
            {
                data: 'agent.username',
                defaultContent: 'No Agent',
                render: function(data, type, row) {
                    return data || 'No Agent';
                }
            },
             
            { data: 'created_at', render: function(data, type, row) {
            return formatDate(data); // Format the date
          }},
            { data: null, render: function (data, type, row, meta) {
                return '<button class="copy-url" style="border: none;cursor: pointer;" data-url="'+row.url+'"><i  class="fa fa-copy text-info "></i></button> | <button type="button" class="edit_btn"  data-toggle="modal" data-target="#exampleModalform" data-id="'+row.id+'" style="border: none;cursor: pointer;"><i class="fa fa-edit text-success"></i></button> | <button class="delete-btn" data-id="'+row.id+'" style="border: none;cursor: pointer;"><i class="fa fa-trash text-danger "  ></i></button>';
            }}

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

          $(document).on('click','.copy-url',function(){
            var url=$(this).data('url');
            // Create a temporary input element
            var tempInput = $("<input>");
                $("body").append(tempInput);

                // Set the input element's value to the text you want to copy
                tempInput.val(url).select();

                // Execute the copy command
                document.execCommand('copy');

                // Remove the temporary input element
                tempInput.remove();

                // Show a success message (you can customize this part)
                Swal.fire({
                      icon: 'success',
                      title: 'Great !',
                      text: "URL copied to clipboard: " + url,
                  });
          })

          $(document).on('click','.delete-btn', function () {
            const itemId = $(this).data('id'); // Get item ID

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, send AJAX request to delete the item

                    $.ajax({
                        url: '{{ url('coffee/agent/delete_noon_link') }}', // Your API endpoint to delete the item
                        type: 'GET',
                        data: {
                            id: itemId,
                            _method: 'GET', // For Laravel, to simulate DELETE request
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                        },
                        success: function(response) {
                            // Handle success. For example, remove the item from the DOM
                            Swal.fire({
                        icon: 'success',
                        title: 'Delete',
                        text: 'Link has deleted successfully',
                        didClose: () => {
                            location.reload();
                            }
                        });

                            // Optionally, remove the item from the DOM or refresh the page
                        },
                        error: function(xhr, status, error) {
                            // Handle failure
                            Swal.fire(
                                'Error!',
                                'An error occurred while deleting the item.',
                                'error'
                            );
                        }
                    });
                }
            });
    });

        $(document).on('click','.edit_btn',function() {
            $('.update-amount').val('');
            $('.update-paymentType').val('');
            $('.update-currency').val('');

            var id = $(this).data('id');
            $('.link_id').val(id);
            $.ajax({
                url: '{{ url('coffee/agent/get_noon_link_detail') }}',
                type: 'GET',
                data: {
                      id: id,
                        },
                success: function(response) {
                    let data=response.data;
                    $.map(data, function (elementOrValue, indexOrKey) {
                        $('.update-amount').val(elementOrValue.amount);
                        $('.update-paymentType').val(elementOrValue.payment_type);
                        $('.update-currency').val(elementOrValue.currency);
                    });
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
        });

        //Update payment Script

        $('.update-btn').click(function() {
                    $(".update-btn").attr( "disabled", "disabled" );
                    $(".update-btn").text('Loading...');
                    var data = new FormData(document.getElementById("updateLink"));

                    $.ajax({
                         url: '{{ url('coffee/agent/update_noon_link') }}',
                         type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            didClose: () => {
                                location.reload();
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

                            $(".update-btn").removeAttr("disabled");
                            $(".update-btn").text('Update');
                            }
                        });
                        }
                    });
                });
    });
</script>

@endpush
@endsection
