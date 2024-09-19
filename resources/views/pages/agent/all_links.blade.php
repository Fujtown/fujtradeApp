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
                            <div class="card-body table-body">
                                <a href="{{route('coffee.agent.new_link')}}" class="btn btn-primary pull-right" id="sync_data">New Link</a>
                                <h4 class="mt-0 header-title">List Of Created Links</h4>
                                <br>
                                <table id="datatable-buttons" class="table table-striped table-bordered w-100">
                                    <thead>
                                    <tr>
                                        <th class="all" width="5%">#</th>
                                        <th class="all" width="15%">Amount</th>
                                        <th class="all" width="15%">Currency</th>
                                        <th class="none" width="15%">Link Type</th>
                                        <th class="all"width="15%" >Link Payment</th>
                                        <th class="none" width="25%">Created Date</th>
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
                url: '{{ url('coffee/agent/get_all_links') }}',
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
            { data: 'created_at', render: function(data, type, row) {
            return formatDate(data); // Format the date
          }},
            { data: null, render: function (data, type, row, meta) {
                return ' <a id="copy-link" data-text="Copy Link" style="border: none;cursor: pointer;" data-url="'+row.url+'"><img style="" src="{{ asset('admin_assets/icons/copy.png') }}" /></a> | <a  data-social="whatsapp" data-text="From Page Bottom Share Section" style="border: none;cursor: pointer;" data-url="'+row.url+'"><img style="" src="{{ asset('admin_assets/icons/whatsapp.png') }}" /></a> | <a data-social="telegram" data-text="From Page Bottom Share Section" data-url="'+row.url+'" style="border: none;cursor: pointer;"> <img style="" src="{{ asset('admin_assets/icons/telegram.png') }}" /></a>';
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

        //Share Link Script

        navigator.isMobileTablet = (function () {
	var check = false;
	(function (a) {
		if (
			/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(
				a
			) ||
			/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(
				a.substr(0, 4)
			)
		)
			check = true;
	})(navigator.userAgent || navigator.vendor || window.opera);
	return check;
})();

$(document).on('click','a[data-social]', function (e) {
    e.preventDefault();
    var BASE_URL = $(this).data('url');
    var ele = jQuery(this);
    var isMobileTablet = navigator.isMobileTablet;
    var shareUrl = "";
    var socialType = ele.attr('data-social');
    var title = document.title;
    var url = BASE_URL + "bnat/" + "?";
    var urlQueryParams;
    var queryParams;
    var sharePlace = ele.attr('data-text');
    switch (socialType) {
      case 'whatsapp':
        url = url + jQuery.param({
          utm_campaign: 'BNAT-Share-' + socialType,
          utm_source: socialType,
          utm_medium: 'referral',
        });
        if(navigator.isMobileTablet){
          shareUrl = 'https://api.whatsapp.com/send?text=' + url;
        }else{
         shareUrl = 'https://web.whatsapp.com/send?text=' + encodeURIComponent(url);
        }
        break;



      case 'telegram':
        url = url + jQuery.param({
          utm_campaign: 'BNAT-Share-' + socialType,
          utm_source: socialType,
          utm_medium: 'referral'
        });
        queryParams = jQuery.param({
          url: url,
          text: title
        });
        shareUrl = "https://telegram.me/share/url?" +queryParams;
        break;


      default:
        ;
    }

    window.open(shareUrl, "BNAT Social Sharing", "width=550, height=420, left=" + (screen.availWidth - 500) / 2 + ", top=" + (screen.availHeight - 500) / 2 + ", location=0, menubar=0, toolbar=0, status=0, scrollbars=1, resizable=1");
  });

   // When the "Copy Text" button is clicked
   $(document).on('click','#copy-link',function() {
                //  alert()
                // var id=$(this).data('id');
                // Get the text to copy
                var textToCopy = $(this).data('url');

                // Create a temporary input element
                var tempInput = $("<input>");
                $("body").append(tempInput);

                // Set the input element's value to the text you want to copy
                tempInput.val(textToCopy).select();

                // Execute the copy command
                document.execCommand('copy');

                // Remove the temporary input element
                tempInput.remove();

                // Show a success message (you can customize this part)
                alert("URL copied to clipboard: " + textToCopy);
            });

    });
</script>

@endpush
@endsection
