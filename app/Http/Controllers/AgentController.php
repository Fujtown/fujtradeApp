<?php

namespace App\Http\Controllers;
use App\Models\Agent;
use App\Models\Member;
use App\Models\PaymentByLink;
use App\Models\NoonPaymentLink;
use App\Models\NoonTransaction;
use ZipArchive;
use App\Models\RefundRequest;
use App\Models\TapPaymentLink;
use App\Models\Foloosi;
use App\Models\PaymentLedger;
use Illuminate\Http\Request;
use App\Helpers\UniqueNumberGenerator;
use App\Models\AgentLinkLimit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CustomerKYC;
use App\Models\TapRefunds;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FoloosiTransactionsExport;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Import DB facade

class AgentController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('pages.agent.dashboard');
    }

    public function create_link(Request $request)
    {
        return redirect()->route('coffee.agent.create_noon_link');
        // dd();
        // $user = Auth::guard('admin')->user();
        //  if (in_array($user->id, [11, 17, 18])) {
        // Redirect to another function within the same controller
        // return $this->new_agent_foloosi_link();
        // return redirect()->route('coffee.agent.new_agent_foloosi_link');

        // Or, redirect to a named route
        // return redirect()->route('name_of_your_route');

        // Or, redirect to a specific URI
        // return redirect('/your-desired-path');
    // }
    // else{
        //  $user = Auth::guard('admin')->user();
        // $user_id = $user->id;
        // $query = AgentLinkLimit::query();
        // $query->where('agentID', $user_id);
        // $payment = $query->get()->first();
        // dd();
    //     if($payment !=null)
    //     {
    //         $limit_amount=$payment->limit_amount;
    //     }
    //     else{
    //         $limit_amount=0;
    //     }
       
    //   return view('pages.agent.create_link',compact('limit_amount'));
    }

    // public function store_link(Request $request)
    // {
    //     $payment_type = $request->input('payment_type');
    //     $amount = $request->input('amount');
    //      $temp_inv = $request->input('temp_inv');
    //     $currency = $request->input('currency');
    //     $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();
    //     $logo =asset('assets/link-logo.png');


    //     $clientName = "Hi Client,"; // Replace with actual client name


    //     $user = Auth::guard('admin')->user();
    //     $user_id = $user->id;
    //     $billAmount = $currency . ' ' . $amount;
    //     $url = url('/payment/' . $random_number);

    //     $message = "$clientName Here is your bill of  $billAmount from Fujtown. You can easily view & pay your bill online now $url.
    //     ";
    //     // dd($message);

    //      TapPaymentLink::create([
    //         'amount' => $amount,
    //         'currency' => $currency,
    //         'payment_type' => $payment_type,
    //         'url' => $message, // Assuming this was intended to store the message
    //         'random_no' => $random_number,
    //         'link_payment' => 'tap',
    //         'agentID'=>$user->id
    //     ]);

    //      $customerKYC = CustomerKYC::firstOrNew(['temp_inv_no' => $temp_inv]);
    //         $customerKYC->invoice_no = $random_number;
    //          $customerKYC->save();

    //     // Redirect or return a response
    //     return response()->json([
    //         'url' => $message,
    //         'success' => 'Payment link created successfully.'
    //     ]);

    // }

    public function update_link(Request $request)
    {

        $payment_type = $request->input('payment_type');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $id = $request->input('id');
        $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();
        // $logo =asset('assets/link-logo.png');


        $clientName = "Hi Client,"; // Replace with actual client name



        $billAmount = $currency . ' ' . $amount;
        // $url = "http://localhost:8000/payment/" . $random_number;
        $url = url('/payment/' . $random_number);

        $message = "$clientName Here is your bill of  $billAmount from Fujtown. You can easily view & pay your bill online now $url.
        ";
        // dd($message);
        $url = TapPaymentLink::findOrFail($id);
        $url->amount = $amount;
        $url->currency = $currency;
        $url->payment_type = $payment_type;
        $url->url = $message;
        $url->random_no =  $random_number;
        // Update other fields as necessary
        $url->save();
        // Redirect or return a response
        return back()->with('success', 'Payment link updated successfully.');
    }

    public function get_all_links(Request $request)
    {
        $query = TapPaymentLink::query();

        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
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
        $query->where('agentID', $user_id);

        $payments = $query->orderBy('id', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No Links Found.'], 404);
        }

        return response()->json($payments);
    }

    public function all_links(Request $request)
    {
        // dd();
        return view('pages.agent.all_links');
    }

    public function create_refund_requests(Request $request)
    {
        return view('pages.agent.create_refund_request');
    }
    public function all_refund_requests(Request $request)
    {
        return view('pages.agent.all_refund_requests');
    }

    public function get_all_fund_requests(Request $request)
    {
        $query = RefundRequest::query();

        // Get the payments
        $refunds = $query->get();
        if ($refunds->isEmpty()) {
            return response()->json(['message' => 'No Refund Request Found.'], 404);
        }

        return response()->json($refunds);
    }


    public function create_kyc_by_agent()
    {
        return view('pages.agent.upload_kyc_by_agent');
    }
    public function store_agent_kyc(Request $request)
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
                        'agentID' => $user_id
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

    public function all_kyc_by_agent(Request $request)
        {
            return view('pages.agent.all_kyc_by_agent');
        }
    public function get_all_kyc_by_agent(Request $request)
    {
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $query = CustomerKYC::query();
        $query->where('agentID', $user_id);
        $payment = $query->get();

        $kyc = $query->get();
        if ($kyc->isEmpty()) {
            return response()->json(['message' => 'No KYC Documents Found.'], 404);
        }

        return response()->json($kyc);
    }

    public function delete_kyc_by_agent(Request $request)
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


    public function store_refund_request(Request $request)
    {
        $customer_name = $request->input('customer_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $refund_amount = $request->input('amount');
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $user_type='agent';

        RefundRequest::create([
            'customer_name' => $customer_name,
            'email' => $email,
            'phone' => $phone,
            'refund_amount' => $refund_amount,
            'agentID' => $user_id,
            'user_type' => $user_type,
        ]);

        // Redirect or return a response
        return response()->json([
            'success' => 'Refund Request created successfully.'
        ]);
    }

    public function get_refund_detail(Request $request)
    {
        $query = RefundRequest::query();
        $query->where('id', $request->id);
        $payment = $query->get();
        if ($payment->isEmpty()) {
            return response()->json(['message' => 'No Refund Request Found.'], 404);
        }

        return response()->json(['data' => $payment]);
    }

    public function update_refund_request(Request $request)
    {

        $customer_name = $request->input('customer_name');
        $amount = $request->input('amount');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $id = $request->input('id');
        // $logo =asset('assets/link-logo.png');
        // dd($message);
        $refund = RefundRequest::findOrFail($id);
        $refund->refund_amount = $amount;
        $refund->customer_name = $customer_name;
        $refund->email = $email;
        $refund->phone = $phone;
        // Update other fields as necessary


        $refund->save();
        // Redirect or return a response
        return back()->with('success', 'Refund Request updated successfully.');
    }




    public function link_payments()
    {
        return view('pages.agent.link_payments');
    }

    public function get_link_payments_status()
    {
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        
           // Get all unique createdBy values from the admin table
       $createdByValues = DB::table('admin')
                            ->where('createdBy', $user_id)
                            ->distinct()
                            ->pluck('id')
                            ->toArray();
        //            // Add user_id to the $createdByValues array
        $createdByValues[] = $user_id;
        // dd($createdByValues);
        $query = NoonTransaction::query();
       $query->where('status', 'CAPTURED');
        $query->whereIn('agentID', $createdByValues);
        $payment =  $query->orderBy('id', 'desc')->get();
        
        if ($payment->isEmpty()) {
            return response()->json(['message' => 'No Links Payment Found.'], 404);
        }

        return response()->json($payment);
    }


    public function create_member(Request $request)
    {
        return view('pages.agent.create_member');
    }
    public function all_members(Request $request)
    {
        return view('pages.agent.all_members');
    }

    public function store_member(Request $request)
    {
        $username = $request->input('username');
        $email = $request->input('email');
        $password = $request->input('password');
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        Member::create([
            'username' => $username,
            'email' => $email,
            'password' =>  Hash::make($password),
            'is_admin' => '5',
            'createdBy' => $user_id,
            'user_type' =>'member'
        ]);

        // Redirect or return a response
        return response()->json([
            'success' => 'Member created successfully.'
        ]);
    }
    public function get_all_members(Request $request)
    {
        $query = Member::query();
        // Get the payments

        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $query->where('user_type', 'member');
        $query->where('createdBy', $user_id);
        $agents = $query->get();
        if ($agents->isEmpty()) {
            return response()->json(['message' => 'No Member Found.'], 404);
        }

        return response()->json($agents);
    }


    public function delete_member(Request $request)
    {
        // dd();
        $item = Member::findOrFail($request->id); // Find the item by ID or fail
        $item->delete(); // Delete the item

        return back()->with('success', 'Item deleted successfully.');
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

public function new_agent_foloosi_link(){

    return redirect()->route('coffee.agent.dashboard')->with('message', 'Foloosi has been stopped, please use Tap payment links.');

    //  $user = Auth::guard('admin')->user();
    //     $user_id = $user->id;
    //     $query = AgentLinkLimit::query();
    //     $query->where('agentID', $user_id);
    //     $payment = $query->get()->first();
    //     // dd();
    //     if($payment !=null)
    //     {
    //         $limit_amount=$payment->limit_amount;
    //     }
    //     else{
    //         $limit_amount=0;
    //     }

    //     return view('pages.agent.agent_foloosi_link',compact('limit_amount'));
    // return view('pages.agent.agent_foloosi_link');
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
    
       public function todayTransaction(Request $request)
    {
         $transactions = []; // Initialize your transactions data
         
    $user = Auth::guard('admin')->user();
    $user_id = $user->id;
         if ($request->has('start') && $request->start != '') {
        $date = $request->start;
      
    } else {
         $date=date('Y-m-d');
    }
    
            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            // dd($endDate);
            // First, get all transaction numbers from the all_tap_refunds table that match your criteria
$refundedTransactionNos = TapRefunds::whereBetween('created', [$startDate, $endDate])
                    ->pluck('charge_id')->toArray();
// dd($refundedTransactionNos);            
            
            
           // Then get transactions from payment_ledger excluding refunded ones
           $tap_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
            ->where('source_table', 'all_tap_payment')
            ->whereNotIn('transaction_no', $refundedTransactionNos)
            ->whereHas('paymentByLink', function ($query) use ($user_id) {
                $query->where('agentID', $user_id);
            })
            ->get();
    // dd($tap_transactions);        
            
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
        // $linkedPayment = PaymentByLink::where('payment_by_link.ch_id', $transaction->transaction_no)
        //                               ->join('admin', 'payment_by_link.agentID', '=', 'admin.id')
        //                               ->first(['payment_by_link.*', 'admin.username as agentUsername']);

            $linkedPayment = PaymentByLink::where('payment_by_link.ch_id', $transaction->transaction_no)
                              ->join('admin', 'payment_by_link.agentID', '=', 'admin.id')
                              ->first(['payment_by_link.*', 'admin.username as agentUsername']);
        //   dd($linkedPayment);                   
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
                
          // For Foloosi transactions, make sure to get transactions associated with the current agent
    $foloosi_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
            ->where('source_table', 'foloosis')
            ->whereHas('foloosi', function ($query) use ($user_id) {
                $query->where('agentID', $user_id);
            })
            ->get();
                // dd($foloosi_transactions);
             $currencyTotals2 = []; // Initialize an empty array for storing totals by currency
                
                     // Iterate through each transaction to check for a corresponding record in payment_by_link
            foreach ($foloosi_transactions as $ftransaction) {
                 // Check if the currency already exists in the array
          if (array_key_exists($ftransaction->currency, $currencyTotals2)) {
            // Add to the existing amount
            $currencyTotals2[$ftransaction->currency] += $ftransaction->amount;
        } else {
            // Initialize this currency in the array
            $currencyTotals2[$ftransaction->currency] = $ftransaction->amount;
        }
        
                // Attempt to find a corresponding record in payment_by_link and join with the admin table to get the username
        $linkedPayment2 = Foloosi::where('foloosis.transaction_no', $ftransaction->transaction_no)
                                      ->join('admin', 'foloosis.agentID', '=', 'admin.id')
                                      ->first(['foloosis.*', 'admin.username as agentUsername']);

        
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
           
         return view('pages.agent.today_transaction',compact(['filteredTapTransactions','foloosi_transactions','totalsByCurrency','totalsByCurrency2','finalTotalsByCurrency']));
    }
    
    
            public function exportTapTransactionsPdf($date = null)
{
     $user = Auth::guard('admin')->user();
    $user_id = $user->id;
    // dd($user_id);
         
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
            ->whereNotIn('transaction_no', $refundedTransactionNos)
            ->whereHas('paymentByLink', function ($query) use ($user_id) {
                $query->where('agentID', $user_id);
            })
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
     $user = Auth::guard('admin')->user();
    $user_id = $user->id;
         
         $date = $date ?? Carbon::now()->format('Y-m-d');
        // $date = Carbon::yesterday()->format('Y-m-d');
        //  dd($date);

            $minDate = Carbon::createFromFormat('Y-m-d', $date)->startOfDay();
            $maxDate = Carbon::createFromFormat('Y-m-d', $date)->endOfDay();
            
            $startDate = $minDate->timestamp * 1000;
            $endDate = $maxDate->timestamp * 1000;
            
            
            
            // Sum the amount for records within the specified date range
          $foloosi_transactions = PaymentLedger::whereBetween('date', [$startDate, $endDate])
            ->where('source_table', 'foloosis')
            ->whereHas('foloosi', function ($query) use ($user_id) {
                $query->where('agentID', $user_id);
            })
            ->with(['foloosi' => function ($query) use ($user_id) {
                $query->where('agentID', $user_id);
            }])
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
        $linkedPayment = Foloosi::where('foloosis.transaction_no', $transaction->transaction_no)
                                      ->join('admin', 'foloosis.agentID', '=', 'admin.id')
                                      ->first(['foloosis.*', 'admin.username as agentUsername']);
        
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
            'link_payment' => 'noon',
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

        return view('pages.agent.new_noon_link',compact('limit_amount'));
    }
    
    
         public function noon_links(Request $request)
    {
        // dd();
        return view('pages.agent.noon_links');
    }
    
        public function get_all_noon_links(Request $request)
        {
            $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        
           // Get all unique createdBy values from the admin table
       $createdByValues = DB::table('admin')
                            ->where('createdBy', $user_id)
                            ->distinct()
                            ->pluck('id')
                            ->toArray();
        //           
        
        $query = NoonPaymentLink::with('agent');
        
        $minDateStr = $request->query('min_date'); // 'YYYY-MM-DD'
        $maxDateStr = $request->query('max_date'); // 'YYYY-MM-DD'
        $status = $request->query('status');
        
        if ($minDateStr && $maxDateStr && $status == '') {
            $query->whereBetween('created_at', [$minDateStr, $maxDateStr]);
        } elseif ($minDateStr && $maxDateStr && $status) {
            $query->whereBetween('created_at', [$minDateStr, $maxDateStr])
                  ->where('payment_type', $status);
        } elseif ($status) {
            $query->where('payment_type', $status);
        }
        
         // Add user_id to the $createdByValues array
        $createdByValues[] = $user_id;
        
        $query->whereIn('agentID', $createdByValues);
        
        // Get the payments
        $payments = $query->get();
        
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No Links Found.'], 404);
        }
        
        // Return the payments
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

}
