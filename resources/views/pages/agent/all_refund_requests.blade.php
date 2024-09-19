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
                                <a href="{{route('coffee.agent.new_refund_request')}}" class="btn btn-primary pull-right" id="sync_data">New Request</a>
                                <h4 class="mt-0 header-title">List Of Refund Request</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Refund Amount</th>
                                        <th>Status</th>
                                        <th>Date</th>
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
        <form id="updateRefund" action="#">
            <input type="hidden" name="id" class="link_id">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Refund Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-4 col-form-label">Customer Name</label>
                    <div class="col-sm-8">
                        <input name="customer_name" class="form-control update-customername" type="text" value="" id="example-text-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-4 col-form-label">Email</label>
                    <div class="col-sm-8">
                        <input name="email" class="form-control update-email" type="text" value="" id="example-text-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-4 col-form-label">Phone</label>
                    <div class="col-sm-8">
                        <input name="phone" class="form-control update-phone" type="text" value="" id="example-text-input">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="example-text-input" class="col-sm-4 col-form-label">Amount</label>
                    <div class="col-sm-8">
                        <input name="amount" class="form-control update-amount" type="text" value="" id="example-text-input">
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

            $.ajax({
                url: '{{ url('coffee/agent/get_all_fund_requests') }}',
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
            { data: 'customer_name'},
            { data: 'email'},
            { data: 'phone' },
            { data: 'refund_amount' },
            { data: 'status', render: function(data, type, row) {
            return data==0 ? '<span style="color: #FF9800;font-weight: bold;">Pending</span>':'<span style="color: #4CAF50;font-weight: bold;">Complete</span>';
          }},
            { data: 'created_at', render: function(data, type, row) {
            return formatDate(data); // Format the date
          }},
            { data: null, render: function (data, type, row, meta) {
                return ' <button type="button" class="edit_btn"  data-toggle="modal" data-target="#exampleModalform" data-id="'+row.id+'" style="border: none;cursor: pointer;"><i class="fa fa-edit text-success"></i></button>';
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


    $(document).on('click','.edit_btn',function() {
            $('.update-amount').val('');
            $('.update-email').val('');
            $('.update-phone').val('');
            $('.update-customername').val('');

            var id = $(this).data('id');
            $('.refund_id').val(id);
            $.ajax({
                url: '{{ url('coffee/agent/get_refund_detail') }}',
                type: 'GET',
                data: {
                      id: id,
                        },
                success: function(response) {
                    let data=response.data;
                    $.map(data, function (elementOrValue, indexOrKey) {
                        $('.update-amount').val(elementOrValue.refund_amount);
                        $('.update-email').val(elementOrValue.email);
                        $('.update-phone').val(elementOrValue.phone);
                        $('.update-customername').val(elementOrValue.customer_name);
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
                    var data = new FormData(document.getElementById("updateRefund"));

                    $.ajax({
                         url: '{{ url('coffee/agent/update_refund_request') }}',
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
