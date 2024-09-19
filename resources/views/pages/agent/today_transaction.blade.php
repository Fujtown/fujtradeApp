@extends('layouts.admin') 
@section('content') 

<div class="wrapper">
    <style>
    .table-responsive{
        display:inline-table !important;
    }
    @media only screen and (max-width: 680px) {
  .table-responsive{
        display:block !important;
    }
}

@media print {
  body * {
    display: none !important;
  }
  .printable, .printable * {
    display: block !important;
  }
  /* Reset other styles as needed to ensure correct display */
}
</style>
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="#">Fujtrade</a></li>
                            <li class="breadcrumb-item active">Today Transactions</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Today Transactions</h4>
                     <form <form action="{{ route('coffee.agent.todayTransaction') }}" method="GET">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    
                                       <div class="row">
                                             <div class="col-md-5">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text"  id="min-date" class="form-control" name="start" placeholder="Start Date" />
                                                </div>
                                    </div>
                                   
                                    <div class="col-md-5">
                                        <button type="submit" class="btn btn-dark" id="search">Search</button>
                                        <a href="{{ route('coffee.agent.todayTransaction') }}" class="btn btn-warning" id="reset">Reset</a>
                                    </div>
                                       </div>
                                       
                                       
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>  
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-6 ">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">TAP Transactions</h4>
                             
                                  <div class="row">
                                     <div class="col-md-5">
                                           @php
                                    $queryParams = [];
                                    if (request()->has('start')) {
                                        $queryParams['start'] = request()->get('start');
                                    }
                                    $urlWithParams = url('coffee/agent/exportTapTransactionsPdf', $queryParams);
                                     $urlWithParamsexcel = url('coffee/agent/exportExcelTap', $queryParams);
                                @endphp
                                
                                <a href="{{ $urlWithParams }}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf"></i> Export Pdf</a>
                                           <!--<a href="{{url('coffee/exportTapTransactionsPdf')}}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf"></i> Export Pdf</a>-->
                               <!--<a href="{{ $urlWithParamsexcel }}" class="btn btn-dark btn-sm"><i class="fa fa-file-excel"></i> Export Excel</a>-->
                                     </div>
                                    
                                    
                                    
                                </div>
                                
                                <table class="table table-striped table-bordered table-responsive printable">
                                    <thead>
                                    <tr>
                                        <th >#</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Agent</th>
                                    </tr>
                                    </thead>
    
                                    <tbody>
                                       
                                        
                                       @if($filteredTapTransactions->isEmpty())
                                       
                                       <tr>
                                           <th colspan="5" style="text-align:center">NO Transaction Found Today</th>
                                       </tr>
                                       
                                       @else
                                       
                                        @php $counter = 1; @endphp
                                     @foreach ($filteredTapTransactions as $transaction)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ number_format($transaction->amount, 2, '.', ',') }} <span>{{ $transaction->currency }}</span></td>
                                        <td>{{ \Carbon\Carbon::createFromTimestampMs($transaction->date)->format('Y-m-d') }}</td>
                                        <td>{{ $transaction->full_name }}</td>
                                        <td>{{ $transaction->agentUsername }}</td>
                                    </tr>
                                                @php $counter++; @endphp
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                        <th style="text-align:center;font-size:18px" colspan="5">Total Amount By Currency Wise</th>    
                                        </tr>
                                        
                                    @foreach ($totalsByCurrency as $tcurrency)
                                        <tr>
                                        <th style="text-align:center;font-size:18px">{{ $tcurrency['currency_total'] }}</th>  
                                        <th colspan="2" style="text-align:center;font-size:18px">{{ number_format($tcurrency['amount_total'], 2, '.', ',') }}</th>  
                                        </tr>
                                         @endforeach
                                    </tfoot>
                                    
                                    @endif
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div><!--end row-->


            </div><!--end col-->
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">Foloosi Transactions</h4>
                                                                @php
                                    $queryParams = [];
                                    if (request()->has('start')) {
                                        $queryParams['start'] = request()->get('start');
                                    }
                                    $urlWithParams = url('coffee/agent/exportFoloosiTransactionsPdf', $queryParams);
                                     $urlWithParamsexcel = url('coffee/agent/exportFoloosiExcelTap', $queryParams);
                                @endphp
                                
                                <a href="{{ $urlWithParams }}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf"></i> Export Pdf</a>

                                  <!--<a href="{{url('coffee/exportFoloosiTransactionsPdf')}}" target="_blank" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf"></i> Export Pdf</a>-->
                               <!--<a href="{{ $urlWithParamsexcel }}" class="btn btn-dark btn-sm"><i class="fa fa-file-excel"></i> Export Excel</a>-->
                               
                                <table id="datatable-buttons" class="table table-striped table-bordered  table-responsive">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Agent</th>
                                    </tr>
                                    </thead>


                                    <tbody>
                                         @if($foloosi_transactions->isEmpty())
                                       
                                       <tr>
                                           <th style="text-align:center" colspan="5">NO Transaction Found Today</th>
                                       </tr>
                                       
                                       @else
                                         @php $counter = 1; @endphp
                                     @foreach ($foloosi_transactions as $ftransaction)
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ number_format($ftransaction->amount, 2, '.', ',') }} <span>{{ $ftransaction->currency }}</span></td>
                                        <td>{{ \Carbon\Carbon::createFromTimestampMs($ftransaction->date)->format('Y-m-d') }}</td>
                                        <td>{{ $ftransaction->full_name }}</td>
                                       <td>{{ $ftransaction->agentUsername }}</td>
                                    </tr>
                                                @php $counter++; @endphp
                                    @endforeach  
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                        <th style="text-align:center;font-size:18px" colspan="5">Total Amount By Currency Wise</th>    
                                        </tr>
                                        
                                    @foreach ($totalsByCurrency2 as $fcurrency)
                                        <tr>
                                        <th style="text-align:center;font-size:18px">{{ $fcurrency['currency_total'] }}</th>  
                                        <th colspan="2" style="text-align:center;font-size:18px">{{ number_format($fcurrency['amount_total'], 2, '.', ',') }}</th>  
                                        </tr>
                                         @endforeach
                                    </tfoot>
                                     @endif
                                </table>

                            </div>
                        </div>
                    </div> <!-- end col -->

                </div><!--end row-->


            </div><!--end col-->
            
             <div class="col-xl-12">
                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                             <table id="datatable-buttons" class="table table-striped table-bordered  table-responsive">
                                   <tbody>
                                       <tr colspan="2">
                                           <th>Grand Total</th>
                                       </tr>
                                        @if(empty($finalTotalsByCurrency))
                                       
                                       <tr>
                                           <th style="text-align:center" colspan="5">NO Transaction Found Today</th>
                                       </tr>
                                         @else
                                         
                                          @foreach ($finalTotalsByCurrency as $gtotal)
                                       <tr>
                                           <th>{{ $gtotal['currency_total'] }}</th>
                                           <th>{{ number_format($gtotal['amount_total'], 2, '.', ',') }}</th>
                                       </tr>
                                         @endforeach
                                            @endif
                                   </tbody>
                               </table> 
                                
                           </div>
                           
                           </div>
                          </div>
                      </div>
             </div>



        </div><!--end row-->



    </div> <!-- end container -->
</div>
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

 
                $('#search').on('click',function(){
                    var min_date=$('#min-date').val();
                })

          

                //resest filtering
                $('#reset').on('click',function(){
                    // alert()
                    $('#min-date').val('');
                })

          

    });
</script>

@endpush

@endsection
