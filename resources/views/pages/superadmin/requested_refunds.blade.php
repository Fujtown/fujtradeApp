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
                            <li class="breadcrumb-item active">All Refunds Request</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List of Refunds Request</h4>

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
                                {{-- <button class="btn btn-primary pull-right" id="sync_data">Sync Data</button> --}}
                                <h4 class="mt-0 header-title">List Of Refunds Request</h4>

                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Refund Amount</th>
                                        <th>Agent Name</th>
                                        <th>Requested Date</th>
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




    </div> <!-- end container -->
</div>
<!-- end wrapper -->
@push('scripts')
 <!-- Required datatable js -->
 <script src="/admin_assets/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="/admin_assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
 <!-- Buttons examples -->
 <script src="/admin_assets/plugins/datatables/dataTables.buttons.min.js"></script>
 <script src="/admin_assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
 <script src="/admin_assets/plugins/datatables/jszip.min.js"></script>
 <script src="/admin_assets/plugins/datatables/pdfmake.min.js"></script>
 <script src="/admin_assets/plugins/datatables/vfs_fonts.js"></script>
 <script src="/admin_assets/plugins/datatables/buttons.html5.min.js"></script>
 <script src="/admin_assets/plugins/datatables/buttons.print.min.js"></script>
 <script src="/admin_assets/plugins/datatables/buttons.colVis.min.js"></script>
 <!-- Responsive examples -->
 <script src="/admin_assets/plugins/datatables/dataTables.responsive.min.js"></script>
 <script src="/admin_assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
 <script src="/admin_assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

 <script>
     var table=$('#datatable-buttons').DataTable({
    "dom": 'Bfrtip',
            "serverSide": false,
            "bSortable": true,
            "lengthChange": true,
            "responsive": true,
            "ajax": function(data, callback, settings) {

            $.ajax({
                url: '{{ url('coffee/get_all_refund_requests') }}',
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
            { data: 'phone'},
            { data: 'refund_amount'},
            {
                data: 'agent.username',
                defaultContent: 'No Agent',
                render: function(data, type, row) {
                    return data || 'No Agent';
                }
            },
            { data: 'status', render: function (data, type, row, meta) {
                return data == 0 ? '<span class="text-warning">Pending</span>' : '<span class="text-primary">Completed</span>';
            }},


            { data: null, render: function (data, type, row, meta) {
                return row.status == 0 ? '<button class="confirm-refund btn btn-primary" data-id="'+row.id+'" style="border: none;cursor: pointer;">Refund Amount</button>' : '<button class="btn btn-info" disabled data-id="'+row.id+'" style="border: none;cursor: pointer;">Refunded</button>';
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

    $(document).on('click','.confirm-refund', function () {
            const itemId = $(this).data('id'); // Get item ID

            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure to confirm refund?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirm it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, send AJAX request to delete the item

                    $.ajax({
                        url: '{{ url('coffee/confirm_refund') }}', // Your API endpoint to delete the item
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
                        title: 'Confirmed',
                        text: 'Refund Accepted successfully',
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
 </script>

@endpush
@endsection
