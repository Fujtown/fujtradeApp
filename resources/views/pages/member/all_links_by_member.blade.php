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
                            <li class="breadcrumb-item active">All Links</li>
                        </ol>
                    </div>
                    <h4 class="page-title">List Of Created Links</h4>
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
                                <h4 class="mt-0 header-title">List Of Created Links</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>Link Type</th>
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
                url: '{{ url('coffee/member/get_all_links') }}',
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



    });
</script>

@endpush
@endsection
