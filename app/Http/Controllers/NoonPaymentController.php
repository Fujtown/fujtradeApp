<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\NoonTransaction;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use DateTime;
class NoonPaymentController extends Controller
{
    public function noon_api(Request $request)
    {
        $noon_id = $request->input('noon_id');
    
        // dd($noon_id);
        if (!$noon_id) {
            return response()->json(['error' => 'noon_id is required'], 400);
        }

        try {
            $url = 'https://api.noonpayments.com/payment/v1/order/'.$noon_id;
            
            $response = Http::withHeaders([
                'Authorization' => 'Key_Live ZnVqdG93bi5mdWp0cmFkZToxMjNmM2FjNmFkYmE0NDFlODk5YWQ5ZmY4NjZiNWI2YQ==',  // Ensure this is set correctly in your .env
                'Content-Type' => 'application/json'
            ])->get($url);
            // dd($response);
            if ($response->successful()) {
                $responseData = $response->json();
                $transactions = $responseData['result']['transactions'][0] ?? null;
                $order = $responseData['result']['order'];
                $billing = $responseData['result']['billing']['contact'];
                $paymentDetails = $responseData['result']['paymentDetails'] ?? null;

                $amount = $order['totalCapturedAmount'];
                $currency = $order['currency'];
                $tr_id = $transactions['id'];
                $first_name = $billing['firstName'];
                $last_name = $billing['lastName'];
                $phone = $billing['mobilePhone'];
                $email = $billing['email'];
                $status = $order['status'];
                $date = $transactions['creationTime'];

                $dateTime = new DateTime($date);
                $milliseconds = $dateTime->getTimestamp() * 1000 + (int)($dateTime->format('v'));

                // Prepare the data to save
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
                    'message' => $order['name'],
                    'reference' => $order['reference'],
                    'mode' => $paymentDetails['mode'] ?? null,
                    'intAccount' => $paymentDetails['integratorAccount'] ?? null,
                    'paymentInfo' => $paymentDetails['paymentInfo'] ?? null,
                    'brand' => $paymentDetails['brand'] ?? null,
                    'expiryMonth' => $paymentDetails['expiryMonth'] ?? null,
                    'expiryYear' => $paymentDetails['expiryYear'] ?? null,
                    'cardCountry' => $paymentDetails['cardCountry'] ?? 'Unknown Country',
                    'cardCountryName' => $paymentDetails['cardCountryName'] ?? 'Unknown Country Name',
                    'cardIssuerName' => $paymentDetails['cardIssuerName'] ?? 'Unknown Issuer',
                    'agentID' => $billing['address']['street'] ?? null,
                    'inv_random_no' => 379013,  // Example value
                    'created_at' => now(),
                ];

                // Save the transaction to the database
                NoonTransaction::create($pdatas);

                return response()->json(['success' => 'Data Saved Successfully', 'status' => $status]);
            }

            return response()->json(['error' => 'Unable to fetch order data'], 400);

        } catch (\Exception $e) {
            Log::error("Error fetching payment data: " . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
