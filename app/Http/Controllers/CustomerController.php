<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\RefundRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CustomerPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\AllTapPaymentAPI;
use App\Models\PaymentByLink;
use App\Traits\GeneratesClientPdf;
class CustomerController extends Controller
{
    use GeneratesClientPdf; // Use the trait in your controller
    public function profile()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }
    public function account()
    {
        $user = Auth::user();
        return view('pages.account',compact('user'));
    }

    // public function refund_request()
    // {
    //     $user = Auth::user();
    //     return view('pages.refund_request',compact('user'));
    // }
    public function save_customer(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:customers',
            'phone' => 'required',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // Handle the data
        $customer = new Customer();
        $customer->fname = $request->fname;
        $customer->lname = $request->lname;
        $customer->username = $request->username;
        $customer->email = $request->email;
        $customer->phone = $request->country_code.$request->phone;
        $customer->password = bcrypt($request->password);
        $customer->photo = 'default.png';
        $customer->account_ctype = 'website';
        // dd($customer);
        $customer->fill($validated);
        $customer->save();

        // $this->generateClientPdf($request->email);
        $this->generateClientPdf($request->email); // Call the method from the trait

        return response()->json(['success' => 'Message sent successfully']);
    }

    public function update_customer(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            // Validate other fields as necessary
        ]);

          // Check if a profile photo has been uploaded
          if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = 'profile_photo_' . $user->id . '.' . $file->getClientOriginalExtension();

             // Store the file in the 'public/assets/profile_photos' directory
             $destinationPath = public_path('assets/profile_photos');
             $file->move($destinationPath, $filename);

             // Update the user's profile photo path in the database
            $user->photo =$filename;
        }
        else{
            $user->photo ='default.png';
        }


         $user->update($validatedData);

        // Add logic to handle profile image upload if necessary
        return response()->json(['message' => 'Profile updated successfully']);
    }

    public function change_password(Request $request)
    {
        // Validate the form data
        $validator = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Your current password is incorrect.']]], 422);
        }

        // Change the password
         $user->password = bcrypt($request->new_password);

        $user->save();

        return response()->json(['success' => 'Password changed successfully.']);
    }

    public function login_customer(Request $request)
    {
            $validated = $request->validate([
                'email'=> 'required',
                'password'=> 'required',
                ]);

            // Attempt to log the user in
            $credentials = $request->only('email', 'password');

            if (Auth::guard('web')->attempt($credentials)) {
                return response()->json(['message' => 'Successfully logged in']);
            }

            // If login attempt was unsuccessful
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
    }


    // public function generateClientPdf($email)
    // {
    //     try {

    //         $email_demo = $email;
    //         $status = 'CAPTURED';
    //         // dd($email_demo);

    //         $result = DB::select("
    //         SELECT *
    //         FROM all_tap_payment
    //         WHERE email = ? AND status = ?
    //         ORDER BY date DESC
    //         LIMIT 1
    //     ", [$email_demo, $status]);

    //     $row = $result[0];
    //     // dd('work');
    //             $name = $row->first_name . ' ' . $row->last_name;

    //             $email = $row->email;

    //             $d_date = $row->date;
    //             //
    //             $seconds = $d_date / 1000; // Convert milliseconds to seconds
    //             $date = date("M-d-Y", $seconds); // Format the date
    //             $phone = $row->country_code . ' ' . $row->number;

    //         $pdf = PDF::loadView('pdf_template', compact('name', 'date', 'email', 'phone'));



    //         $pdfContent = $pdf->output();
    //         $filename = 'PDF_' . str_replace(' ', '_', $name) . '_' . date('Y-m-d') . '.pdf';
    //         $pdf->save(public_path('pdf/' . $filename));
    //         $pdfUrl = asset('pdf/' . $filename);

    //          // Save PDF URL and customer email in the database
    //             CustomerPdf::create([
    //                 'email' => $email,
    //                 'pdf_url' => $pdfUrl,
    //             ]);

    //             $data["email"] = "tech@fujtown.com";
    //             $data["title"] = "fujtrade.com | Contract Letter";
    //             $data["client_name"]=$name;
    //             $data["client_email"]=$email;
    //             $data["client_number"]=$phone;
    //             $data["client_date"]=$date;
    //             $path = public_path('pdf/' . $filename);
    //        $files = [
    //            $path,
    //        ];
    //        // dd($files);
    //        Mail::send('mail.contract_mail', $data, function($message)use($data, $files) {
    //         $message->to($data["email"])
    //                 ->subject($data["title"]);

    //                 foreach ($files as $file){
    //                     $message->attach($file);
    //                 }
    //         });

    //             // dd('work');
    //         Log::info('PDF generated and saved: ' . public_path($filename));
    //         return response()->json(['pdf_url' => asset($filename)]);
    //     } catch (\Exception $e) {
    //         // Handle any exceptions that may occur during PDF generation
    //         Log::error('Error generating PDF: ' . $e->getMessage());

    //         // Return an error response if needed
    //         return response()->json(['message' => 'Error generating PDF','status'=>'error'], 200);
    //     }
    // }

    public function get_record_by_client(Request $request)
    {
        // Retrieve the email from query parameters
        $email = $request->email;
        // Query the most recent payment record for the given email
        $payment = AllTapPaymentAPI::where('email', $email)
                                ->where('status','CAPTURED')
                                ->orderByDesc('date') // Assuming 'created_at' is your timestamp column
                                ->get(); // Gets the most recent record

        if (!$payment) {
            return response()->json(['message' => 'No payment record found for the provided email.'], 404);
        }


        return response()->json($payment);
    }

    public function download_client_agreement(Request $request)
    {
    // Retrieve the email from query parameters
        $email = $request->email;
         // Query the most recent payment record for the given email
         $agreement = CustomerPdf::where('email', $email)
                                 ->first(); // Gets the most recent record

         if (!$agreement) {
             return response()->json(['message' => 'No Agreement record found for the provided email.'], 404);
         }

         return response()->json($agreement);
    }

    // public function send_refund_request(Request $request)
    // {
    //     $customer_name = $request->input('first_name').' '.$request->input('last_name');
    //     $email = $request->input('email');
    //     $phone = $request->input('phone');
    //     $refund_amount = $request->input('refund_amount');
    //     $user = Auth::guard('admin')->user();
    //     $user_type='customer';
    //     $user_id = $user->id;

    //     RefundRequest::create([
    //         'customer_name' => $customer_name,
    //         'email' => $email,
    //         'phone' => $phone,
    //         'refund_amount' => $refund_amount,
    //         'agentID' => $user_id,
    //         'user_type' => $user_type,
    //     ]);

    //     // Redirect or return a response
    //     return response()->json([
    //         'success' => 'Refund Request created successfully.'
    //     ]);
    // }


    public function logout(Request $request){

        Auth::logout();
          // Invalidate the session.
          $request->session()->invalidate();

          // Regenerate the session token to prevent CSRF attacks.
          $request->session()->regenerateToken();

          // Redirect to home page or login page.
          return redirect('/home');
    }
}
