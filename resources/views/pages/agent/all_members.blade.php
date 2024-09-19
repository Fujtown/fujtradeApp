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
                            <li class="breadcrumb-item active">All Members</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List Of Members</h4>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-body">
                                <a href="{{route('coffee.agent.new_link')}}" class="btn btn-primary pull-right" id="sync_data">New Link</a>
                                <h4 class="mt-0 header-title">List Of Members</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th class="all" width="5%">#</th>
                                        <th class="all" width="15%">Name</th>
                                        <th class="all" width="15%">Email</th>
                                        <th class="all" width="25%">Action</th>
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
                url: '{{ url('coffee/agent/get_all_members') }}',
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
            { data: 'username'},
            { data: 'email'},
            { data: null, render: function (data, type, row, meta) {
                return '<button class="delete-btn" data-id="'+row.id+'" style="border: none;cursor: pointer;"><i class="fa fa-trash text-danger "  ></i></button>';
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
                        url: '{{ url('coffee/agent/delete_member') }}', // Your API endpoint to delete the item
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
                        text: 'Memeber has deleted successfully',
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




    });
</script>

@endpush
@endsection
