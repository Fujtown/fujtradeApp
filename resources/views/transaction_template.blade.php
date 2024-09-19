<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    /*background: #f7f7f7;*/
}
h1{
    text-align:center;
}
.table-container {
    margin: 20px;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 10px 0;
}

th, td {
    padding: 10px 15px;
    text-align: left;
    border: 1px solid #bbb;
    
}

th {
    background-color: #95EBFF8F;
    color: #000;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

tbody tr:hover {
    background-color: #ddd;
}

    </style>
    <h1>Today TAP Transacations</h1>
    <div class="table-container">
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
</body>
</html>