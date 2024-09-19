<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\TapPayment;
class FetchAndSaveData extends Command
{
    protected $signature = 'fetch:save-data';
    protected $description = 'Fetch and save data from Tap API';

    public function handle()
{
    $client = new Client();

    $lastId = null;

    while (true) {
        $requestBody = [
            'period' => ['date' => ['from' => '', 'to' => ''], 'type' => '1'],
            'limit' => '50',
        ];

        if ($lastId) {
            $requestBody['starting_after'] = $lastId;
        }

        try {
            $response = $client->post('https://api.tap.company/v2/charges/list', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('TAP_PAYMENT_SECRET'),
                ],
                'json' => $requestBody
            ]);
            $apiData = json_decode((string) $response->getBody(), true);

            foreach ($apiData['charges'] as $charge) {
                $paymentExists = TapPayment::where('ch_id', $charge['id'])->exists();

                if (!$paymentExists) {
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
                        'created_at' => now(),
                    ]);
                }
            }

            if (!empty($apiData['charges']) && $apiData['has_more']) {
                $lastId = end($apiData['charges'])['id'];
            } else {
                break;
            }
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            break;
        }
    }

    $this->info('Data fetched and saved/updated successfully');
}

}
