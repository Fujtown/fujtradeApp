<?php

namespace App\Http\Controllers;
use App\Models\AllTapPaymentAPI;
use App\Models\Contact;
use App\Mail\ContractMail;
use App\Models\Customer;
use App\Models\PaymentByLink;
use App\Models\TapPaymentLink;
use App\Models\TapPayment;
use App\Models\Foloosi;
use App\Models\CustomerKYC;
use App\Models\NoonPaymentLink;
use App\Models\CustomerKycStatus;
use App\Models\NoonTransaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneratesClientPdf;
use App\Traits\SendsWelcomeEmail;
use App\Models\LinkStatus;
use App\Models\NetworkIntLink;
use App\Models\TempHoldCustomerSign;
use App\Traits\SendClientAgreementEmail;
use Illuminate\Support\Facades\Http;
use DateTime;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    use SendsWelcomeEmail;
    use SendClientAgreementEmail;
    use GeneratesClientPdf;
    public function index()
        {

            return view('pages.home');
        }

    public function terms()
        {
            return view('pages.terms');
        }

    public function contact()
    {
        return view('pages.contact');
    }
    public function about()
    {
        return view('pages.about');
    }
    public function career()
    {
        return view('pages.career');
    }
    public function payment($id)
    {
        $secretKey = config('payments.tap_payment_secret');
        // dd($secretKey);
        // $query = TapPaymentLink::query();
        // $query->where('random_no', $id);
        $payment = TapPaymentLink::where('random_no', $id)
        ->where('is_expire', '!=', 2)
        ->first();
        // dd($payment);

        if ($payment != null) {
            session(['url_no' => $id]);
            return view('pages.payment',compact('payment'));
            // dd('this is not a valid payment');

        }
        else{
            return response()->view('errors.404', ['message' => 'The link has been expired.'], 404);
        }

    }

    public function confirm($id)
    {
        return view('pages.confirm',compact('id'));
    }

    public function updateClientPassword(Request $request)
    {
        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');
        $id = $request->input('id');

        $customer = Customer::findOrFail($id);
        // $check = Hash::check($currentPassword, $customer->password);

        // Log::info('Password from request: ' . $currentPassword);
        // Log::info('Hashed password from database: ' . $customer->password);

// You can also check the hash operation directly to see if it's functioning as expected
    $check = Hash::check($currentPassword, $customer->password);
    // Log::info('Password check result: ' . $check);
         // Check if the current password matches
        if (!$check) {
            return response()->json(['status' => 'error', 'message' => 'Current password does not match.'], 401);
        }

        $customer->password = Hash::make($newPassword);
        // Update other fields as necessary
        $customer->save();
        // Redirect or return a response
        return back()->with('success', 'Payment link updated successfully.');
    }
    public function market()
    {
        // $curl = curl_init();

        // curl_setopt_array($curl, [
        //     CURLOPT_URL => "https://twelve-data1.p.rapidapi.com/forex_pairs?format=json&currency_base=EUR",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => [
        //         "X-RapidAPI-Host: twelve-data1.p.rapidapi.com",
        //         "X-RapidAPI-Key: 66976a39a7msh50001334aa93d42p13f4acjsn9e3bd15817ca"
        //     ],
        // ]);

        // $response = curl_exec($curl);
        // $err = curl_error($curl);

        // curl_close($curl);

        // $jsonData = json_decode($response);
        // return view('pages.market',['currencies' => $jsonData->data]);
        return view('pages.market');
    }

    public function save_contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Handle the data
        $contact = new Contact();
        $contact->fill($validated);
        $contact->save();

        return response()->json(['success' => 'Message sent successfully']);
    }
    public function deleteExistingPdf($filepath)
    {
        try {
            if (File::exists($filepath)) {
                File::delete($filepath);
                return response()->json(['message' => 'Existing file deleted']);
            } else {
                return response()->json(['message' => 'File not found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting the file'], 500);
        }
    }
    public function generatePdf($name_para, $date_para, $email_para, $phone_para)
{
    try {
        $name = $name_para;
        $date = $date_para;
        $email = $email_para;
        $phone = $phone_para;
        $customerSign = '';
            
            
        // dd($name);
        // Create a new PDF instance
        $pdf = PDF::loadView('pdf_template', compact('name', 'date', 'email', 'phone','customerSign'));
        // dd($pdf);
        // Generate the PDF content
        $pdfContent = $pdf->output();
        // dd($pdfContent);
        // Define the PDF file name
        $filename = 'output.pdf';

        // Store the PDF file in a temporary directory or your desired location
        // In this example, we are storing it in the public directory
        $pdf->save(public_path($filename));

        // Optionally, you can log this action
        Log::info('PDF generated and saved: ' . public_path($filename));

        // Return the PDF as a download response
        // return response()->file(public_path($filename));
        return response()->json(['pdf_url' => asset($filename)]);
    } catch (\Exception $e) {
        // Handle any exceptions that may occur during PDF generation
        Log::error('Error generating PDF: ' . $e->getMessage());

        // Return an error response if needed
        return response()->json(['message' => 'Error generating PDF','status'=>'error'], 200);
    }
}
        public function open_account(Request $request)
        {
            // Your logic to open an account

            // For example, validating the request
            $validatedData = $request->validate([
                'email' => 'required',
            ]);

            try {

                $email = $request->input('email');
                $email_demo = $email;
                // dd($email_demo);
                $result = DB::select("
                    SELECT *
                    FROM all_tap_payment
                    WHERE email = ? AND status = 'CAPTURED'
                    ORDER BY date ASC
                    LIMIT 1
                ", [$email_demo]);



                if (empty($result)) {
                    return response()->json(['message' => 'No records found.','status'=>'error'], 200);
                }

                $row = $result[0];
                $name = $row->first_name . ' ' . $row->last_name;
                $email = $row->email;
                $date = $row->date;
                $seconds = $date / 1000; // Convert milliseconds to seconds
                $date_format = date("M-d-Y", $seconds); // Format the date

                // $name = isset($name) ? preg_replace("/[^a-zA-Z0-9\s]/", "", $name) : 'default';
                // $name = str_replace(' ', '_', $name);
                // Concatenate to create the filename
                $filename = 'output.pdf';
                // $filename = $name . 'output.pdf';
                $this->deleteExistingPdf(public_path($filename));
                // dd($date_format);
                $number = $row->country_code . ' ' . $row->number;

                $pdfPath = $this->generatePdf($name, $date_format, $email, $number);
                // dd($pdfPath->original['pdf_url']);
                $pdf_send=$pdfPath->original['pdf_url'];
                // dd(public_path('output.pdf'));
                $path = public_path('output.pdf');
                // $path = public_path($name.'.pdf');

                // dd($path);
                $isExists = File::exists($path);

                if ($isExists) {
                      $data["email"] = "tech@fujtown.com";
                     $data["title"] = "fujtrade.com | Contract Letter";
                     $data["client_name"]=$name;
                     $data["client_email"]=$email;
                     $data["client_number"]=$number;
                     $data["client_date"]=$date_format;

                $files = [
                    $path,
                ];
                // dd($files);
                Mail::send('mail.contract_mail', $data, function($message)use($data, $files) {
                    $message->to($data["email"])
                            ->subject($data["title"]);

                    foreach ($files as $file){
                        $message->attach($file);
                    }
            });

                    return response()->json(['message' => 'Email sent successfully','status'=>'success'], 200);
                } else {
                    return response()->json(['message' => 'Failed to create PDF','status'=>'error'], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal server error','status'=>'error'], 200);
            }

            // Return a response

        }

        public function createCharge(Request $request)
        {
             $requestData = $request->all();
    $signatureImageBase64 = $requestData['signature_image'];
    unset($requestData['signature_image']);
    
    $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
        $imageName = 'signature_' . time() . '.png';
  
        $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
        $imageName = 'signature_'.$requestData['customer']['first_name']. time() . '.png';
        $path = public_path('signature/' . $imageName);
        file_put_contents($path, $signatureImage);

        $temp_data['customer_name'] = $requestData['customer']['first_name'] .' '.$requestData['customer']['last_name'];
         $temp_data['customer_email'] = $requestData['customer']['email'];
          $temp_data['customer_sign'] = $imageName;

     
        TempHoldCustomerSign::create($temp_data);
        
           
              $secretKey = config('payments.tap_payment_secret');
            
            try {
                $client = new Client();

                $response = $client->post('https://api.tap.company/v2/charges/', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer '. $secretKey
                    ],
                    'body' => json_encode($request->all())
                ]);


                  echo $response->getBody();


            } catch (\Exception $e) {
                Log::error('Error creating charge: '.$e->getMessage());
                return response()->json(['error' => 'Internal Server Error'], 500);
            }
        }

        public function success(Request $request)
        {
            $tapId = $request->tap_id;
            // $secretKey = env('TAP_PAYMENT_SECRET');
              $secretKey = config('payments.tap_payment_secret');

            // dd($secretKey);
            return view('pages.success',compact(['tapId','secretKey']));
        }

        public function save_payment_data(Request $request)
        {
            $tapId = $request->query('tap_id');
            $agentID = $request->query('agentID');

        if (!$tapId) {
            return response()->json(['error' => 'tap_id is required'], 400);
        }



        try {
            // $secretKey = env('TAP_PAYMENT_SECRET');
             $secretKey = config('payments.tap_payment_secret');
            $client = new Client();
            $response = $client->request('GET', 'https://api.tap.company/v2/charges/'.$tapId, [
                'headers' => [
                  'Authorization' => 'Bearer ' .$secretKey,
                  'accept' => 'application/json',
                ],
              ]);

              // Get the response body as a string
            $bodyContent = (string) $response->getBody();

            // Assuming the body content is JSON and you want to decode it first to manipulate or just re-encode it

            //   dd($data);

            // Your logic to check if chr_id exists
            $chrIdExists = $this->doesChrIdExist($tapId);

            if (!$chrIdExists) {
                // dd('work');
                $this->succss_saveDataToFile($bodyContent,$agentID);
                return response()->json(['success' => true, 'data' => $bodyContent]);
            } else {
                return response()->json(['success' => false, 'error' => 'Record with chr_id already exists.']);
            }
        } catch (\Exception $e) {
            Log::error("Error fetching payment data: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        }

        protected function doesChrIdExist($chrId)
        {
            $exists = PaymentByLink::where('ch_id', $chrId)->exists();
            return $exists;
        }

        protected function succss_saveDataToFile($bodyContent,$agentID)
        {
            $content = json_encode($bodyContent, JSON_PRETTY_PRINT);
            $charge = json_decode($bodyContent, true);
            
            // Assuming $data is an array with the necessary structure
            $amount = $charge['amount'];
            $brand = $charge['card']['brand'] ?? 'defaultBrand';
            $ch_id = $charge['id'];
            $code = $charge['response']['code'];
            $country_code = $charge['customer']['phone']['country_code'];
            $currency = $charge['currency'];
            $customer_id = $charge['customer']['id'] ?? '---';
            $date = $charge['transaction']['created'];
            $email = $charge['customer']['email'] ?? null;
            $first_name = $charge['customer']['first_name'] ?? null;
            $invoice_id = $charge['metadata']['invoice_id'] ?? null;
            $last_name = $charge['customer']['last_name'] ?? null;
            $message = $charge['response']['message'];
            $number = $charge['customer']['phone']['number'] ?? null;
            $transaction = $charge['reference']['transaction'];
            $payment = $charge['reference']['payment'] ?? '0';
            $receipt = $charge['receipt']['id'] ?? null;
            $status = $charge['status'];
            $card = $charge['source']['payment_method'];
            $track = $charge['reference']['track'] ?? 'defaultTrack';
            $shortcode=$charge['metadata']['shortcode'] ?? null;
            $pdatas = [
                'date' => $date,
                'ch_id' => $ch_id,
                'status' => $status,
                'amount' => $amount,
                'brand' => $brand,
                'code' => $code,
                'currency' => $currency,
                'customer_id' => $customer_id,
                'message' => $message,
                'card' => $card,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'invoice_id' => $invoice_id,
                'country_code' => $country_code,
                'number' => $number,
                'transaction' => $transaction,
                'payment' => $payment,
                'receipt' => $receipt,
                'track' => $track,
                 'short_code' => $shortcode,
                'agentID' => $agentID,
                'created_at' => now()
            ];

            $tdatas = [
                'date' => $date,
                'ch_id' => $ch_id,
                'status' => $status,
                'amount' => $amount,
                'brand' => $brand,
                'code' => $code,
                'currency' => $currency,
                'customer_id' => $customer_id,
                'message' => $message,
                'card' => $card,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'invoice_id' => $invoice_id,
                'country_code' => $country_code,
                'number' => $number,
                'transaction' => $transaction,
                'payment' => $payment,
                'receipt' => $receipt,
                'track' => $track,
                 'short_code' => $shortcode,
                'created_at' => now()
            ];

                 // Save to database
                 PaymentByLink::create($pdatas);
                 TapPayment::create($tdatas);

            // Determine file path based on status
            $filePath = $status == 'CAPTURED' ? 'charge_data.txt' : 'charge_failed_data.txt';
            $link_no=session('url_no');
            if($status=='CAPTURED'){
                
                   $ldata=[
                'link_no'=>$link_no,
                'transaction_id'=>$ch_id,
                'status'=>$status,
                'link_payment'=>'TAP'
                ];    
                
                 LinkStatus::create($ldata);
                 
                  $customerName = $first_name . " " . $last_name; // Concatenate first name and last name
                $kycStatus = 1; // Setting status to 1
            
                 $customerKYC = CustomerKycStatus::firstOrNew(['temp_invoice_no' => $link_no]);
                $customerKYC->customer_name = $customerName;
                $customerKYC->customer_email = $email;
                $customerKYC->customer_phone = $country_code . $number;
                $customerKYC->status = 'success';
                $customerKYC->save();
                
                if($agentID !=10)
                {
                      // Check if a CustomerKYC record exists for this invoice_no
                  $customerKYC2 = CustomerKyc::firstOrNew(['invoice_no' => $link_no]);
                  $customerKYC2->customer_name = $customerName;
                  $customerKYC2->status = 1;
                  $customerKYC2->save();
                }
              

                TapPaymentLink::where('random_no', $link_no)->update(['is_expire' => 2]);
                // First, check if a customer with the given email already exists
                $existingCustomer = Customer::where('email', $email)->first();
                  $customerSignData = TempHoldCustomerSign::where('customer_email', $email)->first();    
                if (!$existingCustomer) {
                    
                              // Check if the customer sign data exists
            if ($customerSignData) {
                // Get the customer sign from the retrieved data
                $customerSign = $customerSignData->customer_sign;
            }
            
                    // If no existing customer, generate a random password
                    $randomPassword = rand(10000000, 99999999); // Generate an 8-digit random number for the password

                    // Prepare customer data
                    $cdatas = [
                        'fname' => $first_name,
                        'lname' => $last_name,
                        'username' => $first_name . $last_name, // Consider adding a separator or handling potential username clashes
                        'email' => $email,
                        'phone' => $country_code . $number,
                        'password' => Hash::make($randomPassword), // Encrypt the password
                        'photo' => 'default.png',
                        'customer_sign'=>$customerSign,
                        'account_ctype' => 'Payment_success',
                    ];

                    // Create a new customer record
                    $customer =  Customer::create($cdatas);
                    $lastInsertedId = $customer->id;
                    // Prepare the email data
                    $mdata = [
                        'email' => $email, // Recipient's email
                        'title' => 'Welcome to Fujtrade!',
                        'link' => url('/confirm',$lastInsertedId ),
                        'password' => $randomPassword // Assuming you want to send the password in the email
                    ];

                    // Send the welcome email
                    $this->sendWelcomeEmail($mdata['email'], $mdata['link'], $mdata['email'], $mdata['password']);

                    // Mail::send('mail.welcome_mail', $mdata, function($message) use ($mdata) {
                    //     $message->to($mdata['email'])->subject($mdata['title']);
                    // });

                    $this->generateClientPdf($email);
                }
                 else{
                    // Check if the customer sign data exists
                    if ($customerSignData) {
                        // Get the customer sign from the retrieved data
                        $customerSign = $customerSignData->customer_sign;
        
                        // Update the customer's customer_sign column
                        $existingCustomer->customer_sign = $customerSign;
                        $existingCustomer->save();
                    }
                }
            }
            else{
                $existingCustomer = Customer::where('email', $email)->first();
                $customerSignData = TempHoldCustomerSign::where('customer_email', $email)->first();    
                 // Check if the customer sign data exists
                    if ($customerSignData) {
                        // Get the customer sign from the retrieved data
                        $customerSign = $customerSignData->customer_sign;
        
                        // Update the customer's customer_sign column
                        $existingCustomer->customer_sign = $customerSign;
                        $existingCustomer->save();
                    }
                    
                $expireSum = TapPaymentLink::where('random_no', $link_no)
                ->sum('is_expire');
                $expireSum +=1;
                TapPaymentLink::where('random_no', $link_no)->update(['is_expire' => $expireSum]);
            }
            // Use Storage facade to save data to a file in the local storage
            Storage::disk('local')->put($filePath, $content);
        }

        public function get_last_payment(Request $request)
        {
            $tapId = $request->query('tap_id');

            if (!$tapId) {
                return response()->json(['error' => 'tap_id is required'], 400);
            }

            try {
                // $secretKey = env('TAP_PAYMENT_SECRET');
                 $secretKey = config('payments.tap_payment_secret');
                $client = new Client();
                $response = $client->request('GET', 'https://api.tap.company/v2/charges/'.$tapId, [
                    'headers' => [
                      'Authorization' => 'Bearer '.$secretKey,
                      'accept' => 'application/json',
                    ],
                  ]);
                  $bodyContent = $response->getBody();
                  $content = json_encode($bodyContent, JSON_PRETTY_PRINT);
                 $charge = json_decode($bodyContent, true);

                  return response()->json(['success' => true, 'status' => $charge['status']]);

        }catch (\Exception $e) {
            Log::error("Error fetching payment data: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
}

public function invoice()
{
    return view('pages.invoice');
}
public function view_invoice($id)
{
    // dd($id);
    $payment = AllTapPaymentAPI::where('id', $id)
    ->where('status','CAPTURED')
    ->first();
    // dd($payment);
    // Convert milliseconds to seconds for Carbon
    $seconds = $payment->date / 1000;

    // Create a Carbon instance from the timestamp
    $date = Carbon::createFromTimestamp($seconds);

    // Format the date as 'm/d/Y' (e.g., '10/3/2023')
    $formattedDate = $date->format('m/d/Y');

    return view('pages.invoice',compact('payment','formattedDate'));
}
public function test_mail()
{


}

public function test_payment_api()
{
         
  $client = new Client();
    $response = $client->request('GET', 'https://api.tap.company/v2/charges/chg_LV01D4220241355l7N11903410', [
        'headers' => [
            'Authorization' => 'Bearer '.env('TAP_API_KEY'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
    ]);

    $charge = json_decode($response->getBody()->getContents(), true);
    // dd($charges);
   
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
    
     PaymentByLink::create([
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
            'agentID' => '9',
            'created_at' => now(), // Laravel's now() function to set the current timestamp
        ]);

    // PaymentByLink::create($pdatas);
     // If transactions were processed, return a success message with the last charge ID
    return response()->json([
        'message' => 'Transactions fetched and saved successfully.',
        // 'lastChargeId' => $lastChargeId
    ], 200);
    
    //   $secretKey = config('payments.tap_payment_secret');
            // dd($secretKey);
    // echo 'work';exit;
    // return view('pages.foloosi_payment');
}

// In HomeController

public function Redirect(Request $request)
{
    // Example of extracting query parameters
    $status = $request->query('status');
    $referenceToken = $request->query('reference_token');

    // Process the payment result
    // For example, log the status or update the payment status in your database

    return view('pages.foloosi_redirect', compact('status', 'referenceToken'));
}
 public function handleFoloosiWebhook(Request $request)
    {
        $data = $request->all();

        // Convert data to JSON format
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);

        // Define a unique filename with date and time
        $fileName = 'foloosi-webhook-' . now()->format('Y-m-d-H-i-s') . '.json';

        // Save JSON data to a file in the local storage
        Storage::disk('local')->put('foloosi_webhooks/' . $fileName, $jsonData);

        // Optionally log that the webhook was received
        Log::info('Foloosi webhook received and stored:', ['file' => $fileName]);

        // Respond to Foloosi to acknowledge receipt of the webhook
        return response()->json(['message' => 'Webhook received'], 200);
    }
    
     public function preparePayment($id)
    {
         return redirect()->route('home')->with('message', 'Foloosi has been stopped, please use Tap payment links.');
        
        // $payment = TapPaymentLink::where('random_no', $id)
        // ->where('is_expire', '!=', 2)
        // ->first();
        // if ($payment != null) {
        //     session(['url_no' => $id]);
        //     return view('pages.foloosi_payment',compact('payment'));

        // }
        // else{
        //     return response()->view('errors.404', ['message' => 'The link has been expired.'], 404);
        // }
    }

    

    public function saveFoloosiPaymentData(Request $request)
{
    // Assuming 'FLSAAPI000C65f1706085111' is a dynamic value you get from the request or elsewhere
   $transactionId = $request->input('transaction_no'); // Example transaction ID
   $agentID=$request->input('agentID');
    // $status=$request->query('status');
    $secretKey = env('FOLOOSI_SECRET_KEY'); // Replace with your actual secret key
    // dd($transactionId);
      // Check if the transaction already exists
    $existingPayment = Foloosi::where('transaction_no', $transactionId)->first();

    if ($existingPayment) {
        // Transaction already exists
        return response()->json(['message' => 'Transaction already exists'], 409);
    }
    else{
        
        
    $response = Http::withHeaders([
        'secret_key' => $secretKey,
    ])->get('https://api.foloosi.com/v2/api/transaction-detail/'.$transactionId);

    if ($response->successful()) {
        $transactionData = $response->json();

        // Assuming $transactionData['data'] contains the transaction details
        if (isset($transactionData['data'])) {
            $data = $transactionData['data'];

            // Create a new Payment record with the transaction details
            $payment = new Foloosi();
            $payment->transaction_no = $data['transaction_no'];
            $payment->request_currency = $data['request_currency'];
            $payment->request_amount = $data['request_amount'];
            $payment->customer_currency = $data['customer_currency'];
            $payment->customer_amount = $data['customer_amount'];
            $payment->merchant_currency = $data['merchant_currency'];
            $payment->merchant_amount = $data['merchant_amount'];
            $payment->status = $data['status'];
            $payment->payment_failed_reason = $data['payment_failed_reason'];
            $payment->created_at_foloosi = $data['created'];
            // Add other fields as necessary
            $payment->customer_name = $data['customer']['name'] ?? null;
            $payment->customer_email = $data['customer']['email'] ?? null;
            $payment->customer_phone_number = $data['customer']['phone_number'] ?? null;
            // Set card details
            $payment->pan = $data['card']['pan'] ?? null;
            $payment->card_type = $data['card']['card_type'] ?? null;
            $payment->bin_card = $data['card']['bin_card'] ?? null;
            $payment->issuer_name = $data['card']['issuer_name'] ?? null;
            $payment->issuer_country = $data['card']['issuer_country'] ?? null;
            $payment->card_expiry = $data['card']['card_expiry'] ?? null;
            $payment->holder_name = $data['card']['holder_name'] ?? null;
            $payment->card_reference = $data['card']['card_reference'] ?? null;
            $payment->card_id = $data['card']['card_id'] ?? null;
            $payment->card_bin = $data['card']['card_bin'] ?? null;
            $payment->bin_bank = $data['card']['bin_bank'] ?? null;
            $payment->bin_type = $data['card']['bin_type'] ?? null;
            $payment->bin_level = $data['card']['bin_level'] ?? null;
            $payment->bin_country_code = $data['card']['bin_country_code'] ?? null;
            $payment->bin_website = $data['card']['bin_website'] ?? null;
            $payment->bin_phone = $data['card']['bin_phone'] ?? null;
            $payment->bin_valid = $data['card']['bin_valid'] ?? null;
            $payment->card_issuer = $data['card']['card_issuer'] ?? null;
            $payment->agentID=$agentID;
            $payment->save();
            
               $link_no=session('url_no');
                $status=$data['status'];
            if($status=='success'){
                TapPaymentLink::where('random_no', $link_no)->update(['is_expire' => 2]);
                // dd($link_no);
                   $ldata=[
                'link_no'=>$link_no,
                'transaction_id'=>$data['transaction_no'],
                'status'=>$data['status'],
                'link_payment'=>'FOLOOSI'
                ];    
                
                 LinkStatus::create($ldata);
                 
                 $email=$data['customer']['email'];
                 // Assuming $data['customer']['name'] contains the full name.
                $fullName = $data['customer']['name'];
                
                // Split the name by spaces.
                $nameParts = explode(' ', trim($fullName));
                
                // Grab the first name (first element).
                $firstName = array_shift($nameParts);
                
                // If there are any remaining parts, the last part is assumed to be the last name.
                $lastName = array_pop($nameParts);
                
                
                  // First, check if a customer with the given email already exists
                $existingCustomer = Customer::where('email', $email)->first();

                if (!$existingCustomer) {
                    // If no existing customer, generate a random password
                    $randomPassword = rand(10000000, 99999999); // Generate an 8-digit random number for the password

                    // Prepare customer data
                    $cdatas = [
                        'fname' => $firstName,
                        'lname' => $lastName,
                        'username' => $fullName, // Consider adding a separator or handling potential username clashes
                        'email' => $email,
                        'phone' => $data['customer']['phone_number'],
                        'password' => Hash::make($randomPassword), // Encrypt the password
                        'photo' => 'default.png',
                        'account_ctype' => 'Payment_success',
                    ];

                    // Create a new customer record
                    $customer =  Customer::create($cdatas);
                    $lastInsertedId = $customer->id;
                    // Prepare the email data
                    $mdata = [
                        'email' => $email, // Recipient's email
                        'title' => 'Welcome to Fujtrade!',
                        'link' => url('/confirm',$lastInsertedId ),
                        'password' => $randomPassword // Assuming you want to send the password in the email
                    ];

                    // Send the welcome email
                    $this->sendWelcomeEmail($mdata['email'], $mdata['link'], $mdata['email'], $mdata['password']);

                    // Mail::send('mail.welcome_mail', $mdata, function($message) use ($mdata) {
                    //     $message->to($mdata['email'])->subject($mdata['title']);
                    // });

                    $this->generateFoloosiClientPdf($email);
                }
                else{
                      $this->generateFoloosiClientPdf($email);
                }
                 
            }
              else {
                $expireSum = TapPaymentLink::where('random_no', $link_no)
                ->sum('is_expire');
                $expireSum +=1;
                TapPaymentLink::where('random_no', $link_no)->update(['is_expire' => $expireSum]);
            }

            return response()->json(['message' => 'Payment data saved successfully'], 200);
        }
    }

    return response()->json(['message' => 'Failed to fetch transaction details or save payment data'], 500);
        
    }

}

public function save_manual_foloosi()
        {
             $secretKey = env('FOLOOSI_SECRET_KEY'); // Replace with your actual secret key
    // dd($transactionId);
    $transactionId='FLSAPIG000C65fc7bdca3a42';
    $response = Http::withHeaders([
        'secret_key' => $secretKey,
    ])->get('https://api.foloosi.com/v2/api/transaction-detail/'.$transactionId);

    if ($response->successful()) {
        $transactionData = $response->json();

        // Assuming $transactionData['data'] contains the transaction details
        if (isset($transactionData['data'])) {
            $data = $transactionData['data'];
            // dd($data);
            // Create a new Payment record with the transaction details
            $payment = new Foloosi();
            $payment->transaction_no = $data['transaction_no'];
            $payment->request_currency = $data['request_currency'];
            $payment->request_amount = $data['request_amount'];
            $payment->customer_currency = $data['customer_currency'];
            $payment->customer_amount = $data['customer_amount'];
            $payment->merchant_currency = $data['merchant_currency'];
            $payment->merchant_amount = $data['merchant_amount'];
            $payment->status = $data['status'];
            $payment->payment_failed_reason = $data['payment_failed_reason'];
            $payment->created_at_foloosi = $data['created'];
            // Add other fields as necessary
            $payment->customer_name = $data['customer']['name'] ?? null;
            $payment->customer_email = $data['customer']['email'] ?? null;
            $payment->customer_phone_number = $data['customer']['phone_number'] ?? null;
            // Set card details
            $payment->pan = $data['card']['pan'] ?? null;
            $payment->card_type = $data['card']['card_type'] ?? null;
            $payment->bin_card = $data['card']['bin_card'] ?? null;
            $payment->issuer_name = $data['card']['issuer_name'] ?? null;
            $payment->issuer_country = $data['card']['issuer_country'] ?? null;
            $payment->card_expiry = $data['card']['card_expiry'] ?? null;
            $payment->holder_name = $data['card']['holder_name'] ?? null;
            $payment->card_reference = $data['card']['card_reference'] ?? null;
            $payment->card_id = $data['card']['card_id'] ?? null;
            $payment->card_bin = $data['card']['card_bin'] ?? null;
            $payment->bin_bank = $data['card']['bin_bank'] ?? null;
            $payment->bin_type = $data['card']['bin_type'] ?? null;
            $payment->bin_level = $data['card']['bin_level'] ?? null;
            $payment->bin_country_code = $data['card']['bin_country_code'] ?? null;
            $payment->bin_website = $data['card']['bin_website'] ?? null;
            $payment->bin_phone = $data['card']['bin_phone'] ?? null;
            $payment->bin_valid = $data['card']['bin_valid'] ?? null;
            $payment->card_issuer = $data['card']['card_issuer'] ?? null;
            $payment->agentID=1;
            $payment->save();
          
            dd('save to database success');
            return response()->json(['message' => 'Payment data saved successfully'], 200);
        }
    }

        }
        
     public function Tapwebhook(Request $request)
    {
         $bodyContent = $request->all();
         $content = json_encode($bodyContent, JSON_PRETTY_PRINT);
            $charge = json_decode($content, true);

        Log::info('Webhook received:', $content);
        

        $chargeId = $charge['id'] ?? null;

        if ($chargeId && !PaymentByLink::where('ch_id', $chargeId)->exists()) {
           
             

            // Assuming $data is an array with the necessary structure
            $amount = $charge['amount'];
            $brand = $charge['card']['brand'] ?? 'defaultBrand';
            $ch_id = $charge['id'];
            $code = $charge['response']['code'];
            $country_code = $charge['customer']['phone']['country_code'];
            $currency = $charge['currency'];
            $customer_id = $charge['customer']['id'] ?? '---';
            $date = $charge['transaction']['created'];
            $email = $charge['customer']['email'] ?? null;
            $first_name = $charge['customer']['first_name'] ?? null;
            $invoice_id = $charge['metadata']['invoice_id'] ?? null;
            $last_name = $charge['customer']['last_name'] ?? null;
            $message = $charge['response']['message'];
            $number = $charge['customer']['phone']['number'];
            $transaction = $charge['reference']['transaction'];
            $payment = $charge['reference']['payment'] ?? '0';
            $receipt = $charge['receipt']['id'] ?? null;
            $status = $charge['status'];
            $card = $charge['source']['payment_method'];
            $track = $charge['reference']['track'] ?? 'defaultTrack';

            $pdatas = [
                'date' => $date,
                'ch_id' => $ch_id,
                'status' => $status,
                'amount' => $amount,
                'brand' => $brand,
                'code' => $code,
                'currency' => $currency,
                'customer_id' => $customer_id,
                'message' => $message,
                'card' => $card,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'invoice_id' => $invoice_id,
                'country_code' => $country_code,
                'number' => $number,
                'transaction' => $transaction,
                'payment' => $payment,
                'receipt' => $receipt,
                'track' => $track,
                'agentID' => 1,
                'created_at' => now()
            ];
            
             PaymentByLink::create($pdatas);
                
            // Optionally save the webhook payload to a file for record-keeping
            $fileName = "webhooks/{$chargeId}.json";
            Storage::disk('local')->put($fileName, json_encode($pdatas));

            return response()->json(['message' => 'Webhook processed and saved'], 200);
        } else {
            // Charge ID exists, handle accordingly or log
            Log::info("Charge ID {$chargeId} already exists.");
            return response()->json(['message' => 'Charge ID already exists'], 200);
        }
        
        return response()->json(['message' => 'Webhook received but not processed']);
    }    
    
      protected function isValidWebhook($data, $postedHashString)
{
    // Concatenate your data as per Tap's documentation
    $toBeHashedString = '...';

    // Your secret API key
    // $secretAPIKey = env('TAP_PAYMENT_SECRET');
     $secretAPIKey = config('payments.tap_payment_secret');

    // Compute the HMAC
    $computedHashString = hash_hmac('sha256', $toBeHashedString, $secretAPIKey);

    // Compare the computed HMAC with the one received in the webhook
    return $computedHashString === $postedHashString;
}

public function view_foloosi_invoice()
{
    // dd($id);
    $id='FLSAPIG000C66044cfc409c3';
    $payment = Foloosi::where('transaction_no', $id)
    ->where('status','success')
    ->first();
    // dd($payment);
    // Convert milliseconds to seconds for Carbon
    $originalDateString = $payment->created_at_foloosi ;

    // $formattedDate = $date->format('m/d/Y');
    $formattedDate = Carbon::parse($originalDateString)->format('d/m/Y');
    // dd($formattedDate);
    return view('pages.foloosi_invoice',compact('payment','formattedDate'));
}

public function payment_captured($id)
{
    // $id='FLSAAPI000C6602667188ed6';
    $payment = Foloosi::where('id', $id)
    ->where('status','success')
    ->first();
    return view('pages.payment_captured',compact('payment'));
}

public function customPdfGenerate()
{
   try {

                // $email = $request->input('email');
                $reciept = '108005241936020085';
                // dd($email_demo);
                $result = DB::select("
                    SELECT *
                    FROM all_tap_payment
                    WHERE receipt = ? 
                    ORDER BY date ASC
                    LIMIT 1
                ", [$reciept]);

            

                if (empty($result)) {
                    return response()->json(['message' => 'No records found.','status'=>'error'], 200);
                }

                $row = $result[0];
                
                $name = $row->first_name . ' ' . $row->last_name;
                $email = $row->email;
                $date = $row->date;
                $seconds = $date / 1000; // Convert milliseconds to seconds
                $date_format = date("M-d-Y", $seconds); // Format the date

                // $name = isset($name) ? preg_replace("/[^a-zA-Z0-9\s]/", "", $name) : 'default';
                // $name = str_replace(' ', '_', $name);
                // Concatenate to create the filename
                $filename = 'output.pdf';
                // $filename = $name . 'output.pdf';
                $this->deleteExistingPdf(public_path($filename));
                // dd($date_format);
                $number = $row->country_code . ' ' . $row->number;

                $pdfPath = $this->generatePdf($name, $date_format, $email, $number);
                 
                $pdf_send=$pdfPath->original['pdf_url'];
                // dd($pdf_send);
                $path = public_path('output.pdf');
                // $path = public_path($name.'.pdf');
                
                // dd($path);
                $isExists = File::exists($path);
               
                if ($isExists) {
                      $data["email"] = "tech@fujtown.com";
                     $data["title"] = "fujtrade.com | Contract Letter";
                     $data["client_name"]=$name;
                     $data["client_email"]=$email;
                     $data["client_number"]=$number;
                     $data["client_date"]=$date_format;

                $files = [
                    $path,
                ];
                // dd($files);
                Mail::send('mail.contract_mail', $data, function($message)use($data, $files) {
                    $message->to($data["email"])
                            ->subject($data["title"]);

                    foreach ($files as $file){
                        $message->attach($file);
                    }
            });

                    return response()->json(['message' => 'Email sent successfully','status'=>'success'], 200);
                } else {
                    return response()->json(['message' => 'Failed to create PDF','status'=>'error'], 200);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Internal server error','status'=>'error'], 200);
            }
}

public function custom_view_invoice()
{
    

    // dd('work');
    $recipt='104621241548020360';
    // dd($id);
    $payment = AllTapPaymentAPI::where('receipt', $recipt)
    ->where('status','CAPTURED')
    ->first();
    // dd($payment);
    // Convert milliseconds to seconds for Carbon
    $seconds = $payment->date / 1000;

    // Create a Carbon instance from the timestamp
    $date = Carbon::createFromTimestamp($seconds);

    // Format the date as 'm/d/Y' (e.g., '10/3/2023')
    $formattedDate = $date->format('d/m/Y');

    return view('pages.invoice',compact('payment','formattedDate'));
}

public function invoice_status($ch_id)
{
    // dd($ch_id);
    $details = DB::table('all_tap_payment')
    ->where('ch_id', $ch_id)
    ->select('amount', 'currency', 'ch_id', 'receipt')
    ->first();
    // dd($data);
    return view('pages.invoice_status',compact('details'));
}


public function noonPayment($id)
{
     // $query->where('random_no', $id);
        $payment = NoonPaymentLink::where('random_no', $id)
        ->where('is_expire', '!=', 2)
        ->first();
        // dd($payment);

        if ($payment != null) {
              $amount=$payment->amount;
            $fromCurrency=$payment->currency;
            $toCurrency='AED';
             $formattedAmount = floatval(str_replace(',', '', $amount));
             $formattedAmount = number_format($formattedAmount, 2, '.', '');

        $apiKey = env('CURRENCY_API_KEY');
        $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/pair/{$fromCurrency}/{$toCurrency}/{$formattedAmount}";

             try {
            $response = Http::get($url);
            $data = $response->json();
            // dd($data['conversion_result']);
            $c_amount=$data['conversion_result'];
             $c_amount = number_format($c_amount, 2, '.', '');
            if ($data['result'] === "success") {

                  session([
                    'url_no' => $id,
                    'agentID' => $payment->agentID
                ]);
                
                    // Set 'agentID' in a cookie that expires in 60 minutes
                Cookie::queue('agentID', $payment->agentID, 60);
                Cookie::queue('random_no', $payment->random_no, 60);
            // dd(session('agentID'));
            return view('pages.noon_payment',compact(['payment','c_amount']));
            // dd('this is not a valid payment');
            
            } else {
                return response()->json([
                    'error' => 'Currency conversion error: ' . $data['error-type']
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Fetch error: ' . $e->getMessage()
            ], 500);
        }
        
        
          

        }
        else{
            return response()->view('errors.404', ['message' => 'The link has been expired.'], 404);
        }
}



public function create_noon_link()
{
   $merchant_ref = rand(1, 100000);

    
    //   $url = 'https://api.noonpayments.com/payment/v1/order';
       $url = 'https://api.noonpayments.com/payment/v1/order';
    
    $payload = [
        "apiOperation" => "INITIATE",
        "order" => [
            "reference" => $merchant_ref,
            "amount" => "88.55",
            "currency" => "AED",
            "name" => "Sample order name 2",
            "channel" => "web",
            "category" => "pay"
        ],
        
        "billing"=> [
            
        "contact"=> [
            
            "firstName"=> "John",
            "lastName"=> "Doe",
            "mobilePhone"=> "+971-55-1234567",
            "email"=> "test@domain.com"
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
        'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
        'Content-Type' => 'application/json'
    ])->post($url, $payload);

    $responseData = $response->json();
    if ($response->successful() && $responseData['resultCode'] == 0 && $responseData['result']['order']['status'] == 'INITIATED') {
       
        $paymentUrl = $responseData['result']['checkoutData']['postUrl'];

        return redirect()->away($paymentUrl);
    } else {
        // Handle errors or unsuccessful payment initiation
        $errorMessage = $responseData['message'] ?? 'Unknown error';
        return response()->json([
            'error' => 'Failed to initiate payment',
            'message' => $errorMessage
        ], $response->status());
    }
}

public function noon_response(Request $request)
{
    $noon_id=$request->input('orderId');
    
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
       $url = 'https://api.noonpayments.com/payment/v1/order';
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
                    
                    "address"=> [
                        "street"=> $requestData['customer']['street'],
                        ],    
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
                            'returnUrl' => 'https://www.fujtrade.com/noon_response',
                            'locale' => 'en',
                        ]
            ];
        
            $response = Http::withHeaders([
                'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
                'Content-Type' => 'application/json'
            ])->post($url, $payload);
        
            $responseData = $response->json();
            if ($response->successful() && $responseData['resultCode'] == 0 && $responseData['result']['order']['status'] == 'INITIATED') {
               
                $paymentUrl = $responseData['result']['checkoutData']['postUrl'];
        
                //return redirect()->away($paymentUrl)
                // $agent = $request->cookie('agentID');
                // return response()->json(['success' => true, 'url' => $paymentUrl])->withCookie($agent);
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
           $agent = $request->cookie('agentID');  // Attempt to retrieve 'agentID' from the cookie
           
        //   dd($agent);
            $random_no = $request->cookie('random_no');
            
            // Check if 'agentID' is provided in the query string
            if ($agent !== null) {
                $agentID = $agent;
            } elseif (session('agentID') !== null) {  // Fallback to session if cookie is not set
                $agentID = session('agentID');
            } else {
                $agentID = 1;  // Default value if neither cookie nor session has 'agentID'
            }

        if (!$orderId) {
            return response()->json(['error' => 'orderId is required'], 400);
        }
        
//    $orderId=$request->input('orderId');
      $url = 'https://api.noonpayments.com/payment/v1/order/'.$orderId;
    //   dd($url);
    $response = Http::withHeaders([
        'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
            'Content-Type' => 'application/json'
        ])->get($url);

        if ($response->successful()) {
            $this->save_noon_data($response,$agentID,$random_no);
        }
        else {
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
        
        
        public function save_noon_data($response,$agentID,$random_no)
        {
            // dd($agentID);
           $responseData= $response->json();
           $transactions=$responseData['result']['transactions'][0] ?? null;
           $order=$responseData['result']['order'];
           $billing=$responseData['result']['billing']['contact'];
           $paymentDetails=$responseData['result']['paymentDetails'] ?? null;
           $agentName=$responseData['result']['billing']['address']['street'] ?? 1;
        //   dd($transactions);
             $amount = $order['totalCapturedAmount'] ?? null;
             $currency = $order['currency'];
             $tr_id=$transactions['id'];
            //  dd($tr_id);
             $first_name=$billing['firstName'];
             $last_name =$billing['lastName'];
             $phone=$billing['mobilePhone'];
             $email =$billing['email'];
             $status=$order['status'];
             $date=$transactions['creationTime'];
             
             $dateTime = new DateTime($date);
             $timestampInSeconds = $dateTime->getTimestamp();
             $milliseconds = $timestampInSeconds * 1000 + (int)($dateTime->format('v'));
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
             
             
            //  $agentID =$agentID;
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
                    'date'=>$milliseconds,
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
                    'agentID'=>$agentName,
                    'inv_random_no'=>$random_no,
                    'created_at' => now()
                ];
                

             NoonTransaction::create($pdatas);
             
              $link_no=session('url_no');
                
            if($status=='CAPTURED'){
                // dd($link_no);
                   $ldata=[
                'link_no'=>$link_no,
                'transaction_id'=>$tr_id,
                'status'=>$status,
                'link_payment'=>'NOON'
                ];    
                
                 LinkStatus::create($ldata);
                // dd($ldata);
                
                $customerName = $first_name . " " . $last_name; // Concatenate first name and last name
                $kycStatus = 1; // Setting status to 1
            
                // Check if a CustomerKYC record exists for this invoice_no
                $customerKYC = CustomerKycStatus::firstOrNew(['temp_invoice_no' => $link_no]);
                $customerKYC->customer_name = $customerName;
                $customerKYC->customer_email = $email;
                $customerKYC->customer_phone = $phone;
                $customerKYC->status = 'success';
                $customerKYC->save();
                
                 $customerKYC2 = CustomerKyc::firstOrNew(['invoice_no' => $link_no]);
                  $customerKYC2->customer_name = $customerName;
                  $customerKYC2->status = 1;
                  $customerKYC2->save();
                  
                NoonPaymentLink::where('random_no', $link_no)->update(['is_expire' => 2]);
                // First, check if a customer with the given email already exists
                $existingCustomer = Customer::where('email', $email)->first();
                 $customerSignData = TempHoldCustomerSign::where('customer_email', $email)->first();
                if (!$existingCustomer) {
                    
                     // Check if the customer sign data exists
            if ($customerSignData) {
                // Get the customer sign from the retrieved data
                $customerSign = $customerSignData->customer_sign;
            }
            
                    // If no existing customer, generate a random password
                    $randomPassword = rand(10000000, 99999999); // Generate an 8-digit random number for the password
                    
                    // Prepare customer data
                    $cdatas = [
                        'fname' => $first_name,
                        'lname' => $last_name,
                        'username' => $first_name . $last_name, // Consider adding a separator or handling potential username clashes
                        'email' => $email,
                        'phone' => $phone,
                        'password' => Hash::make($randomPassword), // Encrypt the password
                        'photo' => 'default.png',
                        'customer_sign'=>$customerSign,
                        'account_ctype' => 'Payment_success',
                    ];

                    // Create a new customer record
                    $customer =  Customer::create($cdatas);
                    $lastInsertedId = $customer->id;
                    // Prepare the email data
                    $mdata = [
                        'email' => $email, // Recipient's email
                        'title' => 'Welcome to Fujtrade!',
                        'link' => url('/confirm',$lastInsertedId ),
                        'password' => $randomPassword // Assuming you want to send the password in the email
                    ];

                    // Send the welcome email
                    $this->sendWelcomeEmail($mdata['email'], $mdata['link'], $mdata['email'], $mdata['password']);

                    // Mail::send('mail.welcome_mail', $mdata, function($message) use ($mdata) {
                    //     $message->to($mdata['email'])->subject($mdata['title']);
                    // });

                    $this->generateClientPdf($email);
                }
                else{
                     // Check if the customer sign data exists
                    if ($customerSignData) {
                        // Get the customer sign from the retrieved data
                        $customerSign = $customerSignData->customer_sign;
        
                        // Update the customer's customer_sign column
                        $existingCustomer->customer_sign = $customerSign;
                        $existingCustomer->save();
                    }
                      $this->generateClientPdf($email);
                }
                
                    // Clear the session item
                    session()->forget('agentID');
                    
                    // Clear the cookie by queuing a cookie deletion
                    Cookie::queue(Cookie::forget('agentID'));
                    Cookie::queue(Cookie::forget('random_no'));
            }
            else{
                $expireSum = NoonPaymentLink::where('random_no', $link_no)
                ->sum('is_expire');
                $expireSum +=1;
                NoonPaymentLink::where('random_no', $link_no)->update(['is_expire' => $expireSum]);
            }
            // Use Storage facade to save data to a file in the local storage
            // Storage::disk('local')->put($filePath, $content);
            
            
              return response()->json(['success' => true, 'data' => $responseData]);  
            }
            else {
                return response()->json(['success' => false, 'error' => 'Record with Transaction_id already exists.']);
            }
          
            //  return response()->json(['message' => ''], 200);
            
            //$message='Payment Captured Succesfully..';
            
        
        }
       public function get_noon_last_payment(Request $request)
        {
             $noon_id = $request->query('noon_id');

            if (!$noon_id) {
                return response()->json(['error' => 'noon_id is required'], 400);
            }

            try {
                // $secretKey = env('TAP_PAYMENT_SECRET');
                 $url = 'https://api.noonpayments.com/payment/v1/order/'.$noon_id;

    $response = Http::withHeaders([
        'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
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
        
         public function test_noon_api(Request $request)
        {
             $noon_id = 790675964801;

            if (!$noon_id) {
                return response()->json(['error' => 'noon_id is required'], 400);
            }

            try {
                
               
                // $secretKey = env('TAP_PAYMENT_SECRET');
                 $url = 'https://api.noonpayments.com/payment/v1/order/'.$noon_id;
                //   $url = 'https://api-test.noonpayments.com/payment/v1/order/'.$noon_id;
    $response = Http::withHeaders([
             'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
            'Content-Type' => 'application/json'
        ])->get($url);
       
        // $response = Http::withHeaders([
        //     'Authorization' => 'Key_Test ZnVqdG93bi5mdWp0cmFkZTo4MDMzMGFhY2RiNmU0M2MyYmE1OTIzMzI0MzE1MDI2OA==',
        //     'Content-Type' => 'application/json'
        // ])->get($url);
         dd($response);
        if ($response->successful()) {
           $responseData= $response->json();
            // dd($responseData);
           $transactions=$responseData['result']['transactions'][0] ?? null;
           $order=$responseData['result']['order'];
           $billing=$responseData['result']['billing']['contact'];
           $agentName=$responseData['result']['billing']['address']['street'] ?? null;
        //   dd($agentName['street']);
           $paymentDetails=$responseData['result']['paymentDetails'] ?? null;
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
             
             $dateTime = new DateTime($date);
             $timestampInSeconds = $dateTime->getTimestamp();
             $milliseconds = $timestampInSeconds * 1000 + (int)($dateTime->format('v'));
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
             $agentID=10;
             $random_no=379013;
            
                 $pdatas = [
                    'tr_id'=>$tr_id,
                    'amount' => $amount,
                    'currency'=>$currency,
                    'first_name'=>$first_name,
                    'last_name'=>$last_name,
                    'phone'=>$phone,
                    'email'=>$email,
                    'status'=>$status,
                    'date'=>$milliseconds,
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
                    'agentID'=>$agentName,
                    'inv_random_no'=>$random_no,
                    'created_at' => now()
                ];
                
                
                
            //  
             NoonTransaction::create($pdatas);
        //   dd('work');
        }
         return response()->json(['success' => 'Data Save Successfully', 'status' => $status]);

        }catch (\Exception $e) {
            Log::error("Error fetching payment data: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
        }
        
        
        public function noonhook(Request $request)
{
    $noon_id = $request->input('order_id'); // Get the order ID from the webhook payload

    try {
        $url = 'https://api.noonpayments.com/payment/v1/order/' . $noon_id;
        $response = Http::withHeaders([
            'Authorization' =>'Key_Live ' . env('API_AUTH_KEY'),
            'Content-Type' => 'application/json'
        ])->get($url);

        if ($response->successful()) {
            $responseData = $response->json();

            // Extract necessary data
            $transactions = $responseData['result']['transactions'][0] ?? null;
            $order = $responseData['result']['order'];
            $billing = $responseData['result']['billing']['contact'];
            $paymentDetails = $responseData['result']['paymentDetails'] ?? null;

            $tr_id = $transactions['id'] ?? null;
            $amount = $order['totalCapturedAmount'];
            $currency = $order['currency'];
            $first_name = $billing['firstName'];
            $last_name = $billing['lastName'];
            $phone = $billing['mobilePhone'];
            $email = $billing['email'];
            $status = $order['status'];
            $date = $transactions['creationTime'];

            // Convert the date to timestamp in milliseconds
            $dateTime = new DateTime($date);
            $timestampInSeconds = $dateTime->getTimestamp();
            $milliseconds = $timestampInSeconds * 1000 + (int)($dateTime->format('v'));

            $reference = $order['reference'];
            $mode = $paymentDetails['mode'];
            $intAccount = $paymentDetails['integratorAccount'];
            $paymentInfo = $paymentDetails['paymentInfo'];
            $brand = $paymentDetails['brand'];
            $expiryMonth = $paymentDetails['expiryMonth'];
            $expiryYear = $paymentDetails['expiryYear'];
            $cardCountry = $paymentDetails['cardCountry'] ?? 'Card Country';
            $cardCountryName = $paymentDetails['cardCountryName'] ?? 'Default Country';
            $cardIssuerName = $paymentDetails['cardIssuerName'] ?? 'Default Value';
            $agentID = 10; // Default agent ID
            $random_no = 379013; // Default random number

            // Check if the tr_id already exists in the database
            $existingTransaction = NoonTransaction::where('tr_id', $tr_id)->first();

            if (!$existingTransaction) {
                // Create the data to be saved in the database
                $pdatas = [
                    'tr_id' => $tr_id,
                    'amount' => $amount,
                    'currency' => $currency,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'phone' => $phone,
                    'email' => $email,
                    'status' => $status,
                    'date' => $milliseconds,
                    'reference' => $reference,
                    'mode' => $mode,
                    'intAccount' => $intAccount,
                    'paymentInfo' => $paymentInfo,
                    'brand' => $brand,
                    'expiryMonth' => $expiryMonth,
                    'expiryYear' => $expiryYear,
                    'cardCountry' => $cardCountry,
                    'cardCountryName' => $cardCountryName,
                    'cardIssuerName' => $cardIssuerName,
                    'agentID' => $agentID,
                    'inv_random_no' => $random_no,
                    'created_at' => now(),
                ];

                // Save data to the database
                NoonTransaction::create($pdatas);

                return response()->json(['success' => 'Data Saved Successfully', 'status' => $status]);
            } else {
                // Transaction already exists
                return response()->json(['message' => 'Transaction already exists', 'status' => $existingTransaction->status]);
            }
        } else {
            return response()->json(['error' => 'Unable to fetch order data from Noon API'], 500);
        }
    } catch (\Exception $e) {
        Log::error("Error fetching payment data: " . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}


public function networkPayment($id)
{
    // $query->where('random_no', $id);
    $payment = NetworkIntLink::where('random_no', $id)
    ->where('is_expire', '!=', 2)
    ->first();

    if ($payment != null) {
        session(['url_no' => $id]);
        return view('pages.networkpayment',compact('payment'));
        // dd('this is not a valid payment');

    }
    else{
        return response()->view('errors.404', ['message' => 'The link has been expired.'], 404);
    }
}



        
        public function testCode(Request $request)
        {
           $agent = $request->cookie('agentID');  // Attempt to retrieve 'agentID' from the cookie
            $random_no = $request->cookie('random_no');
            
            // Check if 'agentID' is provided in the query string
            if ($agent !== null) {
                $agentID = $agent;
            } elseif (session('agentID') !== null) {  // Fallback to session if cookie is not set
                $agentID = session('agentID');
            } else {
                $agentID = 1;  // Default value if neither cookie nor session has 'agentID'
            }
            
            dd($agentID);
        }
        
        
        

}
