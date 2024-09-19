<?php

namespace App\Http\Controllers;

use App\Models\AgentLinkLimit;
use App\Models\Member;
use App\Models\PaymentByLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\TapPaymentLink;
use App\Models\CustomerKYC;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\UniqueNumberGenerator;
class MemberController extends Controller
{
    public function dashboard()
    {
        return view('pages.member.dashboard');
    }
    public function all_links_by_member()
    {
        return view('pages.member.all_links_by_member');
    }
    public function new_link_by_member(Request $request)
    {
        // dd();
        // $user = Auth::guard('admin')->user();
        // $user_id = $user->createdBy;
        // $query = AgentLinkLimit::query();
        // $query->where('agentID', $user_id);
        // $payment = $query->get()->first();
        // // dd();
        // if($payment !=null)
        // {
        //     $limit_amount=$payment->limit_amount;
        // }
        // else{
        //     $limit_amount=0;
        // }

        // return view('pages.member.new_link_by_member',compact('limit_amount'));
        return redirect()->route('coffee.member.create_noon_link');
    }
    
      public function new_member_foloosi_link(){

        return view('pages.member.member_foloosi_link');
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
        // dd($user_id);
        $query->where('agentID', $user_id);

        $payments = $query->orderBy('id', 'desc')->get();
        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No Links Found.'], 404);
        }

        return response()->json($payments);
    }

    public function store_link(Request $request)
    {
        $payment_type = $request->input('payment_type');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $random_number = UniqueNumberGenerator::generateUniqueRandomNumber();
        $logo =asset('assets/link-logo.png');

        $temp_inv = $request->input('temp_inv');
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
            'agentID'=>$user->id,
             'temp_inv_no'=>$temp_inv
        ]);
            
              $customerKYC = CustomerKYC::firstOrNew(['temp_inv_no' => $temp_inv]);
            $customerKYC->invoice_no = $random_number;
             $customerKYC->save();

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
            'success' => 'Foloosi Payment link created successfully.'
        ]);

    }



    public function link_payments_by_member()
    {
        return view('pages.member.link_payments');
    }

    public function get_link_payments_status()
    {
        $user = Auth::guard('admin')->user();
        $user_id = $user->id;
        $query = PaymentByLink::query();
        $query->where('agentID', $user_id);
        $payment =  $query->orderBy('id', 'desc')->get();
        if ($payment->isEmpty()) {
            return response()->json(['message' => 'No Links Payment Found.'], 404);
        }

        return response()->json($payment);
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

        return view('pages.member.new_noon_link',compact('limit_amount'));
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
    
      public function noon_links(Request $request)
    {
        // dd();
        return view('pages.member.noon_links');
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
            
            $user = Auth::guard('admin')->user();
            $user_id = $user->id;
            // dd($user_id);
            $query->where('agentID', $user_id);
            
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



}
