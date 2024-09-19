/*
 Template Name: Zoter - Bootstrap 4 Admin Dashboard
 Author: Mannatthemes
 Website: www.mannatthemes.com
 File:Dashboard init js
 */

!function($) {
    "use strict";

    var Dashboard = function() {};

     //creates Stacked Chart
     Dashboard.prototype.createStackedChart = function (element, data, xkey, ykeys, labels, lineColors) {
        Morris.Bar({
            element: element,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            preUnits: "$",
            barSizeRatio: 0.4,
            stacked: true,
            labels: labels,
            hideHover: 'auto',
            resize: true, //defaulted to true
            gridLineColor: '#eeeeee',
            barColors: lineColors
        });
    },






    Dashboard.prototype.init = function () {



        /* Calender */
        window.addEventListener('load', function () {
			vanillaCalendar.init({
            disablePastDays: true
            });
        })

        /* BEGIN SVG WEATHER ICON */
        if (typeof Skycons !== 'undefined'){
            var icons = new Skycons(
                {"color": "#f1ac57"},
                {"resizeClear": true}
                ),
                    list  = [
                        "clear-day", "clear-night", "partly-cloudy-day",
                        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                        "fog"
                    ],
                    i;

                for(i = list.length; i--; )
                icons.set(list[i], list[i]);
                icons.play();
        };

        // Morris.Donut({
        //     element: 'donut-example',
        //     data: [
        //       {label: "Captured", value: 50},
        //       {label: "Declined", value: 114},
        //     ],
        //     resize: true,
        //     colors:[ '#44a2d2', '#ec536c'],
        //     labelColor: '#888',
        //     backgroundColor: 'transparent',
        //     fillOpacity: 0.1,
        // });
        function updateDonutChart() {
            $.ajax({
                url: '/coffee/chart-data', // URL to your endpoint
                method: 'GET',
                success: function(data) {
                    console.log(data['summary_counts']);
                    $('.paid').text(data['status_counts'][0]['value']);
                    $('.failed').text(data['status_counts'][1]['value']);
                    $('.recieve_pay').text(data['summary_counts'][0]['value']);
                    $('.refund').text(data['summary_counts'][1]['value']);
                    // Assuming 'data' is the array of objects returned from your server
                    Morris.Donut({
                        element: 'donut-example',
                        data: data['status_counts'],
                        resize: true,
                        colors: ['#44a2d2', '#ec536c','#f5b225'],
                        labelColor: '#888',
                        backgroundColor: 'transparent',
                        fillOpacity: 0.1,
                    });
                },
                error: function(error) {
                    console.log('Error fetching chart data:', error);
                }
            });
        }

        // Call the function to update the chart, e.g., on page load or on a specific event
        updateDonutChart();
        function createStackedChart(elementId, data, ykey, barKeys, labels, colors) {
            new Morris.Bar({
                element: elementId,
                data: data,
                xkey: ykey,
                ykeys: barKeys,
                labels: labels,
                stacked: true,
                barColors: colors
            });
        }

        //creating Stacked chart
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/coffee/revenue-data',
            type: 'GET',
            dataType: 'json',
            success: function(responseData) {
                // console.log(responseData);

            // Group data by date for easier processing
var dataByDate = {};
responseData.forEach(function(item) {
    if (!dataByDate[item.y]) {
        dataByDate[item.y] = {};
    }
    // console.log(dataByDate);
    // Assuming 'currency' is a property of each item
    if (!dataByDate[item.y][item.currency]) {
        dataByDate[item.y][item.currency] = { a: 0, b: 0 };
    }

    dataByDate[item.y][item.currency].a += parseFloat(item.a);
    dataByDate[item.y][item.currency].b += parseFloat(item.b);
    // console.log(dataByDate)
});

// Extract unique dates and currencies
var dates = Object.keys(dataByDate).sort();

const currencyColors = {
    "USD": "#4e73df",
    "EUR": "#1cc88a",
    "GBP": "#36b9cc",
    "AED": "#c44edf",
    // Add more currencies and colors as needed
};
var currencies = new Set();

responseData.forEach(item => currencies.add(item.currency));
console.log(currencies)
// Prepare datasets
var datasets = [];
currencies.forEach(function(currency) {
    var capturedAmounts = [];
    var failedAmounts = [];
    var sumCaptured = 0;
    var sumFailed = 0;

    dates.forEach(date => {
        var captured = dataByDate[date][currency] ? dataByDate[date][currency].a : 0;
        var failed = dataByDate[date][currency] ? dataByDate[date][currency].b : 0;
        capturedAmounts.push(captured.toFixed(2));
        failedAmounts.push(failed.toFixed(2));
        sumCaptured += captured;
        sumFailed += failed;
    });

    // Add dataset for captured amounts for this currency
    datasets.push({
        label: `Captured Amount - ${currency} (Total: ${sumCaptured.toFixed(2)})`,
        data: capturedAmounts,
        backgroundColor: currencyColors[currency] || "#999999",
    });

    // Add dataset for failed amounts for this currency
    datasets.push({
        label: `Failed Amount - ${currency} (Total: ${sumFailed.toFixed(2)})`,
        data: failedAmounts,
        backgroundColor: '#e6edf3',
    });
});
// Initialize the chart
var ctx = document.getElementById('revenueChart').getContext('2d');
var revenueChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: dates, // Assuming 'dates' is your array of date labels
        datasets: datasets, // Your datasets array
    },
    options: {
        scales: {
            x: { stacked: true },
            y: { stacked: true }
        },
        plugins: {
            // Configuration for datalabels plugin
            datalabels: {

            }
        },
        annotation: {
            annotations: []
        }
    }

});

datasets.forEach(function(dataset, index) {
    if (dataset.label.includes('Captured Amount')) {
        var annotations = dates.map(function(date, i) {
            return {
                type: 'text',
                xScaleID: 'x',
                yScaleID: 'y',
                xValue: date,
                yValue: dataset.data[i] + 2, // Adjust the vertical position
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                fontSize: 12,
                fontStyle: 'bold',
                fontColor: '#fff',
                textAlign: 'center',
                content: dataset.data[i].toString(), // Display the amount
            };
        });

        // Add annotations to the chart
        revenueChart.options.annotation.annotations.push(...annotations);
    }
});

// Update the chart to reflect the changes
revenueChart.update();
            },
            error: function(error) {
                console.log(error);
            }
        });

        // var $stckedData = [
        //     {y: '1', a: 45, b: 180},
        //     {y: '2', a: 75, b: 65},
        //     {y: '3', a: 100, b: 90},
        //     {y: '4', a: 75, b: 65},
        //     {y: '5', a: 100, b: 90},
        //     {y: '6', a: 75, b: 65},
        //     {y: '7', a: 50, b: 40},
        //     {y: '8', a: 75, b: 65},
        //     {y: '9', a: 50, b: 40},
        //     {y: '10', a: 75, b: 65},
        //     {y: '11', a: 100, b: 90},
        //     {y: '12', a: 80, b: 65},
        //     {y: '13', a: 45, b: 180},
        //     {y: '14', a: 75, b: 65},
        //     {y: '15', a: 100, b: 90},
        //     {y: '16', a: 75, b: 65},
        //     {y: '17', a: 100, b: 90},
        //     {y: '18', a: 75, b: 65},
        //     {y: '19', a: 50, b: 40},
        //     {y: '20', a: 75, b: 65},
        //     {y: '21', a: 50, b: 40},
        //     {y: '22', a: 75, b: 65},
        //     {y: '23', a: 100, b: 90},
        //     {y: '24', a: 80, b: 65},
        //     {y: '25', a: 50, b: 40},
        //     {y: '26', a: 75, b: 65},
        //     {y: '27', a: 50, b: 40},
        //     {y: '28', a: 75, b: 65},
        //     {y: '29', a: 100, b: 90},
        //     {y: '30', a: 80, b: 65}
        // ];
        // this.createStackedChart('morris-bar-stacked', $stckedData, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#44a2d2', '#e6edf3']);




        //creating area chart


    },
    $.Dashboard = new Dashboard, $.Dashboard.Constructor = Dashboard

}(window.jQuery),

//initializing
function($) {
    "use strict";
    $.Dashboard.init()
}(window.jQuery);

