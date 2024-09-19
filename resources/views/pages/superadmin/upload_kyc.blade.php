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
                            <li class="breadcrumb-item active">New Agent</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Create New Agent</h4>
                    <br>

                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form id="filesUploadForm" action="">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Customer Name</label>
                                        <div class="col-sm-8">
                                            <input name="username" class="form-control" type="text" value="" id="amount">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-4 col-form-label">Select KYC (Files)</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="files[]" class="form-control"  multiple>
                                    </div>
                                </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">&nbsp;</div>
                                        <div class="col-sm-8">
                                           <input type="button" class="btn btn-info generate" value="Upload Now">
                                        </div>
                                    </div>
                                </form>

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
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
     //Fetch data from Payment gateway and store into database
       $('.generate').click(function() {
                    $(".generate").attr( "disabled", "disabled" );
                    $(".generate").text('Loading...');
                    var data = new FormData(document.getElementById("filesUploadForm"));

                    $.ajax({
                        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                         url: '{{ url('coffee/store_kyc') }}',
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
                            $(".generate").text('Uplaod Now');
                            }
                        });
                        }
                    });
                });

</script>
@endpush
@endsection
