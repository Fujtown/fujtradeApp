<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
class NetworkPaymentService
{
    protected $apiKey;
    protected $baseUrl;
    protected $outletReference;

    public function __construct()
    {
        $this->apiKey = env('NETWORK_INI_OUTLET_REFERENCE');
        $this->baseUrl = 'https://api-gateway.sandbox.ngenius-payments.com';
        $this->outletReference = env('NETWORK_INI_API_KEY');

    }

    public function getAccessToken()
    {
        try {
            $secretKey = env('NETWORK_INI_OUTLET_REFERENCE');
            $client = new Client();
            //https://api-gateway.ngenius-payments.com/identity/auth/access-token
            //https://api-gateway.sandbox.ngenius-payments.com/identity/auth/access-token
            $response = $client->post('https://api-gateway.ngenius-payments.com/identity/auth/access-token', [
                'headers' => [
                    'Content-Type' => 'application/vnd.ni-identity.v1+json',
                    'Authorization' => 'Basic '. $secretKey
                ]
            ]);
            // dd('work');

                // Decode the response body to access the JSON
        $responseBody = json_decode($response->getBody()->getContents(), true);
            // dd($responseBody);
        // Check if the access_token exists and return it
        if (isset($responseBody['access_token'])) {
            return $responseBody['access_token'];
        } else {
            Log::error('No access_token found in the response');
            return response()->json(['error' => 'No access_token found'], 500);
        }

        } catch (\Exception $e) {
            Log::error('Error creating charge: '.$e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }


    }
    public function createInvoice($invoiceData)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Unable to retrieve access token',
            ];

        }
        // dd('work');
        dd($invoiceData);

        try {

            $json = json_encode($invoiceData);
            $ch = curl_init();

            $outlet = $this->outletReference;
            dd($outlet);
            //https://api-gateway.ngenius-payments.com/transactions/outlets/

            curl_setopt($ch, CURLOPT_URL, "https://api-gateway.ngenius-payments.com/transactions/outlets/".$outlet."/orders");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer " . $accessToken,
                "Content-Type: application/vnd.ni-payment.v2+json",
                "Accept: application/vnd.ni-payment.v2+json",
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

            $output = json_decode(curl_exec($ch));
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            dd($output);

            if ($httpCode == 201) {
                $orderReference = $output->reference;
                $orderPayPageUrl = $output->_links->payment->href;

                return [
                    'success' => true,
                    'order_reference' => $orderReference,
                    'payment_url' => $orderPayPageUrl,
                ];
            } else {
                Log::error('Failed to create order: ' . json_encode($output));
                return [
                    'success' => false,
                    'message' => 'Failed to create order',
                    'details' => $output,
                ];
            }

        } catch (\Exception $e) {
            Log::error('Error creating invoice: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while creating the invoice',
            ];
        }
    }

    public function createOrder($data)
{
    dd($data);
    // First, get the access token
    $accessToken = $this->getAccessToken();
   
    if (!$accessToken) {
        return [
            'success' => false,
            'message' => 'Unable to retrieve access token',
        ];
    }

    $postData = new \StdClass();
    $postData->action = "SALE";
    $postData->amount = new \StdClass();

    $postData->amount->currencyCode = $data->currency;
    $postData->amount->value = $data->amount * 100; // Assuming amount is provided in standard units, not minor units.
    $postData->emailAddress=$data->customer->email;
    // Assuming amount is provided in standard units, not minor units.
    $postData->merchantAttributes  = new \StdClass();
   $postData->merchantAttributes->redirectUrl = 'https://www.fujtek.com/our-work/ej_education/public/packages/network_success';
    $postData->merchantAttributes->cancelUrl = 'https://www.fujtek.com/our-work/ej_education/public/packages/network_cancel';


    $postData->merchantAttributes->skipConfirmationPage = true;
    $postData->paymentAttempts=3;

    $postData->billingAddress  = new \StdClass();
    $postData->billingAddress->firstName    =$data->customer->firstName;
    $postData->billingAddress->lastName     =$data->customer->lastName;
    $postData->billingAddress->address1     =$data->address->country .' ,' .$data->address->city;
    $postData->billingAddress->city         =$data->address->city;
    $postData->billingAddress->countryCode  =$data->address->country;

    $json = json_encode($postData);
    $ch = curl_init();

    $outlet = $this->outletReference; // Ensure this is set in your class

    curl_setopt($ch, CURLOPT_URL, "https://api-gateway.ngenius-payments.com/transactions/outlets/" . $outlet . "/orders");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $accessToken,
        "Content-Type: application/vnd.ni-payment.v2+json",
        "Accept: application/vnd.ni-payment.v2+json"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    $output = json_decode(curl_exec($ch));
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // dd($output);
    if ($httpCode == 201) {
        $orderReference = $output->reference;
        $orderPayPageUrl = $output->_links->payment->href;
          // Save the orderReference in the session
          session(['order_reference' => $orderReference]);
        return [
            'success' => true,
            'order_reference' => $orderReference,
            'payment_url' => $orderPayPageUrl,
        ];
    } else {
        Log::error('Failed to create order: ' . json_encode($output));
        return [
            'success' => false,
            'message' => 'Failed to create order',
            'details' => $output,
        ];
    }
}

public function getOrderStatus($orderReference)
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'success' => false,
                'message' => 'Unable to retrieve access token',
            ];
        }

        try {
            $client = new Client();
            $url = $this->baseUrl . '/transactions/outlets/' . $this->outletReference . '/orders/' . $orderReference;

            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Accept' => 'application/vnd.ni-payment.v2+json',
                ],
            ]);

            if ($response->getStatusCode() == 200) {
                $responseBody = json_decode($response->getBody()->getContents(), true);
                return [
                    'success' => true,
                    'data' => $responseBody,
                ];
            } else {
                Log::error('Failed to retrieve order status: ' . $response->getBody()->getContents());
                return [
                    'success' => false,
                    'message' => 'Failed to retrieve order status',
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error retrieving order status: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while retrieving the order status',
            ];
        }
    }

}
