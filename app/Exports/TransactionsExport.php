<?php

namespace App\Exports;

use App\Models\PaymentLedger;
use App\Models\PaymentByLink;
use App\Models\TapRefunds;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;
class TransactionsExport implements FromCollection,WithHeadings,WithStyles,WithEvents
{
      protected $date;

    public function __construct($date = null)
    {
        $this->date = $date;
    }
    
        use Exportable, RegistersEventListeners;
   
    
        public function collection()
    {
        
            $minDate = Carbon::createFromFormat('Y-m-d', $this->date)->startOfDay();
        $maxDate = Carbon::createFromFormat('Y-m-d', $this->date)->endOfDay();
        
        $startDate = $minDate->timestamp * 1000;
        $endDate = $maxDate->timestamp * 1000;
        // dd($endDate);
         // Fetch all refunded transaction IDs within the specified date range
    $refundedTransactionIds = TapRefunds::whereBetween('created', [$startDate, $endDate])
                                           ->pluck('charge_id')->toArray();
        // dd($refundedTransactionIds);                                   
           // Fetch transactions within the specified date range, excluding refunded transactions
    $foloosi_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
                                      ->where('source_table', 'all_tap_payment')
                                      ->whereNotIn('transaction_no', $refundedTransactionIds)
                                      ->with(['PaymentByLink' => function ($query) {
                                          $query->select('ch_id', 'agentID')
                                                ->with(['admin' => function ($query) {
                                                    $query->select('id', 'username');
                                                }]);
                                      }])
                                      ->get(['id', 'amount', 'date', 'full_name', 'transaction_no', 'currency']);
    
    if ($foloosi_transactions->isEmpty()) {
        return new Collection([['message' => 'No transactions found for the specified date, excluding refunds.']]);
    }
    
    
    
    // Fetch transactions within the specified date range
    // $foloosi_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
    //                                   ->where('source_table', 'all_tap_payment')
    //                                   ->with(['PaymentByLink' => function ($query) {
    //                                       $query->select('ch_id', 'agentID')
    //                                             ->with(['admin' => function ($query) {
    //                                                 $query->select('id', 'username');
    //                                             }]);
    //                                   }])
    //                                   ->get(['id', 'amount', 'date', 'full_name', 'transaction_no', 'currency']);
   
    // If no transactions are found, return an empty collection with a custom message
    if ($foloosi_transactions->isEmpty()) {
        return new Collection([['message' => 'There is no transaction found today']]);
    }
     $sn = 1; // Initialize serial number
    // Process each transaction to format the date and include the agent username
    $processedTransactions = $foloosi_transactions->map(function ($transaction) use (&$sn) {
        $formattedDate = Carbon::createFromTimestampMs($transaction->date)->format('Y-m-d');
        $agentUsername = optional(optional($transaction->PaymentByLink)->admin)->username ?? 'N/A';
        // dd($agentUsername);
        return [
             'SN' => $sn++,
            'Amount' => $transaction->amount,
            'Currency' => $transaction->currency,
            'Date' => $formattedDate,
            'Customer' => $transaction->full_name,
            'Agent' => $agentUsername,
        ];
    });

    // Sum the amount for records within the specified date range by currency
    $currencyTotals = $foloosi_transactions->groupBy('currency')
                                        ->mapWithKeys(function ($transactions, $currency) {
                                            return [$currency => $transactions->sum('amount')];
                                        });
        $totalsByCurrency = $currencyTotals->map(function ($totalAmount, $currency) {
            return [
                'currency_total' => $currency,
                'amount_total' => $totalAmount,
            ];
        })->values()->all();
        
      
    // Combine the transaction details and the totals by currency
    $finalData = $processedTransactions->merge($totalsByCurrency);
  
    // return ;
      $data = $processedTransactions->toArray();
        $data[] = ['Totals by Currency']; // Optionally add a separator or title
        $data = array_merge($data, $totalsByCurrency);
        // dd($data);
     return collect($data);
    }
    
      public function headings(): array
    {
        return [
            'SN',
            'Amount',
            'Currency',
            'Date',
            'Customer',
            'Agent'
        ];
    }
    
     public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold with light green background
            1    => ['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['argb' => 'FF90EE90']]],
        ];
    }
    
      public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestColumn = $sheet->getHighestColumn();
                $highestRow = $sheet->getHighestRow();
                
                // Loop through each column in the sheet
                for ($column = 'A'; $column <= $highestColumn; $column++) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
                
                // Optionally, adjust row height if needed
                for ($row = 1; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
                
                 
                // Example: Loop through each row to find "Totals by Currency"
                for ($row = 1; $row <= $highestRow; $row++) {
                    $cellValue = $sheet->getCell('A'.$row)->getValue();
                    if ($cellValue === 'Totals by Currency') {
                        // Apply styles when the cell matches the specific content
                        $sheet->getStyle('A'.$row.':E'.$row)->applyFromArray([
                            'font' => [
                                'bold' => true,
                                'color' => ['argb' => 'FFFFFFFF'], // White color
                            ],
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => ['argb' => 'FFFFA500'], // Orange background
                            ],
                        ]);
                    }
                }
            },
        ];
    }
    

}
