@extends('layouts.admin') <!-- Extending the master layout -->

@section('content') <!-- Defining the content section -->
<style>
    /* .d-none{
        display: none;
    } */
</style>
<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Fujtrade</a></li>
                            <li class="breadcrumb-item active">New Refund Request</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create New Refund Request</h4>
                    <br>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <form id="createLink" action="">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Customer Name</label>
                                        <div class="col-sm-8">
                                            <input name="customer_name" class="form-control" type="text" value="" id="amount">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Email</label>
                                        <div class="col-sm-8">
                                            <input name="email" class="form-control" type="email" value="" id="amount">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Phone</label>
                                        <div class="col-sm-8">
                                            <input name="phone" class="form-control" type="text" value="" id="amount">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Refund Amount</label>
                                        <div class="col-sm-8">
                                            <input name="amount" class="form-control" type="text" value="" id="amount">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">&nbsp;</div>
                                        <div class="col-sm-8">
                                           <input type="button" class="btn btn-info generate" value="Generate">
                                        </div>
                                    </div>
                                </form>
                                <input type="hidden" id="share_link">

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

 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
 {{-- <script src="{{asset('admin_assets/js/share.js')}}"></script> --}}
<script>
    $(document).ready(function() {
        $('.share').hide();
    })
       //Fetch data from Payment gateway and store into database
       $('.generate').click(function() {
                    $(".generate").attr( "disabled", "disabled" );
                    $(".generate").text('Loading...');
                    var data = new FormData(document.getElementById("createLink"));

                    $.ajax({
                        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                         url: '{{ url('coffee/agent/store_refund_request') }}',
                         type: "POST",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(response) {

                        //   alert(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.success,
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

                            $(".generate").removeAttr("disabled");
                            $(".generate").text('Generate');
                            }
                        });
                        }
                    });
                });




</script>
@endpush
@endsection
