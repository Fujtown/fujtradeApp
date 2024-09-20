<?php

namespace App\Http\Controllers;

use App\Services\NetworkPaymentService;
use Illuminate\Http\Request;

class NetworkIntPaymentController extends Controller
{
    protected $networkService;

    public function __construct(NetworkPaymentService $networkService)
    {
        $this->networkService = $networkService;
    }

    public function createNetworkCharge(Request $request)
{
    $requestData = $request->all();
    $signatureImageBase64 = $requestData['signature_image'];
    unset($requestData['signature_image']);

    
    // dd($requestData);
    
    // $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
    //     $imageName = 'signature_' . time() . '.png';
  
    //     $signatureImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureImageBase64));
    //     $imageName = 'signature_'.$requestData['customer']['first_name']. time() . '.png';
    //     $path = public_path('signature/' . $imageName);
    //     file_put_contents($path, $signatureImage);

    //     $temp_data['customer_name'] = $requestData['customer']['first_name'] .' '.$requestData['customer']['last_name'];
    //      $temp_data['customer_email'] = $requestData['customer']['email'];
    //       $temp_data['customer_sign'] = $imageName;

     
    //     TempHoldCustomerSign::create($temp_data);
    $result = $this->networkService->createOrder($requestData);
    if ($result['success']) {
        return response()->json(['success' => true, 'url' => $result['payment_url']]);
    } else {
        return response()->json(['success' => false, 'message' => $result['message']], 500);
    }
}
}
