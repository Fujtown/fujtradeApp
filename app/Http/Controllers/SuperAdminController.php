<?php

namespace App\Http\Controllers;

use App\Models\TapRefunds;
use App\Models\AgentLinkLimit;
use App\Models\RefundRequest;
use ZipArchive;
use Carbon\Carbon;
use App\Models\Agent;
use App\Models\CustomerKYC;
use GuzzleHttp\Client;
use App\Models\Refunds;
use App\Models\TapPayment;
use Illuminate\Http\Request;
use App\Models\TapPaymentLink;
use App\Models\Foloosi;
use App\Models\PaymentLedger;
use App\Models\PaymentByLink;
use App\Models\NoonPaymentLink;
use App\Models\NoonTransaction;
use App\Models\AllFoloosiPayments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UniqueNumberGenerator;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FoloosiTransactionsExport;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
class SuperAdminController extends Controller
{
    public function __construct()
{
    $this->middleware('admin');
}

    public function dashboard(Request $request)
    {
        // dd();
        // $user = Auth::guard('admin')->user();
        return view('pages.superadmin.dashboard');
    }

    public function all_payments(Request $request)
    {
        // dd();
        return view('pages.superadmin.all_payments');
    }
      public function all_foloosi_payments(Request $request)
    {
        // dd();
        return view('pages.superadmin.all_foloosi_payments');
    }
    public function all_refunds(Request $request)
    {
        // dd();
        return view('pages.superadmin.all_refunds');
    }
       public function create_link(Request $request)
    {
        
        // dd();
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        if($user_id==34)
        {
            return redirect()->route('coffee.dashboard');
        }
        
        $query = AgentLinkLimit::query();
        $query->where('agentID', $user_id);
        $payment = $query->get()->first();
        // dd();
        if($payment !=null)
        {
            $limit_amount=$payment->limit_amount;
        }
        else{
            $limit_amount=0;
        }

        return view('pages.superadmin.create_link',compact('limit_amount'));
    }
    
    public function new_foloosi_link(){

        return view('pages.superadmin.create_foloosi_link');
    }

    public function store_link(Request $request)
    {
        $payment_type = $request->input('payment_type');
        $amount = $request->input('amount');
        $temp_inv = $request->input('temp_inv');
        $currency = $request->input('currency');
        $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();

        $clientName = "Hi Client,"; // Replace with actual client name


        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $billAmount = $currency . ' ' . $amount;
        $url = url('/payment/' . $random_number);

        $message = "$clientName Here is your bill of  $billAmount from Fujtown. You can easily view & pay your bill online now $url.
        ";
        // dd($message);

         TapPaymentLink::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_type' => $payment_type,
            'url' => $message, // Assuming this was intended to store the message
            'random_no' => $random_number,
            'link_payment' => 'tap',
            'agentID'=>$user_id,
            'temp_inv_no'=>$temp_inv
        ]);

            //  $customerKYC = CustomerKYC::firstOrNew(['temp_inv_no' => $temp_inv]);
            // $customerKYC->invoice_no = $random_number;
            //  $customerKYC->save();

        // Redirect or return a response
        return response()->json([
            'url' => $message,
            'success' => 'Payment link created successfully.'
        ]);

    }
    
     public function store_foloosi_link(Request $request)
    {
        $payment_type = $request->input('payment_type');
        $amount = $request->input('amount');

        $currency = $request->input('currency');
        $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();

        $clientName = "Hi Client,"; // Replace with actual client name


        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $billAmount = $currency . ' ' . $amount;
        $url = url('/foloosi-payment/' . $random_number);

        $message = "$clientName Here is your bill of  $billAmount from Fujtown. You can easily view & pay your bill online now $url.
        ";
        // dd($message);

         TapPaymentLink::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_type' => $payment_type,
            'url' => $message, // Assuming this was intended to store the message
            'random_no' => $random_number,
            'link_payment' => 'foloosi',
            'agentID'=>$user_id
        ]);


        // Redirect or return a response
        return response()->json([
            'url' => $message,
            'success' => 'Payment link created successfully.'
        ]);

    }

    public function all_links(Request $request)
    {
        // dd();
        return view('pages.superadmin.all_links');
    }

    public function create_agent(Request $request)
    {
        return view('pages.superadmin.create_agent');
    }
    public function all_agents(Request $request)
    {
        return view('pages.superadmin.all_agents');
    }

    public function store_agent(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $user = Auth::guard('admin')->user();
        $limit_amount = $request->input('limit_amount');
        $user_id = $user->id;
        $agent=Agent::create([
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password),
            'is_admin' => '3',
            'createdBy' => $user_id,
            'user_type' =>'agent'
        ]);

        $lastInsertedId = $agent->id;
        if($lastInsertedId)
        {
            AgentLinkLimit::create([
                'agentID'=>$lastInsertedId,
                'limit_amount'=>$limit_amount,
            ]);
        }

        // Redirect or return a response
        return response()->json([
            'success' => 'Agent created successfully.'
        ]);
    }

    public function get_all_agents(Request $request)
    {
        $query = Agent::query();
        // Get the payments
        $query->where('user_type', 'agent');
        $agents = $query->get();
        if ($agents->isEmpty()) {
            return response()->json(['message' => 'No Agent Found.'], 404);
        }

        return response()->json($agents);
    }


    public function delete_link(Request $request)
    {
        // dd();
        $item = TapPaymentLink::findOrFail($request->id); // Find the item by ID or fail
        $item->delete(); // Delete the item

        return back()->with('success', 'Item deleted successfully.');
    }

    public function get_all_payments(Request $request)
    {
        $query = TapPayment::query();


        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        $status = $request->query('status');

        if ($minDateStr && $maxDateStr && $status=='') {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

                        // Convert to milliseconds
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // $timestampInteger1 = intval(floatval($minDateInMilliseconds));
            // $timestampInteger2 = intval(floatval($maxDateInMilliseconds));
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
        }
        elseif ($minDateStr && $maxDateStr && $status) {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds])
            ->where('status', $status);
        }

        elseif ($status) {
            $query->where('status', $status);
        }

        // Get the payments
        $payments = $query->orderBy('date', 'asc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No matching documents.'], 404);
        }

        return response()->json($payments);
    }
    
              public function get_all_foloosi_payments(Request $request)
    {
        // dd('work');
        // $query = Foloosi::query();
         $query = Foloosi::with('agent');

        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        
      
        $status = $request->query('status');

        if ($minDateStr && $maxDateStr && $status=='') {
              // Start of the day
        $minDate = $minDateStr . 'T00:00:00+00:00';
        
        // End of the day
        $maxDate = $maxDateStr . 'T23:59:59+00:00';
            $query->whereBetween('created_at_foloosi', [$minDate, $maxDate]);
        }
        elseif ($minDateStr && $maxDateStr && $status) {
                 // Start of the day
        $minDate = $minDateStr . 'T00:00:00+00:00';
        
        // End of the day
        $maxDate = $maxDateStr . 'T23:59:59+00:00';
        
            $query->whereBetween('created_at_foloosi', [$minDate, $maxDate])
            ->where('status', $status);
        }

        elseif ($status) {
            $query->where('status', $status);
        }

        // Get the payments
        $payments = $query->orderBy('created_at_foloosi', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No matching documents.'], 404);
        }

        return response()->json($payments);
    }


    // public function get_all_refunds(Request $request)
    // {
    //     $query = Refunds::query();


    //     $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
    //     $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
    //     $status = $request->query('status');

    //     if ($minDateStr && $maxDateStr && $status=='') {
    //         $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
    //         $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

    //                     // Convert to milliseconds
    //         $minDateInMilliseconds = $minDate->timestamp * 1000;
    //         $maxDateInMilliseconds = $maxDate->timestamp * 1000;
    //         // $timestampInteger1 = intval(floatval($minDateInMilliseconds));
    //         // $timestampInteger2 = intval(floatval($maxDateInMilliseconds));
    //         // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
    //         $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
    //     }
    //     elseif ($minDateStr && $maxDateStr && $status) {
    //         $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
    //         $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();
    //         $minDateInMilliseconds = $minDate->timestamp * 1000;
    //         $maxDateInMilliseconds = $maxDate->timestamp * 1000;
    //         // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
    //         // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
    //         $query->whereBetween('Refund_date', [$minDateInMilliseconds, $maxDateInMilliseconds])
    //         ->where('status', $status);
    //     }

    //     elseif ($status) {
    //         $query->where('status', $status);
    //     }

    //     // Get the payments
    //     $payments = $query->get();
    //     if ($payments->isEmpty()) {
    //         return response()->json(['message' => 'No matching documents.'], 404);
    //     }

    //     return response()->json($payments);
    // }


    public function fetch_and_save_data(Request $request) {
        
        $lastChId = TapPayment::latest('id') // Assuming 'id' is your primary key
                ->whereNotNull('ch_id')
                ->value('ch_id');

if ($lastChId) {
    // ch_id found
    $startingAfter= $lastChId;
} else {
    // No ch_id found, handle accordingly
    $startingAfter= null;
}

// dd($startingAfter);

        //php artisan fetch:save-data   this commond will save all the data into the table
        
  $client = new Client();
    $body = [
        "limit" => "50",
        // Include other necessary parameters for your request
    ];

    if ($startingAfter) {
        $body['starting_after'] = $startingAfter;
    }

    $response = $client->request('POST', 'https://api.tap.company/v2/charges/list', [
        'body' => json_encode($body),
        'headers' => [
            'Authorization' => 'Bearer '.env('TAP_PAYMENT_SECRET'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
    ]);

    $charges = json_decode($response->getBody()->getContents(), true);
      if (empty($charges['data'])) {
        // If no data is returned from the API
        return response()->json(['message' => 'All Transactions Fetched'], 200);
    }
    
    $lastChargeId = null;

    foreach ($charges['data'] as $charge) {
        TapPayment::create([
            'amount' => $charge['amount'],
            'brand' => $charge['card']['brand'] ?? 'defaultBrand',
            'ch_id' => $charge['id'],
            'code' => $charge['response']['code'],
            'country_code' => $charge['customer']['phone']['country_code'],
            'currency' => $charge['currency'],
            'customer_id' => $charge['customer']['id'] ?? '---',
            'date' => $charge['transaction']['created'],
            'email' => $charge['customer']['email'] ?? null,
            'first_name' => $charge['customer']['first_name'] ?? null,
            'invoice_id' => $charge['metadata']['invoice_id'] ?? null,
            'last_name' => $charge['customer']['last_name'] ?? null,
            'message' => $charge['response']['message'],
            'number' => $charge['customer']['phone']['number'] ?? null,
            'payment' => $charge['reference']['payment'] ?? '0',
            'receipt' => $charge['receipt']['id'] ?? null,
            'status' => $charge['status'],
            'track' => $charge['reference']['track'] ?? 'defaultTrack',
            'short_code' => $charge['metadata']['shortcode'] ?? null,
            'created_at' => now(), // Laravel's now() function to set the current timestamp
        ]);

        $lastChargeId = $charge['id']; // This will end up being the last ID in the loop
    }

    
     // If transactions were processed, return a success message with the last charge ID
    return response()->json([
        'message' => 'Transactions fetched and saved successfully.',
        'lastChargeId' => $lastChargeId
    ], 200);
    
    
    }

  public function fetch_and_save_foloosi_data(Request $request) {

        
$response = Http::withHeaders([
     'secret_key' => 'live_$2y$10$1RNuPReOjy93zUDTAwRXeud7OZ4K2fP1TcoRQ2OkpA0qx-N0vyEOu',
])->get('https://api.foloosi.com/v1/api/transaction-list');

// dd($response);
// Check if the request was successful
if ($response->successful()) {
    $data = $response->json();
    $transactions = $data['data']['transactions'];
    
        DB::beginTransaction();

        try {
            foreach ($transactions as $transaction) {
                AllFoloosiPayments::firstOrCreate(
                    ['transaction_no' => $transaction['transaction_no']],
                    [
                        // Attributes to create a new record if not found
                        'sender_id' => $transaction['sender_id'],
                        'receiver_id' => $transaction['receiver_id'],
                        'payment_link_id' => $transaction['payment_link_id'],
                        'send_amount' => $transaction['send_amount'],
                        'sender_currency' => $transaction['sender_currency'],
                        'tip_amount' => $transaction['tip_amount'],
                        'receive_currency' => $transaction['receive_currency'],
                        'special_offer_applied' => $transaction['special_offer_applied'],
                        'sender_amount' => $transaction['sender_amount'],
                        'receive_amount' => $transaction['receive_amount'],
                        'offer_amount' => $transaction['offer_amount'],
                        'vat_amount' => $transaction['vat_amount'],
                        'transaction_type' => $transaction['transaction_type'],
                        'poppay_fee' => $transaction['poppay_fee'],
                        'transaction_fixed_fee' => $transaction['transaction_fixed_fee'],
                        'customer_foloosi_fee' => $transaction['customer_foloosi_fee'],
                        'status' => $transaction['status'],
                        'created' => $transaction['created'],
                        'sender_name' => $transaction['sender']['name'],
                        'sender_email' => $transaction['sender']['email'],
                        'sender_business_name' => $transaction['sender']['business_name'],
                        'sender_phone_number' => $transaction['sender']['phone_number'],
                    ]
                );
            }

            DB::commit();
            
            // Everything is fine, send a 200 response
            return response()->json(['message' => 'Data fetched and saved successfully'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            // If there's an error, return a 500 server error response
            return response()->json(['message' => 'Failed to save data', 'error' => $e->getMessage()], 500);
        }
        
} else {
    // Handle error
    $error = $response->body();
    // Log or return error message
}
    }

    public function getLastInsertedDocument()
    {
        // Assuming you have a model 'Document' and it has a 'created_at' timestamp
        $lastDocument = TapPayment::orderBy('id', 'desc')->first();

        return $lastDocument ? $lastDocument->ch_id : null;
    }

    public function set_chargeID($ch_id)
    {
        return $ch_id;
    }



    public function getChartData() {
        
            $date=date('Y-m-d');
            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            
            // Sum the amount for records within the specified date range
           $transactionCount = PaymentLedger::whereBetween('date', [$startDate, $endDate])->count();
            
            // dd($transactionCount);
        // Example of querying the data. Adjust according to your actual table structure.
        $capturedCount = TapPayment::where('status', 'Captured')->count();
        $declinedCount = TapPayment::where('status', '<>', 'Captured')->count();
        $RefundCount = TapRefunds::where('status', '=', 'REFUNDED')->count();
        // dd($RefundCount);
        // return response()->json([
        //     ['label' => 'Captured', 'value' => $capturedCount],
        //     ['label' => 'Declined', 'value' => $declinedCount],
        //     ['label' => 'Total Transaction', 'value' => $transactionCount],
        //     ['label' => 'Refunds', 'value' => $RefundCount],
        // ]);
        
        return response()->json([
            'status_counts' => [
                ['label' => 'Captured', 'value' => $capturedCount],
                ['label' => 'Declined', 'value' => $declinedCount],
                ['label' => 'Refunds', 'value' => $RefundCount],
            ],
            'summary_counts' => [
                ['label' => 'Total Transaction', 'value' => $transactionCount],
                ['label' => 'Refunds', 'value' => $RefundCount],
            ],
        ]);
    }


    public function getRevenueData()
    {
        // Get data for the current month from day 1 to today
        // $startOfMonth = Carbon::now()->startOfMonth();
        // $endOfToday = Carbon::now()->endOfDay();

        // $minDateInMilliseconds = $startOfMonth->timestamp * 1000;
        // $maxDateInMilliseconds = $endOfToday->timestamp * 1000;

         // Define the date range for the current month
         $startOfMonth = Carbon::now()->startOfMonth()->valueOf();
         $endOfToday = Carbon::now()->valueOf();
        // dd($endOfToday);
         // Retrieve and group the data by day
         $dailyAmounts = DB::table('all_tap_payment')
         ->select(
             DB::raw('FROM_UNIXTIME(date/1000, "%Y-%m-%d") as y'),
             'currency', // Include the currency column
             DB::raw('SUM(CASE WHEN status = "CAPTURED" THEN amount ELSE 0 END) as a'),
             DB::raw('SUM(CASE WHEN status != "CAPTURED" THEN amount ELSE 0 END) as b')
         )
         ->whereBetween('date', [$startOfMonth, $endOfToday])
         ->groupBy('y', 'currency') // Group by both date and currency
         ->orderBy('y')
         ->get();
         // Format the data for the chart
         $chartData = $dailyAmounts->map(function ($item) {
             return [
                 'y' => $item->y,
                 'currency' => $item->currency,
                 'a' => (float) $item->a,
                 'b' => (float) $item->b,
             ];
         });

         // Return data as JSON
         return response()->json($chartData);
    }
    
    
      public function todayTransaction(Request $request)
    {
         $transactions = []; // Initialize your transactions data
         
         if ($request->has('start') && $request->start != '') {
        $date = $request->start;
      
    } else {
         $date=date('Y-m-d');
    }
    
            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            
            // First, get all transaction numbers from the all_tap_refunds table that match your criteria
$refundedTransactionNos = TapRefunds::whereBetween('created', [$startDate, $endDate])
                    ->pluck('charge_id')->toArray();
// dd($refundedTransactionNos);            
            
            
            // Sum the amount for records within the specified date range
          $tap_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
                ->where('source_table', 'all_tap_payment')
                ->get();
 // Filter out transactions that have been refunded
$filteredTapTransactions = $tap_transactions->reject(function ($transaction) use ($refundedTransactionNos) {
    return in_array($transaction->transaction_no, $refundedTransactionNos);
});          
                
                
                // dd($tap_transactions);
                $currencyTotals = []; // Initialize an empty array for storing totals by currency
                
                     // Iterate through each transaction to check for a corresponding record in payment_by_link
            foreach ($filteredTapTransactions  as $transaction) {
                 // Check if the currency already exists in the array
          if (array_key_exists($transaction->currency, $currencyTotals)) {
            // Add to the existing amount
            $currencyTotals[$transaction->currency] += $transaction->amount;
        } else {
            // Initialize this currency in the array
            $currencyTotals[$transaction->currency] = $transaction->amount;
        }
        
                // Attempt to find a corresponding record in payment_by_link and join with the admin table to get the username
        $linkedPayment = PaymentByLink::where('payment_by_link.ch_id', $transaction->transaction_no)
                                      ->join('admin', 'payment_by_link.agentID', '=', 'admin.id')
                                      ->first(['payment_by_link.*', 'admin.username as agentUsername']);

        
                // If a corresponding record is found, merge the necessary details
            if ($linkedPayment) {
                $transaction->agentID = $linkedPayment->agentID; // Assuming you still want to merge this
                $transaction->agentUsername = $linkedPayment->agentUsername;
            } else {
                // If no corresponding record is found, you might want to set default values
                $transaction->agentID = null; // or some default value
                $transaction->agentUsername = null; // or some default value
            }
            }      
            
            
                    $totalsByCurrency = [];
        
        foreach ($currencyTotals as $currency => $totalAmount) {
            $totalsByCurrency[] = [
                'currency_total' => $currency,
                'amount_total' => $totalAmount,
            ];
        }
        // dd($totalsByCurrency);
                
            $noon_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
                ->where('source_table', 'noon_transactions')
                ->get();
                
             $currencyTotals2 = []; // Initialize an empty array for storing totals by currency
                
                     // Iterate through each transaction to check for a corresponding record in payment_by_link
            foreach ($noon_transactions as $ftransaction) {
                 // Check if the currency already exists in the array
          if (array_key_exists($ftransaction->currency, $currencyTotals2)) {
            // Add to the existing amount
            $currencyTotals2[$ftransaction->currency] += $ftransaction->amount;
        } else {
            // Initialize this currency in the array
            $currencyTotals2[$ftransaction->currency] = $ftransaction->amount;
        }
        
                // Attempt to find a corresponding record in payment_by_link and join with the admin table to get the username
        $linkedPayment2 = NoonTransaction::where('noon_transactions.tr_id', $ftransaction->transaction_no)
                                      ->join('admin', 'noon_transactions.agentID', '=', 'admin.id')
                                      ->first(['noon_transactions.*', 'admin.username as agentUsername']);

        
                // If a corresponding record is found, merge the necessary details
            if ($linkedPayment2) {
                $ftransaction->agentID = $linkedPayment2->agentID; // Assuming you still want to merge this
                $ftransaction->agentUsername = $linkedPayment2->agentUsername;
            } else {
                // If no corresponding record is found, you might want to set default values
                $ftransaction->agentID = null; // or some default value
                $ftransaction->agentUsername = null; // or some default value
            }
            } 
            
                $totalsByCurrency2 = [];
        
        foreach ($currencyTotals2 as $fcurrency => $totalAmount2) {
            $totalsByCurrency2[] = [
                'currency_total' => $fcurrency,
                'amount_total' => $totalAmount2,
            ];
        }
        
        // Merge both arrays
        $mergedTotals = array_merge($totalsByCurrency, $totalsByCurrency2);
        
        // Prepare an array to hold the final summed totals
        $summedTotalsByCurrency = [];
        
        foreach ($mergedTotals as $item) {
            $currency = $item['currency_total'];
            $amount = $item['amount_total'];
        
            // Check if the currency already exists in the array
            if (isset($summedTotalsByCurrency[$currency])) {
                // Add to the existing amount
                $summedTotalsByCurrency[$currency]['amount_total'] += $amount;
            } else {
                // Initialize this currency in the array
                $summedTotalsByCurrency[$currency] = [
                    'currency_total' => $currency,
                    'amount_total' => $amount,
                ];
            }
        }
        
        $finalTotalsByCurrency = array_values($summedTotalsByCurrency);
        
        // dd($finalTotalsByCurrency);
           
         return view('pages.superadmin.today_transaction',compact(['filteredTapTransactions','noon_transactions','totalsByCurrency','totalsByCurrency2','finalTotalsByCurrency']));
    }
    
    
        public function exportTapTransactionsPdf($date = null)
{
        $date = $date ?? Carbon::now()->format('Y-m-d');
        // $date = Carbon::yesterday()->format('Y-m-d');
        //  dd($date);

            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            
            
                        // First, get all transaction numbers from the all_tap_refunds table that match your criteria
$refundedTransactionNos = TapRefunds::whereBetween('created', [$startDate, $endDate])
                    ->pluck('charge_id')->toArray();
// dd($refundedTransactionNos);            
            
            
            // Sum the amount for records within the specified date range
          $tap_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
                ->where('source_table', 'all_tap_payment')
                ->get();
 // Filter out transactions that have been refunded
$filteredTapTransactions = $tap_transactions->reject(function ($transaction) use ($refundedTransactionNos) {
    return in_array($transaction->transaction_no, $refundedTransactionNos);
});          

                // dd($tap_transactions);
                $currencyTotals = []; // Initialize an empty array for storing totals by currency
                
                     // Iterate through each transaction to check for a corresponding record in payment_by_link
            foreach ($filteredTapTransactions as $transaction) {
                 // Check if the currency already exists in the array
          if (array_key_exists($transaction->currency, $currencyTotals)) {
            // Add to the existing amount
            $currencyTotals[$transaction->currency] += $transaction->amount;
        } else {
            // Initialize this currency in the array
            $currencyTotals[$transaction->currency] = $transaction->amount;
        }
        
                // Attempt to find a corresponding record in payment_by_link and join with the admin table to get the username
        $linkedPayment = PaymentByLink::where('payment_by_link.ch_id', $transaction->transaction_no)
                                      ->join('admin', 'payment_by_link.agentID', '=', 'admin.id')
                                      ->first(['payment_by_link.*', 'admin.username as agentUsername']);

        
                // If a corresponding record is found, merge the necessary details
            if ($linkedPayment) {
                $transaction->agentID = $linkedPayment->agentID; // Assuming you still want to merge this
                $transaction->agentUsername = $linkedPayment->agentUsername;
            } else {
                // If no corresponding record is found, you might want to set default values
                $transaction->agentID = null; // or some default value
                $transaction->agentUsername = null; // or some default value
            }
            }      
            
            
                    $totalsByCurrency = [];
        
        foreach ($currencyTotals as $currency => $totalAmount) {
            $totalsByCurrency[] = [
                'currency_total' => $currency,
                'amount_total' => $totalAmount,
            ];
        }
                
    //   dd($tap_transactions);
    $pdf = PDF::loadView('transaction_template', compact(['filteredTapTransactions', 'totalsByCurrency']));
    // Render the HTML as PDF
    // $pdf->render();
    // dd($pdf);
    return $pdf->stream();
}

      public function exportFoloosiTransactionsPdf($date = null)
{
         $date = $date ?? Carbon::now()->format('Y-m-d');
        // $date = Carbon::yesterday()->format('Y-m-d');
        //  dd($date);

            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            
            
            
            // Sum the amount for records within the specified date range
          $foloosi_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
                ->where('source_table', 'noon_transactions')
                ->get();
                // dd($tap_transactions);
                $currencyTotals = []; // Initialize an empty array for storing totals by currency
                
                     // Iterate through each transaction to check for a corresponding record in payment_by_link
            foreach ($foloosi_transactions as $transaction) {
                 // Check if the currency already exists in the array
          if (array_key_exists($transaction->currency, $currencyTotals)) {
            // Add to the existing amount
            $currencyTotals[$transaction->currency] += $transaction->amount;
        } else {
            // Initialize this currency in the array
            $currencyTotals[$transaction->currency] = $transaction->amount;
        }
        
                // Attempt to find a corresponding record in payment_by_link and join with the admin table to get the username
        $linkedPayment = NoonTransaction::where('noon_transactions.tr_id', $transaction->transaction_no)
                                      ->join('admin', 'noon_transactions.agentID', '=', 'admin.id')
                                      ->first(['noon_transactions.*', 'admin.username as agentUsername']);
        
                // If a corresponding record is found, merge the necessary details
            if ($linkedPayment) {
                $transaction->agentID = $linkedPayment->agentID; // Assuming you still want to merge this
                $transaction->agentUsername = $linkedPayment->agentUsername;
            } else {
                // If no corresponding record is found, you might want to set default values
                $transaction->agentID = null; // or some default value
                $transaction->agentUsername = null; // or some default value
            }
            }      
            
            
                    $totalsByCurrency = [];
        
        foreach ($currencyTotals as $currency => $totalAmount) {
            $totalsByCurrency[] = [
                'currency_total' => $currency,
                'amount_total' => $totalAmount,
            ];
        }
                
    //   dd($tap_transactions);
    $pdf = PDF::loadView('foloosi_transaction_template', compact(['foloosi_transactions', 'totalsByCurrency']));
    // Render the HTML as PDF
    // $pdf->render();
    // dd($pdf);
    return $pdf->stream();
}

     public function exportExcelTap($date = null)
        {
            // Check if date is not null, otherwise set to current date
    $date = $date ?? Carbon::now()->format('Y-m-d');

    // Create the export object, passing in the date
    $export = new TransactionsExport($date);

    // Generate the filename with the current date and time
    $fileName = 'tap_transaction_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

    // Return the Excel download
    return Excel::download($export, $fileName);
    
        }
        
     public function exportFoloosiExcelTap($date = null)
    {
        // Check if date is not null, otherwise set to current date
    $date = $date ?? Carbon::now()->format('Y-m-d');

    // Create the export object, passing in the date
    $export = new FoloosiTransactionsExport($date);

    // Generate the filename with the current date and time
    $fileName = 'noon_transaction_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

    // Return the Excel download
    return Excel::download($export, $fileName);
        // dd('work');
        //  return Excel::download(new FoloosiTransactionsExport, 'foloosi_transaction_' . date('Y-m-d_H-i-s') . '.xlsx');
        // return Excel::download(new FoloosiTransactionsExport, 'foloosi_transactions.xlsx');
    }


        public function get_all_links(Request $request)
        {
            $query = TapPaymentLink::with('agent');


            $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
            $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
            $status = $request->query('status');

            if ($minDateStr && $maxDateStr && $status=='') {

                $query->whereBetween('created_at', [$minDateStr, $maxDateStr]);
            }
            elseif ($minDateStr && $maxDateStr && $status) {

                // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
                // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
                $query->whereBetween('created_at', [$minDateStr, $maxDateStr])
                ->where('created_at', $status);
            }

            elseif ($status) {
                $query->where('payment_type', $status);
            }

            // Get the payments
            $payments = $query->get();
            if ($payments->isEmpty()) {
                return response()->json(['message' => 'No Links Found.'], 404);
            }

            return response()->json($payments);
        }

        public function get_link_detail(Request $request)
        {
            $query = TapPaymentLink::query();
            $query->where('id', $request->id);
            $payment = $query->get();
            if ($payment->isEmpty()) {
                return response()->json(['message' => 'No Links Found.'], 404);
            }

            return response()->json(['data' => $payment]);
        }

        public function create_kyc()
        {
            return view('pages.superadmin.upload_kyc');
        }

        public function store_kyc(Request $request)
        {

                if ($request->hasFile('files')) {
                    $files = $request->file('files');
                    $customer = $request->input('username');
                    $zip = new ZipArchive();
                    // $zipFileName = $customer .  date('Y-m-d') . '.zip';
                    $date = date('Y-m-d');
                    $zipFileName = "{$customer}_{$date}.zip";

                    $user = Auth::guard('admin')->user();
                    $user_id = $user->id;

                     // Use public_path() to specify the path in the public directory
                    $zipPath = public_path('kyc/' . $zipFileName);

                    // Ensure the directory exists
                    $zipDir = dirname($zipPath);
                    if (!is_dir($zipDir)) {
                        mkdir($zipDir, 0755, true);
                    }

                    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                        foreach ($files as $file) {
                            // Add files to ZIP
                            $zip->addFromString($file->getClientOriginalName(), file_get_contents($file));
                        }
                        $zip->close();

                         // Save the customer name and ZIP file name to the database
                            CustomerKYC::create([
                                'customer_name' => $customer,
                                'zip_file_name' => $zipFileName,
                                'agentID'=> $user_id
                            ]);


                        // Provide a download link or return a response
                        $downloadLink = asset('zipfiles/' . $zipFileName);
                        return response()->json(['success' => true, 'message' => 'ZIP file created successfully.', 'downloadLink' => $downloadLink]);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Failed to create ZIP file.'], 500);
                    }

                }

                return response()->json(['success' => false, 'message' => 'No files provided.'], 400);

        }

        public function all_kyc(Request $request)
        {
            return view('pages.superadmin.all_kyc');
        }

        public function get_all_kyc(Request $request)
        {
            $query = CustomerKYC::with('agent');
         $query->where('status', 1);
        $kyc = $query->orderBy('created_at', 'desc')->get();

            // $kyc = $query->get();
            if ($kyc->isEmpty()) {
                return response()->json(['message' => 'No KYC Documents Found.'], 404);
            }

            return response()->json($kyc);
        }

        public function delete_kyc(Request $request)
        {



            // Retrieve the ZIP file name for the specified customer
            $customerKyc = CustomerKyc::where('id', $request->id)->first();
            $zipFileName = $customerKyc->zip_file_name; // Assuming 'zip_file_name' is the column name

            $filePath = public_path('kyc/'.$zipFileName); // Construct the full path to the file
            if (!empty($zipFileName)) {
                unlink($filePath); // Delete the file
            }

            $item = CustomerKYC::findOrFail($request->id); // Find the item by ID or fail
            $item->delete(); // Delete the item

            return back()->with('success', 'KYC deleted successfully.');
        }

        public function requested_refunds(Request $request)
        {
            return view('pages.superadmin.requested_refunds');
        }
        public function get_all_refund_requests(Request $request)
        {
            // DB::listen(function($query) {
            //     Log::info(
            //         $query->sql,
            //         $query->bindings,
            //         $query->time
            //     );
            // });

            // Now, execute your query as normal to trigger the listener
            $refundRequest = RefundRequest::with('agent')
                        ->orderBy('created_at', 'desc')
                        ->orderBy('status', 'asc')
                        ->get();

            // print_r($refundRequest);exit;
            if ($refundRequest->isEmpty()) {
                return response()->json(['message' => 'No Refund Requests Found.'], 404);
            }
            // dd($refundRequest);

            return response()->json($refundRequest);
        }

        public function confirm_refund(Request $request)
        {
            $id = $request->input('id');
            $refund = RefundRequest::findOrFail($id);
            $refund->status = 1;
            $refund->save();
            // Redirect or return a response
            return back()->with('success', 'Refund Request Accepted successfully.');
        }
        
         public function payment_ledger()
        {
             return view('pages.superadmin.payment_ledger');
        }
        
               
        public function get_all_paymentsLedger(Request $request)
        {
            
        $query = PaymentLedger::query();


        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        $status = $request->query('status');

        if ($minDateStr && $maxDateStr && $status=='') {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

                        // Convert to milliseconds
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // $timestampInteger1 = intval(floatval($minDateInMilliseconds));
            // $timestampInteger2 = intval(floatval($maxDateInMilliseconds));
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
        }
        elseif ($minDateStr && $maxDateStr && $status) {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds])
            ->where('source_table', $status);
        }

        elseif ($status) {
            $query->where('source_table', $status);
        }

        // Get the payments
        $payments = $query->orderBy('id', 'desc')->orderBy('source_table', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No matching documents.'], 404);
        }

        return response()->json($payments);
        }
        
        
        public function foloosi_payment_ledger(Request $request)
        {
             return view('pages.superadmin.foloosi_payment_ledger');
        }
        
        
        
            
         public function get_foloosi_paymentsLedger(Request $request)
    {
        // dd('work');
        $query = Foloosi::query();


        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        
      
        $status = $request->query('status');

        if ($minDateStr && $maxDateStr && $status=='') {
              // Start of the day
        $minDate = $minDateStr . 'T00:00:00+00:00';
        
        // End of the day
        $maxDate = $maxDateStr . 'T23:59:59+00:00';
            $query->whereBetween('created_at_foloosi', [$minDate, $maxDate]);
        }
        elseif ($minDateStr && $maxDateStr && $status) {
                 // Start of the day
        $minDate = $minDateStr . 'T00:00:00+00:00';
        
        // End of the day
        $maxDate = $maxDateStr . 'T23:59:59+00:00';
        
            $query->whereBetween('created_at_foloosi', [$minDate, $maxDate])
            ->where('status', $status);
        }

        elseif ($status) {
            $query->where('status', $status);
        }

        // Get the payments
        $payments = $query->orderBy('created_at_foloosi', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No matching documents.'], 404);
        }

        return response()->json($payments);
    }
        
        
        public function agent_tap_paymentledger(Request $request)
        {
             return view('pages.superadmin.agent_tap_paymentledger');
        }
        
        public function get_all_tap_paymentsAgentLedger(Request $request)
        {
            $query = PaymentByLink::with('agent');


        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        $status = $request->query('status');

        if ($minDateStr && $maxDateStr && $status=='') {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

                        // Convert to milliseconds
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // $timestampInteger1 = intval(floatval($minDateInMilliseconds));
            // $timestampInteger2 = intval(floatval($maxDateInMilliseconds));
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
        }
        elseif ($minDateStr && $maxDateStr && $status) {
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();
            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
            // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
            $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds])
            ->where('status', $status);
        }

        elseif ($status) {
            $query->where('status', $status);
        }

        // Get the payments
        $payments = $query->orderBy('id', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No matching documents.'], 404);
        }

        return response()->json($payments);
        }

        
           public function all_tap_refunds(Request $request)
        {
            return view('pages.superadmin.all_tap_refunds');
        }
        public function fetch_all_refunds(Request $request)
        {
            $query = TapRefunds::query();


            $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
            $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'

            if ($minDateStr && $maxDateStr) {
                $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
                $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

                            // Convert to milliseconds
                $minDateInMilliseconds = $minDate->timestamp * 1000;
                $maxDateInMilliseconds = $maxDate->timestamp * 1000;
                // $timestampInteger1 = intval(floatval($minDateInMilliseconds));
                // $timestampInteger2 = intval(floatval($maxDateInMilliseconds));
                // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
                $query->whereBetween('date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
            }

            // Get the payments
            $payments = $query->orderBy('date', 'desc')->get();
            if ($payments->isEmpty()) {
                return response()->json(['message' => 'No matching documents.'], 404);
            }

            return response()->json($payments);
        }
        public function get_all_tap_refunds(Request $request)
        {
        $client = new Client();
         $allRefunds = []; // Array to hold all refunds across pagination
    $startingAfter = null; // Initialize starting point for pagination
    
     do {
        // Prepare the body of the request
        $body = [
            "limit" => "50",
        ];
        
        if ($startingAfter) {
            $body['starting_after'] = $startingAfter;
        }

        // Make the request
        $response = $client->request('POST', 'https://api.tap.company/v2/refunds/list', [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => 'Bearer '.env('TAP_PAYMENT_SECRET'),
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        // Decode the response
        $refunds = json_decode($response->getBody()->getContents(), true);
        
        // Check if we have refunds to process
        if (!empty($refunds['refunds'])) {
            foreach ($refunds['refunds'] as $refund) {
                $existingRefund = TapRefunds::where('refund_id', $refund['id'])->first();
                
                if (!$existingRefund) {
                    TapRefunds::create([
                          'customer_name' => $refund['charge']['customer']['first_name'] ?? null,
                    'customer_email' => $refund['charge']['customer']['email'] ?? null,
                    'customer_phone' => $refund['charge']['customer']['phone']['country_code'] . $refund['charge']['customer']['phone']['number'] ?? null,
                    'refund_id' => $refund['id'] ?? null,
                    'ref_amount' => $refund['amount'] ?? null,
                    'ref_currency' => $refund['currency'] ?? null,
                    'req_amount' => $refund['charge']['amount'] ?? null,
                    'req_currency' => $refund['charge']['currency'] ?? null,
                    'transaction_amount' => $refund['charge']['transaction']['amount'] ?? null,
                    'transaction_currency' => $refund['charge']['transaction']['currency'] ?? null,
                    'charge_id' => $refund['charge']['id'] ?? '---',
                    'created' => $refund['created'],
                    'date' => $refund['date'] ?? null,
                    'shortcode' => $refund['charge']['metadata']['shortcode'] ?? null,
                    'invoice_id' => $refund['charge']['metadata']['invoice_id'] ?? null,
                    'order_id' => $refund['charge']['metadata']['order_id'] ?? null,
                    'status' => $refund['status'],
                    'reason' => $refund['reason'] ?? '---',
        
                    'created_at' => now(), // Laravel's now() function to set the current timestamp
                    ]);

                    $allRefunds[] = $refund; // Add the refund to the allRefunds array
                }
            }
            
            // Update the startingAfter to the last refund's ID in the batch
            $startingAfter = end($refunds['refunds'])['id'];
        }
    } while (count($refunds['refunds']) == 50); // Assume if we got less than 50, we're at the end

    return response()->json([
        'message' => 'Refund Transactions fetched and saved successfully.',
        'totalRefundsProcessed' => count($allRefunds)
    ], 200);
    
    
    
    
    //         $firstRefId = TapRefunds::oldest('id') // Fetches the earliest record by 'id'
    //             ->whereNotNull('refund_id')
    //             ->value('refund_id');
    //             // dd($firstRefId);
    //         if ($firstRefId) {
    //             // ref_id found
    //             $startingAfter= $firstRefId;
    //         } else {
    //             // No ref_id found, handle accordingly
    //             $startingAfter= null;
    //         }


  
    // $body = [
    //     "limit" => "50",
    //     // Include other necessary parameters for your request
    // ];

    // if ($startingAfter) {
    //     $body['starting_after'] = $startingAfter;
    // }

    // $response = $client->request('POST', 'https://api.tap.company/v2/refunds/list', [
    //     'body' => json_encode($body),
    //     'headers' => [
    //         'Authorization' => 'Bearer '.env('TAP_PAYMENT_SECRET'),
    //         'accept' => 'application/json',
    //         'content-type' => 'application/json',
    //     ],
    // ]);

    // $refunds = json_decode($response->getBody()->getContents(), true);
    // // dd($refunds['refunds']);

    //   if (empty($refunds['refunds'])) {
    //     // If no data is returned from the API
    //     return response()->json(['message' => 'All Refund Transactions Fetched'], 200);
    // }

    // $lastRefId = null;

    // foreach ($refunds['refunds'] as $refund) {
    //     // Check if a record with the given refund_id already exists
    // $existingRefund = TapRefunds::where('refund_id', $refund['id'])->first();
    
    //     // dd($refund['charge']['customer']['first_name']);
    //       // If it doesn't exist, create a new record
    // if (!$existingRefund) {
    //     TapRefunds::create([
    //         'customer_name' => $refund['charge']['customer']['first_name'] ?? null,
    //         'customer_email' => $refund['charge']['customer']['email'] ?? null,
    //         'customer_phone' => $refund['charge']['customer']['phone']['country_code'] . $refund['charge']['customer']['phone']['number'] ?? null,
    //         'refund_id' => $refund['id'] ?? null,
    //         'ref_amount' => $refund['amount'] ?? null,
    //         'ref_currency' => $refund['currency'] ?? null,
    //         'req_amount' => $refund['charge']['amount'] ?? null,
    //         'req_currency' => $refund['charge']['currency'] ?? null,
    //         'transaction_amount' => $refund['charge']['transaction']['amount'] ?? null,
    //         'transaction_currency' => $refund['charge']['transaction']['currency'] ?? null,
    //         'charge_id' => $refund['charge']['id'] ?? '---',
    //         'created' => $refund['created'],
    //         'date' => $refund['date'] ?? null,
    //         'shortcode' => $refund['charge']['metadata']['shortcode'] ?? null,
    //         'invoice_id' => $refund['charge']['metadata']['invoice_id'] ?? null,
    //         'order_id' => $refund['charge']['metadata']['order_id'] ?? null,
    //         'status' => $refund['status'],
    //         'reason' => $refund['reason'] ?? '---',

    //         'created_at' => now(), // Laravel's now() function to set the current timestamp
    //     ]);

    //     $lastRefId = $refund['id']; // This will end up being the last ID in the loop
    // }
    // }


    //  // If transactions were processed, return a success message with the last charge ID
    // return response()->json([
    //     'message' => 'Refunds Transactions fetched and saved successfully.',
    //     'lastRefundId' => $firstRefId
    // ], 200);

        }
        
        public function uploadKycDuringLink(Request $request)
    {
        
           if ($request->hasFile('kyc_files')) {
            $files = $request->file('kyc_files');
            $tempInv = $request->input('temp_inv');
            $zip = new ZipArchive();
            // $zipFileName = $customer .  date('Y-m-d') . '.zip';
            $dateTime = Carbon::now()->format('Y-m-d_H-i-s');
            $zipFileName = "kyc_{$dateTime}.zip";
            $user = Auth::guard('admin')->user();
            $user_id = $user->id;
             // Use public_path() to specify the path in the public directory
            $zipPath = public_path('kyc/' . $zipFileName);

            // Ensure the directory exists
            $zipDir = dirname($zipPath);
            if (!is_dir($zipDir)) {
                mkdir($zipDir, 0755, true);
            }

            if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                foreach ($files as $file) {
                    // Add files to ZIP
                    $zip->addFromString($file->getClientOriginalName(), file_get_contents($file));
                }
                $zip->close();

                 // Save the customer name and ZIP file name to the database
                    CustomerKYC::create([
                        'customer_name' => '',
                        'zip_file_name' => $zipFileName,
                        'invoice_no'=>'',
                        'agentID' => $user_id,
                        'temp_inv_no'=>$tempInv
                    ]);


                // Provide a download link or return a response
                $downloadLink = asset('zipfiles/' . $zipFileName);
                return response()->json(['success' => true, 'message' => 'KYC Document uploaded successfully.', 'downloadLink' => $downloadLink],200);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to create ZIP file.'], 500);
            }

        }

        return response()->json(['success' => false, 'message' => 'No files provided.'], 400);
        
    }
        public function agent_payment_report()
        {
            $query = Agent::query();
        // Get the payments
        $query->where('user_type', 'agent');
        $agents = $query->get();
        
        return view('pages.superadmin.agent_payment_report',compact('agents'));
        
        }
        
        public function get_payment_by_agent(Request $request)
        {
            // $results = DB::table('payment_by_link as p')
            // ->leftJoin('payment_ledger as pl', 'p.ch_id', '=', 'pl.transaction_no')
            // ->leftJoin('admin as ad', 'ad.id', '=', 'p.agentID')
            // ->select('p.*', 'pl.transaction_no', 'ad.username as agent')
            // ->whereNotNull('p.agentID') // Assuming you want to check for non-null values
            // ->where('p.agentID', '<>', '') // Checks that agentID is not an empty string
            // ->get();

            // dd($results);
             $transactions = []; 
             $minDateStr = $request->query('min_date');
             $maxDateStr = $request->query('max_date'); 
             $agent = $request->query('agent');
             
                         
             $query = DB::table('payment_by_link as p')
            ->leftJoin('payment_ledger as pl', 'p.ch_id', '=', 'pl.transaction_no')
            ->leftJoin('admin as ad', 'ad.id', '=', 'p.agentID')
            ->select('p.*', 'pl.transaction_no', 'ad.username as agent');
           
            if ($minDateStr && $maxDateStr && $agent=='') {
                // dd('query1');
            $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();

            $minDateInMilliseconds = $minDate->timestamp * 1000;
            $maxDateInMilliseconds = $maxDate->timestamp * 1000;
            $query->whereBetween('p.date', [$minDateInMilliseconds, $maxDateInMilliseconds]);
            }
            elseif ($minDateStr && $maxDateStr && $agent) {
                // dd('query2');
                $minDate = Carbon::createFromFormat('Y-m-d', $minDateStr)->startOfDay();
                $maxDate = Carbon::createFromFormat('Y-m-d', $maxDateStr)->endOfDay();
                $minDateInMilliseconds = $minDate->timestamp * 1000;
                $maxDateInMilliseconds = $maxDate->timestamp * 1000;
                
                $query->whereBetween('p.date', [$minDateInMilliseconds, $maxDateInMilliseconds])
                ->where('p.agentID', $status);
            }
    
            elseif ($agent) {
                // dd('query3');
                $query->where('p.agentID', $agent);
            }
            
            $transactions = $query->get();
            // dd($transactions);
            return response()->json($transactions);
        }
        
        
public function noonPayment($id)
{
     // $query->where('random_no', $id);
        $payment = NoonPaymentLink::where('random_no', $id)
        ->where('is_expire', '!=', 2)
        ->first();
        // dd($payment);

        if ($payment != null) {
            session(['url_no' => $id]);
            return view('pages.noon_payment',compact('payment'));
            // dd('this is not a valid payment');

        }
        else{
            return response()->view('errors.404', ['message' => 'The link has been expired.'], 404);
        }
}


public function noon_response(Request $request)
{
    $noon_id=$request->input('orderId');
    //dd($noon_id);
     return view('pages.noon_success',compact(['noon_id']));
        
}

 public function createNoonCharge(Request $request)
        {
            $requestData = $request->all();
    $signatureImageBase64 = $requestData['signature_image'];
    // Remove the signature image from the request data
    unset($requestData['signature_image']);
    
    $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
        $imageName = 'signature_' . time() . '.png';
        // Storage::disk('public')->put($imageName, $signatureImage);
        
        // Save the signature image to storage
        $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
        $imageName = 'signature_'.$requestData['customer']['first_name']. time() . '.png';
        $path = public_path('signature/' . $imageName);
        file_put_contents($path, $signatureImage);


        // Save other charge details along with the signature image
        $temp_data['customer_name'] = $requestData['customer']['first_name'] .' '.$requestData['customer']['last_name'];
         $temp_data['customer_email'] = $requestData['customer']['email'];
          $temp_data['customer_sign'] = $imageName;

        // Save to the database or perform other actions as needed
        // Example: saving to temp_hold_customersign table
        TempHoldCustomerSign::create($temp_data);

            // $secretKey = env('TAP_PAYMENT_SECRET');
            //   $secretKey = env('TAP_PAYMENT_SECRET');
              $secretKey = config('payments.tap_payment_secret');
            // dd($secretKey);
            try {
                $merchant_ref = rand(1, 100000);

    
    //   $url = 'https://api.noonpayments.com/payment/v1/order';
       $url = 'https://api-test.noonpayments.com/payment/v1/order';
      $app_key = base64_encode('fujtown.Fujtrade:123f3ac6adba441e899ad9ff866b5b6a');
            // $app_key = 'Key_Test ZnVqdG93bi5mdWp0cmFkZToxMjNmM2FjNmFkYmE0NDFlODk5YWQ5ZmY4NjZiNWI2YQ==';
            
            $numberString = $requestData['amount'];
            $cleanNumber = str_replace(',', '', $numberString); // Removes commas
        
            $payload = [
                "apiOperation" => "INITIATE",
                "order" => [
                    "reference" => $merchant_ref,
                    "amount" =>$cleanNumber ,
                    "currency" => $requestData['currency'],
                    "name" => $requestData['description'],
                    "channel" => "web",
                    "category" => "pay"
                ],
                
                "billing"=> [
                    
                "contact"=> [
                    
                    "firstName"=> $requestData['customer']['first_name'],
                    "lastName"=> $requestData['customer']['last_name'],
                    "mobilePhone"=> $requestData['customer']['phone']['country_code'].'-'.$requestData['customer']['phone']['number'],
                    "email"=> $requestData['customer']['email']
                ]
            ],
            
                "configuration" =>
                        [
                            'tokenizeCc' => 'true',
                            'paymentAction' => 'SALE',
                            'returnUrl' => 'https://www.w-iclinics.com/laravelfujtrade/public/noon_response',
                            'locale' => 'en',
                        ]
            ];
        
            $response = Http::withHeaders([
                'Authorization' => 'Key_Test ZnVqdG93bi5mdWp0cmFkZTo4MDMzMGFhY2RiNmU0M2MyYmE1OTIzMzI0MzE1MDI2OA==',
                'Content-Type' => 'application/json'
            ])->post($url, $payload);
        
            $responseData = $response->json();
            if ($response->successful() && $responseData['resultCode'] == 0 && $responseData['result']['order']['status'] == 'INITIATED') {
               
                $paymentUrl = $responseData['result']['checkoutData']['postUrl'];
        
                //return redirect()->away($paymentUrl)
                return response()->json(['success' => true, 'url' => $paymentUrl]);
            } else {
                // Handle errors or unsuccessful payment initiation
                $errorMessage = $responseData['message'] ?? 'Unknown error';
                return response()->json([
                    'error' => 'Failed to initiate payment',
                    'message' => $errorMessage
                ], $response->status());
            }

            } catch (\Exception $e) {
                Log::error('Error creating charge: '.$e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }

        public function save_noon_payment_data(Request $request)
        {
            $orderId = $request->query('noon_id');
            $agentID = $request->query('agentID');

        if (!$orderId) {
            return response()->json(['error' => 'orderId is required'], 400);
        }
        
//    $orderId=$request->input('orderId');
      $url = 'https://api-test.noonpayments.com/payment/v1/order/'.$orderId;
    //   dd($url);
    $response = Http::withHeaders([
            'Authorization' => 'Key_Test ZnVqdG93bi5mdWp0cmFkZTo4MDMzMGFhY2RiNmU0M2MyYmE1OTIzMzI0MzE1MDI2OA==',
            'Content-Type' => 'application/json'
        ])->get($url);

        // Check if the request was successful
        if ($response->successful()) {
           $responseData= $response->json();
           $transactions=$responseData['result']['transactions'][0];
           $order=$responseData['result']['order'];
           $billing=$responseData['result']['billing']['contact'];
           $paymentDetails=$responseData['result']['paymentDetails'];
        //   dd($transactions);
             $amount = $order['totalCapturedAmount'];
             $currency = $order['currency'];
             $tr_id=$transactions['id'];
            //  dd($tr_id);
             $first_name=$billing['firstName'];
             $last_name =$billing['lastName'];
             $phone=$billing['mobilePhone'];
             $email =$billing['email'];
             $status=$order['status'];
             $date=$transactions['creationTime'];
             $message=$order['name'];
             $reference =$order['reference'];
             $mode=$paymentDetails['mode'];
             $intAccount =$paymentDetails['integratorAccount'];
             $paymentInfo =$paymentDetails['paymentInfo'];
             $brand =$paymentDetails['brand'];
             $expiryMonth =$paymentDetails['expiryMonth'];
             $expiryYear =$paymentDetails['expiryYear'];
             $cardCountry =$paymentDetails['cardCountry'] ?? 'Card Country';
             $cardCountryName =$paymentDetails['cardCountryName'] ?? 'Default Country';
             $cardIssuerName = $paymentDetails['cardIssuerName'] ?? 'Default Value';
             $agentID =$agentID;
            // Your logic to check if chr_id exists
            $chrIdExists = $this->doesNoonTransactionExist($tr_id);

            if (!$chrIdExists) {
                 $pdatas = [
                    'tr_id'=>$tr_id,
                    'amount' => $amount,
                    'currency'=>$currency,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'phone'=>$phone,
                    'email'=>$email,
                    'status'=>$status,
                    'date'=>$date,
                    'message'=>$message,
                    'reference'=>$reference,
                    'mode'=>$mode,
                    'intAccount'=>$intAccount,
                    'paymentInfo'=>$paymentInfo,
                    'brand'=>$brand,
                    'expiryMonth'=>$expiryMonth,
                    'expiryYear'=>$expiryYear,
                    'cardCountry'=>$cardCountry,
                    'cardCountryName'=>$cardCountryName,
                    'cardIssuerName'=>$cardIssuerName,
                    'agentID'=>$agentID,
                    'created_at' => now()
                ];
                

             NoonTransaction::create($pdatas);
              return response()->json(['success' => true, 'data' => $responseData]);  
            }
            else {
                return response()->json(['success' => false, 'error' => 'Record with Transaction_id already exists.']);
            }
          
            //  return response()->json(['message' => ''], 200);
            
            //$message='Payment Captured Succesfully..';
            
        } else {
            // Handle errors, could log them or return a custom message
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve the order from Noon Payments',
                'details' => $response->json()
            ], $response->status());
        }
        }
        
         protected function doesNoonTransactionExist($tr_id)
        {
            $exists = NoonTransaction::where('tr_id', $tr_id)->exists();
            return $exists;
        }
        
       public function get_noon_last_payment(Request $request)
        {
             $noon_id = $request->query('noon_id');

            if (!$noon_id) {
                return response()->json(['error' => 'noon_id is required'], 400);
            }

            try {
                // $secretKey = env('TAP_PAYMENT_SECRET');
                 $url = 'https://api-test.noonpayments.com/payment/v1/order/'.$noon_id;
    //   dd($url);
    $response = Http::withHeaders([
            'Authorization' => 'Key_Test ZnVqdG93bi5mdWp0cmFkZTo4MDMzMGFhY2RiNmU0M2MyYmE1OTIzMzI0MzE1MDI2OA==',
            'Content-Type' => 'application/json'
        ])->get($url);
        
        if ($response->successful()) {
           $responseData= $response->json();
            $order=$responseData['result']['order'];
             $status=$order['status'];
        }
         return response()->json(['success' => true, 'status' => $status]);

        }catch (\Exception $e) {
            Log::error("Error fetching payment data: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        }
        
            public function store_noon_link(Request $request)
    {
        $payment_type = $request->input('payment_type');
        $amount = $request->input('amount');

        $currency = $request->input('currency');
        $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();

        $clientName = "Hi Client,"; // Replace with actual client name


        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $billAmount = $currency . ' ' . $amount;
        $url = url('/noon-payment/' . $random_number);
          $temp_inv = $request->input('temp_inv');
        $message = "$clientName Here is your bill of  $billAmount from Fujtown. You can easily view & pay your bill online now $url.
        ";
        // dd($message);

         NoonPaymentLink::create([
            'amount' => $amount,
            'currency' => $currency,
            'payment_type' => $payment_type,
            'url' => $message, // Assuming this was intended to store the message
            'random_no' => $random_number,
            'link_payment' => 'tap',
            'agentID'=>$user_id,
            'temp_inv_no'=>$temp_inv
        ]);
        
        
            $customerKYC = CustomerKYC::firstOrNew(['temp_inv_no' => $temp_inv]);
            $customerKYC->invoice_no = $random_number;
             $customerKYC->save();


        // Redirect or return a response
        return response()->json([
            'url' => $message,
            'success' => 'Noon Payment link created successfully.'
        ]);

    }
    
     public function create_noon_link(Request $request)
    {
        // dd();
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $query = AgentLinkLimit::query();
        $query->where('agentID', $user_id);
        $payment = $query->get()->first();
        // dd();
        if($payment !=null)
        {
            $limit_amount=$payment->limit_amount;
        }
        else{
            $limit_amount=0;
        }

        return view('pages.superadmin.new_noon_link',compact('limit_amount'));
    }
    
    
         public function noon_links(Request $request)
    {
        // dd();
        return view('pages.superadmin.noon_links');
    }
    
        public function get_all_noon_links(Request $request)
        {
            $query = NoonPaymentLink::with('agent');


            $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
            $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
            $status = $request->query('status');

            if ($minDateStr && $maxDateStr && $status=='') {

                $query->whereBetween('created_at', [$minDateStr, $maxDateStr]);
            }
            elseif ($minDateStr && $maxDateStr && $status) {

                // Use $minDateInMilliseconds and $maxDateInMilliseconds in your query
                // $query->whereBetween('date', [$timestampInteger1, $timestampInteger2]);
                $query->whereBetween('created_at', [$minDateStr, $maxDateStr])
                ->where('created_at', $status);
            }

            elseif ($status) {
                $query->where('payment_type', $status);
            }

            // Get the payments
            $payments = $query->get();
            if ($payments->isEmpty()) {
                return response()->json(['message' => 'No Links Found.'], 404);
            }

            return response()->json($payments);
        }
        
        
        public function get_noon_link_detail(Request $request)
        {
            $query = NoonPaymentLink::query();
            $query->where('id', $request->id);
            $payment = $query->get();
            if ($payment->isEmpty()) {
                return response()->json(['message' => 'No Links Found.'], 404);
            }

            return response()->json(['data' => $payment]);
        }
        
        
    public function delete_noon_link(Request $request)
    {
        // dd();
        $item = NoonPaymentLink::findOrFail($request->id); // Find the item by ID or fail
        $item->delete(); // Delete the item

        return back()->with('success', 'Link deleted successfully.');
    }
        
        public function logout()
        {
            // Log the user out
            Auth::logout();

            // Optionally, if you want to invalidate the user's session and regenerate the session ID to ensure that there are no traces left:
            Session::flush(); // Remove all session data

            Session::regenerate(); // Regenerate the session ID

            // Redirect the user to the login page or wherever you like
            return redirect('/admin')->with('success', 'You have been logged out successfully.');
        }
}
