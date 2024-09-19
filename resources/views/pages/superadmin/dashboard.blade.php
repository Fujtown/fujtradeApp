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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                     <div class="col-lg-3">
                         <a href="{{ url('coffee/todayTransaction') }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="col-3 align-self-center">
                                        <div class="round">
                                            <img src="{{ asset('admin_assets/images/recpay.png') }}" alt="">
                                            {{-- <i class="mdi mdi-eye"></i> --}}
                                        </div>
                                    </div>
                                    <div class="col-9 align-self-center text-right">
                                        <div class="m-l-10">
                                            <h5 class="mt-0 recieve_pay" style="color: black;">150</h5>
                                            <p class="mb-0 text-muted" >Today Recieve Payments <span class="badge bg-soft-success"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height:3px;">
                                    <div class="progress-bar  bg-success" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                        </a>
                    </div><!--end col-->


                    <div class="col-lg-3">
                        
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="col-3 align-self-center">
                                        <div class="round">
                                            <img src="{{ asset('admin_assets/images/paid.png') }}" alt="">
                                            {{-- <i class="mdi mdi-eye"></i> --}}
                                        </div>
                                    </div>
                                    <div class="col-9 align-self-center text-right">
                                        <div class="m-l-10">
                                            <h5 class="mt-0 paid">150</h5>
                                            <p class="mb-0 text-muted">Paid Invoices <span class="badge bg-soft-success"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height:3px;">
                                    <div class="progress-bar  bg-success" role="progressbar" style="width: 35%;" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                        
                    </div><!--end col-->

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="col-3 align-self-center">
                                        <div class="round">
                                            <img style="width:50px" src="{{ asset('admin_assets/images/refund.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-9 text-right align-self-center">
                                        <div class="m-l-10 ">
                                            <h5 class="mt-0 refund">10</h5>
                                            <p class="mb-0 text-muted">Refund Invoices</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height:3px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 48%;" aria-valuenow="48" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->

                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="search-type-arrow"></div>
                                <div class="d-flex flex-row">
                                    <div class="col-3 align-self-center">
                                        <div class="round ">
                                            <img style="width:50px"  src="{{ asset('admin_assets/images/decline.png') }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-9 align-self-center text-right">
                                        <div class="m-l-10 ">
                                            <h5 class="mt-0 failed">50</h5>
                                            <p class="mb-0 text-muted">Failed Invoices</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="progress mt-3" style="height:3px;">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 61%;" aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Every Day Revenue</h4>
                        <p class="text-muted mb-4 font-14"></p>
                        <canvas id="revenueChart"></canvas>
                        {{-- <div id="morris-bar-stacked" class="morris-chart"></div> --}}
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->


        </div><!--end row-->


        <div class="row">
            <div class="col-xl-6 ">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title mt-0  mb-3">Summary</h5>
                        <div id="donut-example"></div>
                        <ul class="list-unstyled text-center text-muted mt-2 mb-0">
                            <li class="list-inline-item font-13"><i class="mdi mdi-album font-16 text-info mr-2"></i>CAPTURED</li>
                            <li class="list-inline-item font-13"><i class="mdi mdi-album font-16 text-danger mr-2"></i>DECLINED</li>
                            <li class="list-inline-item font-13"><i class="mdi mdi-album font-16 text-warning mr-2"></i>REFUND</li>
                        </ul>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->



            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title mt-0 mb-3">Calendar</h5>
                        <div id="v-cal">
                            <div class="vcal-header">
                                <button class="vcal-btn" data-calendar-toggle="previous">
                                    <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                                    </svg>
                                </button>

                                <div class="vcal-header__label" data-calendar-label="month">
                                    March 2017
                                </div>


                                <button class="vcal-btn" data-calendar-toggle="next">
                                    <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="vcal-week">
                                <span>Mon</span>
                                <span>Tue</span>
                                <span>Wed</span>
                                <span>Thu</span>
                                <span>Fri</span>
                                <span>Sat</span>
                                <span>Sun</span>
                            </div>
                            <div class="vcal-body" data-calendar-area="month"></div>
                        </div>
                    </div><!--end card-body-->
                </div><!--end card-->
            </div><!--end col-->
        </div> <!-- end row -->


    </div> <!-- end container -->
</div>
<!-- end wrapper -->
@push('scripts')
<script src="{{ asset('admin_assets/pages/dashborad.js') }}"></script>
@endpush
@endsection
