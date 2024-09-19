@extends('layouts.app') <!-- Extending the master layout -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">
@section('content') <!-- Defining the content section -->
   <!-- header end -->
        <!-- breadcrumb content begin -->
<style>
    .error {
    color: red;
    font-size: 0.8em;
}
.dataTables_length,.dataTables_info{
    display: none !important;
}
.ui-widget-header{
    border: none !important;
    background: rgba(255, 255, 255, 0.1);
}
.even td{
    background: #463a5c2e
}
td a{
    color: #4747a5
}

</style>
        <!-- breadcrumb content end -->
    <main>
    <!-- section content begin -->
    <div class="uk-section">
        <div class="uk-container">
            <div class="uk-grid uk-flex uk-flex-center in-contact-6">

                <div class="uk-width-1-1@m">

                    <!-- <hr class="uk-margin-medium"> -->
                    <h4 class="uk-margin-remove-bottom uk-text-muted uk-text-center">Capitalize on supply and demand dynamics and let your trading skills fuel your success by investing in commodities such as Apple.</h4>
                  <h1 class="uk-margin-small-top uk-text-center">Let's <span class="in-highlight">Discover a World of Opportunities</span></h1>
                  <!-- TradingView Widget BEGIN -->
<!-- TradingView Widget BEGIN -->
                    <div class="uk-grid uk-flex uk-flex-center" style="margin-top: 100px;">
                        <div class="uk-width-3-4@m">
                            <div class="uk-child-width-1-3 uk-grid" data-uk-grid="">
                                <div class="uk-flex uk-flex-middle uk-first-column">
                                  <!-- TradingView Widget BEGIN -->
                                    <!-- TradingView Widget BEGIN -->
                                    <div class="tradingview-widget-container">
                                        <div class="tradingview-widget-container__widget"></div>
                                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                        {
                                        "symbol": "TVC:USOIL",
                                        "width": "100%",
                                        "height": "100%",
                                        "locale": "en",
                                        "dateRange": "12M",
                                        "colorTheme": "dark",
                                        "isTransparent": false,
                                        "autosize": true,
                                        "largeChartUrl": ""
                                    }
                                        </script>
                                    </div>
                                    <!-- TradingView Widget END -->
                                    <!-- TradingView Widget END -->
                                </div>
                                <div class="uk-flex uk-flex-middle">
                                   <!-- TradingView Widget BEGIN -->
                                    <div class="tradingview-widget-container">
                                        <div class="tradingview-widget-container__widget"></div>
                                        <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                        {
                                        "symbol": "CAPITALCOM:NATURALGAS",
                                        "width": "100%",
                                        "height": "100%",
                                        "locale": "en",
                                        "dateRange": "12M",
                                        "colorTheme": "dark",
                                        "isTransparent": false,
                                        "autosize": true,
                                        "largeChartUrl": ""
                                    }
                                        </script>
                                    </div>
                                    <!-- TradingView Widget END -->
                                </div>
                                <div class="uk-flex uk-flex-middle">
                                  <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget"></div>
                                    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                    {
                                    "symbol": "SKILLING:COCOA",
                                    "width": "100%",
                                    "height": "100%",
                                    "locale": "en",
                                    "dateRange": "12M",
                                    "colorTheme": "dark",
                                    "isTransparent": false,
                                    "autosize": true,
                                    "largeChartUrl": ""
                                }
                                    </script>
                                </div>
                                <!-- TradingView Widget END -->
                                </div>

                                <div class="uk-flex uk-flex-middle">
                                  <!-- TradingView Widget BEGIN -->
                              <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                                <div class="tradingview-widget-container__widget"></div>
                                <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                {
                                "symbol": "PEPPERSTONE:COFFEE",
                                "width": 350,
                                "height": 220,
                                "locale": "en",
                                "dateRange": "12M",
                                "colorTheme": "dark",
                                "isTransparent": false,
                                "autosize": false,
                                "largeChartUrl": ""
                            }
                                </script>
                            </div>
  <!-- TradingView Widget END -->
                                <!-- TradingView Widget END -->
                                </div>

                            </div>
                        </div>
                    </div>
  <!-- TradingView Widget END -->
  <!-- TradingView Widget END -->

                </div>
            </div>
        </div>
    </div>
    <!-- section content end -->
    </main>
@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.jqueryui.min.js"></script>
<script>
    new DataTable('#example');
</script>
@endpush
@endsection

