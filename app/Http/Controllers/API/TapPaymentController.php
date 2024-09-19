<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AllTapPaymentAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerPdf;
use Illuminate\Support\Facades\Mail;
class TapPaymentController extends Controller
{
    public function index(Request $request)
    {

        // Retrieve the email from query parameters
        $email = $request->query('email');

        // Query the most recent payment record for the given email
        $payment = AllTapPaymentAPI::where('email', $email)
                                ->orderByDesc('date') // Assuming 'created_at' is your timestamp column
                                ->first(); // Gets the most recent record

        if (!$payment) {
            return response()->json(['message' => 'No payment record found for the provided email.'], 404);
        }

        return response()->json($payment);
    }

    public function generatePdf(Request $request)
    {
        try {

            $email_demo = $request->query('email');
            $status = 'CAPTURED';
            // dd($email_demo);

            $result = DB::select("
            SELECT *
            FROM all_tap_payment
            WHERE email = ? AND status = ?
            ORDER BY date DESC
            LIMIT 1
        ", [$email_demo, $status]);

        $row = $result[0];
        // dd('work');
                $name = $row->first_name . ' ' . $row->last_name;

                $email = $row->email;

                $d_date = $row->date;
                //
                $seconds = $d_date / 1000; // Convert milliseconds to seconds
                $date = date("M-d-Y", $seconds); // Format the date
                $phone = $row->country_code . ' ' . $row->number;

            $pdf = PDF::loadView('pdf_template', compact('name', 'date', 'email', 'phone'));



            $pdfContent = $pdf->output();
            $filename = 'PDF_' . str_replace(' ', '_', $name) . '_' . date('Y-m-d') . '.pdf';
            $pdf->save(public_path('pdf/' . $filename));
            $pdfUrl = asset('pdf/' . $filename);

             // Save PDF URL and customer email in the database
                CustomerPdf::create([
                    'email' => $email,
                    'pdf_url' => $pdfUrl,
                ]);

                $data["email"] = "tech@fujtown.com";
                $data["title"] = "fujtrade.com | Contract Letter";
                $data["client_name"]=$name;
                $data["client_email"]=$email;
                $data["client_number"]=$phone;
                $data["client_date"]=$date;
                $path = public_path('pdf/' . $filename);
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

                // dd('work');
            Log::info('PDF generated and saved: ' . public_path($filename));
            return response()->json(['pdf_url' => asset($filename)]);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during PDF generation
            Log::error('Error generating PDF: ' . $e->getMessage());

            // Return an error response if needed
            return response()->json(['message' => 'Error generating PDF','status'=>'error'], 200);
        }
    }

    public function downloadAgreement(Request $request)
    {
              // Retrieve the email from query parameters
              $email = $request->query('email');

              // Query the most recent payment record for the given email
              $agreement = CustomerPdf::where('email', $email)
                                      ->first(); // Gets the most recent record

              if (!$agreement) {
                  return response()->json(['message' => 'No Agreement record found for the provided email.'], 404);
              }

              return response()->json($agreement);
    }
}
