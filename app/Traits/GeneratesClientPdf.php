<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CustomerPdf;
use App\Models\TempHoldCustomerSign;
trait GeneratesClientPdf
{
    public function generateClientPdf($email)
    {
        try {
            $email_demo = $email;
            $status = 'CAPTURED';

             // Initial query to all_tap_payment table
                $result = DB::select("
                SELECT *
                FROM all_tap_payment
                WHERE email = ? AND status = ?
                ORDER BY date DESC
                LIMIT 1
            ", [$email_demo, $status]);

            // If the initial query returns empty, query the payment_by_link table
            if (empty($result)) {
                $result = DB::select("
                    SELECT *
                    FROM payment_by_link
                    WHERE email = ? AND status = ?
                    ORDER BY date DESC
                    LIMIT 1
                ", [$email_demo, $status]);

                // If the secondary query also returns empty, throw an exception
                if (empty($result)) {
                    throw new \Exception('No data found.');
                }
            }

            $row = $result[0];
            $name = $row->first_name . ' ' . $row->last_name;
            $email = $row->email;
            $d_date = $row->date;
            $seconds = $d_date / 1000;
            $date = date("M-d-Y", $seconds);
            $phone = $row->country_code . ' ' . $row->number;
            
                $customerSignData = TempHoldCustomerSign::where('customer_email', $email)
        ->orderBy('id', 'desc')
        ->first();
            
            if ($customerSignData) {
                // Get the customer sign from the retrieved data
                $customerSign = $customerSignData->customer_sign;
            }
            
            $pdf = PDF::loadView('pdf_template', compact('name', 'date', 'email', 'phone','customerSign'));
            $filename = 'PDF_' . str_replace(' ', '_', $name) . '_' . date('Y-m-d') . '.pdf';
            $pdf->save(public_path('pdf/' . $filename));
            $pdfUrl = asset('pdf/' . $filename);

            CustomerPdf::create([
                'email' => $email,
                'pdf_url' => $pdfUrl,
            ]);

            $data = [
                "email" => "tech@fujtown.com",
                "title" => "fujtrade.com | Contract Letter",
                "client_name" => $name,
                "client_email" => $email,
                "client_number" => $phone,
                "client_date" => $date,
            ];

            $path = public_path('pdf/' . $filename);
            $files = [$path];

            $this->sendAgreementEmail($data, $files);


            // Mail::send('mail.contract_mail', $data, function($message) use ($data, $files) {
            //     $message->to($data["email"])->subject($data["title"]);

            //     foreach ($files as $file) {
            //         $message->attach($file);
            //     }
            // });

            Log::info('PDF generated and saved: ' . $filename);
            return response()->json(['pdf_url' => $pdfUrl]);
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['message' => 'Error generating PDF', 'status' => 'error'], 200);
        }
    }
    
      public function generateFoloosiClientPdf($email)
    {
        try {
            $email_demo = $email;
            $status = 'success';
            // dd($email_demo);

             // Initial query to all_tap_payment table
                $result = DB::select("
                SELECT *
                FROM foloosis
                WHERE customer_email = ? AND status = ?
                ORDER BY created_at_foloosi DESC
                LIMIT 1
            ", [$email_demo, $status]);
            
            $row = $result[0];
            
            $name = $row->customer_name;
            $email = $row->customer_email;
            
            $d_date = $row->created_at_foloosi;
            // Convert the date string to a timestamp
            $timestamp = strtotime($d_date);
            
            // Now you can use the timestamp with the date() function
            $date = date("M-d-Y", $timestamp);

            // dd($date);
            $phone = $row->customer_phone_number;
            
            $pdf = PDF::loadView('pdf_template', compact('name', 'date', 'email', 'phone'));
            
            $filename = 'PDF_' . str_replace(' ', '_', $name) . '_' . date('Y-m-d') . '.pdf';
           
            // Log::info('File Name: ' . $pdf);
            $pdf->save(public_path('pdf/' . $filename));
            $pdfUrl = asset('pdf/' . $filename);
            // dd($pdfUrl);
            // Log::info('File Name & path: ' . $filename);
            CustomerPdf::create([
                'email' => $email,
                'pdf_url' => $pdfUrl,
            ]);
            
            

            $data = [
                "email" => "tech@fujtown.com",
                "title" => "fujtrade.com | Contract Letter",
                "client_name" => $name,
                "client_email" => $email,
                "client_number" => $phone,
                "client_date" => $date,
            ];

            $path = public_path('pdf/' . $filename);
            $files = [$path];

            $this->sendAgreementEmail($data, $files);


            // Mail::send('mail.contract_mail', $data, function($message) use ($data, $files) {
            //     $message->to($data["email"])->subject($data["title"]);

            //     foreach ($files as $file) {
            //         $message->attach($file);
            //     }
            // });

            Log::info('PDF generated and saved: ' . $filename);
            return response()->json(['pdf_url' => $pdfUrl]);
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['message' => 'Error generating PDF', 'status' => 'error'], 200);
        }
    }
}
