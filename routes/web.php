<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\API\TapPaymentController;
use App\Http\Controllers\NetworkIntPaymentController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/noonhook', [HomeController::class, 'noonhook'])->name('noonhook');
Route::get('/test_code', [HomeController::class, 'testCode'])->name('testcode');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/create_noon_link', [HomeController::class, 'create_noon_link']);
Route::get('/noon_response', [HomeController::class, 'noon_response']);
Route::get('/noon-payment/{id}', [HomeController::class, 'noonPayment'])->name('noon-payment');

Route::get('/network-payment/{id}', [HomeController::class, 'networkPayment'])->name('network-payment');

Route::get('/foloosi-payment/{id}', [HomeController::class, 'preparePayment'])->name('foloosi-payment');
Route::get('/test_payment_api', [HomeController::class, 'test_payment_api'])->name('test_payment_api');
Route::get('/test_noon_api', [HomeController::class, 'test_noon_api'])->name('test_noon_api');
Route::get('/save_manual_foloosi', [HomeController::class, 'save_manual_foloosi'])->name('save_manual_foloosi');
Route::get('/foloosi_redirect', [HomeController::class, 'foloosiRedirect'])->name('foloosi_redirect');
Route::get('/foloosi-success', function (Request $request) {
    $status = $request->query('status');
    return view('pages.foloosi_redirect', compact('status'));
});
Route::post('/save-Foloosipayment-data', [HomeController::class, 'saveFoloosiPaymentData'])->name('save-Foloosipayment-data');
Route::post('/handleFoloosiWebhook', [HomeController::class, 'handleFoloosiWebhook'])->name('handleFoloosiWebhook');
Route::get('/generate_ClientPdf', [HomeController::class, 'generate_ClientPdf'])->name('generate_ClientPdf');
Route::get('/invoice', [HomeController::class, 'invoice'])->name('invoice');
Route::get('/view_invoice/{id}', [HomeController::class, 'view_invoice'])->name('view_invoice');
Route::get('/view_foloosi_invoice', [HomeController::class, 'view_foloosi_invoice'])->name('view_foloosi_invoice');
Route::get('/payment_captured/{id}', [HomeController::class, 'payment_captured'])->name('payment_captured');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/career', [HomeController::class, 'career'])->name('career');
Route::get('/confirm/{id}', [HomeController::class, 'confirm'])->name('confirm');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/market', [HomeController::class, 'market'])->name('market');
Route::get('/payment/{id}', [HomeController::class, 'payment'])->name('payment');
Route::post('/save_contact', [HomeController::class, 'save_contact'])->name('save_contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/pdf', [HomeController::class, 'pdf']);
Route::post('/open_account', [HomeController::class, 'open_account']);
Route::get('/customPdfGenerate', [HomeController::class, 'customPdfGenerate'])->name('custom_pdf_generate');
Route::get('/custom_view_invoice', [HomeController::class, 'custom_view_invoice'])->name('custom_view_invoice');
Route::get('/invoice_status/{id}', [HomeController::class, 'invoice_status'])->name('invoice_status');
Route::get('/generate_pdf', [HomeController::class, 'generate_pdf']);
Route::post('/save_customer', [CustomerController::class, 'save_customer'])->name('save_customer');
Route::post('/update_customer', [CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('/change_password', [CustomerController::class, 'change_password'])->name('change_password');
Route::post('/logout', [CustomerController::class, 'logout'])->name('logout');
Route::get('/forgot_password', [AuthController::class, 'forgot_password'])->name('forgot_password');
Route::post('/updatePassword',[HomeController::class,'updateClientPassword'])->name('updatePassword');
// Google OAuth Routes
Route::get('login/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

//Customer Login Route
Route::post('/login', [CustomerController::class, 'login_customer'])->name('login_customer');

//Create Charge
Route::post('/createCharge', [HomeController::class, 'createCharge'])->name('createCharge');
Route::post('/createNoonCharge', [HomeController::class, 'createNoonCharge'])->name('createNoonCharge');
Route::post('/createNetworkCharge', [NetworkIntPaymentController::class, 'createNetworkCharge'])->name('createNetworkCharge');
Route::get('/save_noon_payment_data', [HomeController::class, 'save_noon_payment_data'])->name('save_noon_payment_data');
Route::get('/get_noon_last_payment', [HomeController::class, 'get_noon_last_payment'])->name('get_noon_last_payment');
// Route::get('/webhook', [HomeController::class, 'webhook'])->name('webhook');
Route::get('/success', [HomeController::class, 'success'])->name('success');
Route::get('/save_payment_data', [HomeController::class, 'save_payment_data'])->name('save_payment_data');
Route::get('/get_last_payment', [HomeController::class, 'get_last_payment'])->name('get_last_payment');

Route::group(['middleware' => ['redirectifauthenticated']], function () {
    // Routes that should be accessible only to guests
    Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');

    // ...other routes like registration
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::get('/account', [CustomerController::class, 'account'])->name('account');
    Route::post('/get_record_by_client', [CustomerController::class, 'get_record_by_client'])->name('get_record_by_client');
    Route::post('/download_client_agreement', [CustomerController::class, 'download_client_agreement'])->name('download_client_agreement');
    // Route::get('/refund_request', [CustomerController::class, 'refund_request'])->name('refund_request');
    // Route::get('/send_refund_request', [CustomerController::class, 'send_refund_request'])->name('send_refund_request');
    // ... other routes that require authentication
});


//Admin Routes
Route::get('/admin', [AdminAuthController::class, 'index'])->name('admin')->middleware('admin.redirect');;

//Admin Login Route
Route::post('/admin_login', [AdminAuthController::class, 'login_admin'])->name('login_admin');


Route::middleware(['admin'])->group(function () {

    //Routes FOR Network International Payment Gateway
    Route::get('coffee/create_networkInt_link',[SuperAdminController::class, 'create_networkInt_link'])->name('coffee.create_networkInt_link');
    Route::post('coffee/store_networkInt_link',[SuperAdminController::class,'store_networkInt_link'])->name('coffee.store_networkInt_link');
    
    // Place your Superadmin routes here
     Route::post('/coffee/upload-kyc',                          [SuperAdminController::class, 'uploadKycDuringLink'])->name('coffee.uploadKyc');
    Route::get('coffee/dashboard',                              [SuperAdminController::class, 'dashboard'])->name('coffee.dashboard');
    Route::get('coffee/all_payments',                           [SuperAdminController::class, 'all_payments'])->name('coffee.all_payments');
    Route::get('coffee/all_foloosi_payments',                   [SuperAdminController::class, 'all_foloosi_payments'])->name('coffee.all_foloosi_payments');
    Route::get('coffee/get_all_payments',                       [SuperAdminController::class, 'get_all_payments'])->name('coffee.get_all_payments');
    Route::get('coffee/get_all_foloosi_payments',               [SuperAdminController::class, 'get_all_foloosi_payments'])->name('coffee.get_all_foloosi_payments');
    Route::get('coffee/fetch_and_save_data',                    [SuperAdminController::class, 'fetch_and_save_data'])->name('coffee.fetch_and_save_data');
     Route::get('coffee/fetch_and_save_foloosi_data',           [SuperAdminController::class, 'fetch_and_save_foloosi_data'])->name('coffee.fetch_and_save_foloosi_data');
    Route::get('coffee/chart-data',                             [SuperAdminController::class, 'getChartData'])->name('coffee.getChartData');
    Route::get('coffee/revenue-data',                           [SuperAdminController::class, 'getRevenueData'])->name('revenue.data');
    Route::get('coffee/todayTransaction',                       [SuperAdminController::class, 'todayTransaction'])->name('coffee.todayTransaction');
     Route::get('coffee/exportTapTransactionsPdf/{date?}',      [SuperAdminController::class, 'exportTapTransactionsPdf'])->name('coffee.exportTapTransactionsPdf');
       Route::get('coffee/exportFoloosiTransactionsPdf/{date?}',[SuperAdminController::class, 'exportFoloosiTransactionsPdf'])->name('coffee.exportFoloosiTransactionsPdf');
     Route::get('coffee/exportExcelTap/{date?}',                [SuperAdminController::class, 'exportExcelTap'])->name('coffee.exportExcelTap');
     Route::get('coffee/exportFoloosiExcelTap/{date?}',         [SuperAdminController::class, 'exportFoloosiExcelTap'])->name('coffee.exportFoloosiExcelTap');
    Route::get('coffee/all_links',                              [SuperAdminController::class, 'all_links'])->name('coffee.all_links');
    Route::get('coffee/logout',                                 [SuperAdminController::class, 'logout'])->name('coffee.logout');
    Route::get('coffee/create_link',                            [SuperAdminController::class, 'create_link'])->name('coffee.new_link');
    Route::post('coffee/store_link',                            [SuperAdminController::class,'store_link'])->name('coffee.store_link');
    Route::get('coffee/new_foloosi_link',                       [SuperAdminController::class, 'new_foloosi_link'])->name('coffee.new_foloosi_link');
    Route::post('coffee/store_foloosi_link',                    [SuperAdminController::class,'store_foloosi_link'])->name('coffee.store_foloosi_link');
        Route::get('coffee/create_noon_link',                   [SuperAdminController::class, 'create_noon_link'])->name('coffee.create_noon_link');
       
    Route::post('coffee/store_noon_link',                       [SuperAdminController::class,'store_noon_link'])->name('coffee.store_noon_link');
  
    // Routes For Get Payment Link
    Route::get('coffee/get_all_links',                          [SuperAdminController::class,'get_all_links'])->name('coffee.get_all_links');
    Route::get('coffee/delete_link',                            [SuperAdminController::class,'delete_link'])->name('coffee.delete_link');
    Route::get('coffee/get_link_detail',                        [SuperAdminController::class,'get_link_detail'])->name('coffee.get_link_detail');
    Route::post('coffee/update_link',                           [SuperAdminController::class,'update_link'])->name('coffee.update_link');

      // Routes For Get Noon Payment Link
    
    Route::get('coffee/noon_links',                               [SuperAdminController::class, 'noon_links'])->name('coffee.noon_links');
      
    Route::get('coffee/get_all_noon_links',                          [SuperAdminController::class,'get_all_noon_links'])->name('coffee.get_all_noon_links');
    Route::get('coffee/delete_noon_link',                            [SuperAdminController::class,'delete_noon_link'])->name('coffee.delete_noon_link');
    Route::get('coffee/get_noon_link_detail',                        [SuperAdminController::class,'get_noon_link_detail'])->name('coffee.get_noon_link_detail');
    Route::post('coffee/update_noon_link',                           [SuperAdminController::class,'update_noon_link'])->name('coffee.update_noon_link');


    // Routes For Create & Fetch Agents
    Route::get('coffee/create_agent',    [SuperAdminController::class,'create_agent'])->name('coffee.create_agent');
    Route::get('coffee/all_agents',      [SuperAdminController::class,'all_agents'])->name('coffee.all_agents');
    Route::post('coffee/store_agent',    [SuperAdminController::class,'store_agent'])->name('coffee.store_agent');
    Route::get('coffee/get_all_agents',  [SuperAdminController::class,'get_all_agents'])->name('coffee.get_all_agents');


    // Routes For Create & Fetch KYC's
    Route::get('coffee/all_kyc',         [SuperAdminController::class,'all_kyc'])->name('coffee.all_kyc');
    Route::get('coffee/create_kyc',      [SuperAdminController::class,'create_kyc'])->name('coffee.create_kyc');
    Route::post('coffee/store_kyc',      [SuperAdminController::class,'store_kyc'])->name('coffee.store_kyc');
    Route::get('coffee/get_all_kyc',     [SuperAdminController::class,'get_all_kyc'])->name('coffee.get_all_kyc');
    Route::get('coffee/delete_kyc',      [SuperAdminController::class,'delete_kyc'])->name('coffee.delete_kyc');

    //Routes for Refund requests routes
     Route::get('coffee/all_tap_refunds', [SuperAdminController::class,'all_tap_refunds'])->name('coffee.all_tap_refunds');
    Route::get('coffee/fetch_all_refunds', [SuperAdminController::class,'fetch_all_refunds'])->name('coffee.fetch_all_refunds');
    Route::get('coffee/get_all_tap_refunds', [SuperAdminController::class,'get_all_tap_refunds'])->name('coffee.get_all_tap_refunds');
    
    Route::get('coffee/requested_refunds',          [SuperAdminController::class,'requested_refunds'])->name('coffee.requested_refunds');
    Route::get('coffee/get_all_refund_requests',    [SuperAdminController::class,'get_all_refund_requests'])->name('coffee.get_all_refund_requests');
    Route::get('coffee/confirm_refund',             [SuperAdminController::class,'confirm_refund'])->name('coffee.confirm_refund');
    Route::get('coffee/dispute_refunds',            [SuperAdminController::class,'dispute_refunds'])->name('coffee.dispute_refunds');


    //Routes For SuperAdmin Reports 
      Route::get('coffee/agent_payment_report',    [SuperAdminController::class,'agent_payment_report'])->name('coffee.agent_payment_report');
      Route::get('coffee/get_payment_by_agent',    [SuperAdminController::class,'get_payment_by_agent'])->name('coffee.get_payment_by_agent');
      Route::get('coffee/payment_ledger',          [SuperAdminController::class,'payment_ledger'])->name('coffee.payment_ledger');
      Route::get('coffee/get_all_paymentsLedger',    [SuperAdminController::class,'get_all_paymentsLedger'])->name('coffee.get_all_paymentsLedger');
      Route::get('coffee/foloosi_payment_ledger',    [SuperAdminController::class,'foloosi_payment_ledger'])->name('coffee.foloosi_payment_ledger');
      Route::get('coffee/get_foloosi_paymentsLedger',    [SuperAdminController::class,'get_foloosi_paymentsLedger'])->name('coffee.get_foloosi_paymentsLedger');  
      Route::get('coffee/agent_tap_paymentledger',    [SuperAdminController::class,'agent_tap_paymentledger'])->name('coffee.agent_tap_paymentledger');
      Route::get('coffee/get_all_tap_paymentsAgentLedger',    [SuperAdminController::class,'get_all_tap_paymentsAgentLedger'])->name('coffee.get_all_tap_paymentsAgentLedger');
    // Admin Routes routes...
    Route::get('coffee/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('coffee.admin.dashboard');
    

    

    // Agent Routes routes...
    Route::get('coffee/agent/dashboard', [AgentController::class, 'dashboard'])->name('coffee.agent.dashboard');
     Route::get('coffee/agent/todayTransaction',       [AgentController::class, 'todayTransaction'])->name('coffee.agent.todayTransaction');
      Route::get('coffee/agent/exportTapTransactionsPdf/{date?}',       [AgentController::class, 'exportTapTransactionsPdf'])->name('coffee.agent.exportTapTransactionsPdf');
       Route::get('coffee/agent/exportFoloosiTransactionsPdf/{date?}',       [AgentController::class, 'exportFoloosiTransactionsPdf'])->name('coffee.agent.exportFoloosiTransactionsPdf');
     Route::get('coffee/agent/exportExcelTap/{date?}',       [AgentController::class, 'exportExcelTap'])->name('coffee.agent.exportExcelTap');
     Route::get('coffee/agent/exportFoloosiExcelTap/{date?}',       [AgentController::class, 'exportFoloosiExcelTap'])->name('coffee.agent.exportFoloosiExcelTap');
    Route::get('coffee/agent/create_link', [AgentController::class, 'create_link'])->name('coffee.agent.new_link');
    Route::post('coffee/agent/store_link', [AgentController::class,'store_link'])->name('coffee.agent.store_link');
    Route::get('coffee/agent/get_all_links', [AgentController::class,'get_all_links'])->name('coffee.agent.get_all_links');
    Route::get('coffee/agent/all_links', [AgentController::class, 'all_links'])->name('coffee.agent.all_links'); 
    Route::get('coffee/agent/new_agent_foloosi_link',   [AgentController::class, 'new_agent_foloosi_link'])->name('coffee.agent.new_agent_foloosi_link');
    Route::post('coffee/agent/store_foloosi_link',[AgentController::class,'store_foloosi_link'])->name('coffee.agent.store_foloosi_link');
    Route::get('coffee/agent/logout', [AgentController::class, 'logout'])->name('coffee.agent.logout');

    // Agent Refund Request Route
    Route::get('coffee/agent/all_refund_requests',      [AgentController::class, 'all_refund_requests'])->name('coffee.agent.all_refund_requests');
    Route::get('coffee/agent/get_all_fund_requests',    [AgentController::class, 'get_all_fund_requests'])->name('coffee.agent.get_all_fund_requests');
    Route::get('coffee/agent/new_refund_request',       [AgentController::class,'create_refund_requests'])->name('coffee.agent.new_refund_request');
    Route::post('coffee/agent/store_refund_request',    [AgentController::class,'store_refund_request'])->name('coffee.agent.store_refund_request');
    Route::get('coffee/agent/get_refund_detail',        [AgentController::class,'get_refund_detail'])->name('coffee.agent.get_refund_detail');
    Route::post('coffee/agent/update_refund_request',   [AgentController::class,'update_refund_request'])->name('coffee.agent.update_refund_request');



    // Routes For Create & Fetch KYC's For Agent
    Route::get('coffee/agent/all_kyc_by_agent',               [AgentController::class,'all_kyc_by_agent'])->name('coffee.agent.all_kyc_by_agent');
    Route::get('coffee/agent/create_kyc_by_agent',            [AgentController::class,'create_kyc_by_agent'])->name('coffee.agent.create_kyc_by_agent');
    Route::post('coffee/agent/store_agent_kyc',               [AgentController::class,'store_agent_kyc'])->name('coffee.agent.store_agent_kyc');
    Route::get('coffee/agent/get_all_kyc_by_agent',           [AgentController::class,'get_all_kyc_by_agent'])->name('coffee.agent.get_all_kyc_by_agent');
    Route::get('coffee/agent/delete_kyc_by_agent',            [AgentController::class,'delete_kyc_by_agent'])->name('coffee.agent.delete_kyc_by_agent');


    // Routes For Create & Fetch Member by Agent
    Route::get('coffee/agent/all_member',                     [AgentController::class,'all_member'])->name('coffee.agent.all_member');
    Route::get('coffee/agent/create_member',                  [AgentController::class,'create_member'])->name('coffee.agent.create_member');
    Route::post('coffee/agent/store_member',                    [AgentController::class,'store_member'])->name('coffee.agent.store_member');
    Route::get('coffee/agent/get_all_members',                    [AgentController::class,'get_all_members'])->name('coffee.agent.get_all_members');
    Route::get('coffee/agent/delete_member',                    [AgentController::class,'delete_member'])->name('coffee.agent.delete_member');

    // Routes For Create & Fetch Members
    Route::get('coffee/agent/all_members',                    [AgentController::class,'all_members'])->name('coffee.agent.all_members');
    
    Route::post('/agent/upload-kyc', [AgentController::class, 'uploadKycDuringLink'])->name('coffee.agent.uploadKyc');

    // Routes For Fetch Payment Status
    Route::get('coffee/agent/link_payments', [AgentController::class, 'link_payments'])->name('coffee.agent.link_payments');
    Route::get('coffee/agent/get_link_payments_status',    [AgentController::class, 'get_link_payments_status'])->name('coffee.agent.get_link_payments_status');
    // Management Routes routes...
    Route::get('coffee/management/dashboard', [AgentController::class, 'dashboard'])->name('coffee.management.dashboard');
    
    // Manage Noon Payment Links For Agent
    Route::get('coffee/agent/create_noon_link',                            [AgentController::class, 'create_noon_link'])->name('coffee.agent.create_noon_link');
    Route::post('coffee/agent/store_noon_link',                            [AgentController::class,'store_noon_link'])->name('coffee.agent.store_noon_link');
    Route::get('coffee/agent/noon_links',                                  [AgentController::class, 'noon_links'])->name('coffee.agent.noon_links');
    Route::get('coffee/agent/get_all_noon_links',                          [AgentController::class,'get_all_noon_links'])->name('coffee.agent.get_all_noon_links');
    Route::get('coffee/agent/delete_noon_link',                            [AgentController::class,'delete_noon_link'])->name('coffee.agent.delete_noon_link');
    Route::get('coffee/agent/get_noon_link_detail',                        [AgentController::class,'get_noon_link_detail'])->name('coffee.agent.get_noon_link_detail');
    Route::post('coffee/agent/update_noon_link',                           [AgentController::class,'update_noon_link'])->name('coffee.agent.update_noon_link');
    
    // Member Routes routes...
    Route::post('/coffee/member/upload-kyc', [MemberController::class, 'uploadKycDuringLink'])->name('coffee.member.uploadKyc');
    Route::get('coffee/member/dashboard', [MemberController::class, 'dashboard'])->name('coffee.member.dashboard');
    Route::get('coffee/member/all_links_by_member', [MemberController::class, 'all_links_by_member'])->name('coffee.member.all_links_by_member');
    Route::get('coffee/member/get_all_links', [MemberController::class,'get_all_links'])->name('coffee.member.get_all_links');
    Route::get('coffee/member/new_link_by_member', [MemberController::class, 'new_link_by_member'])->name('coffee.member.new_link_by_member');
       Route::get('coffee/member/link_payments_by_member', [MemberController::class, 'link_payments_by_member'])->name('coffee.member.link_payments_by_member');
    Route::post('coffee/member/store_link', [MemberController::class, 'store_link'])->name('coffee.member.store_link');
     Route::get('coffee/member/new_foloosi_link',   [MemberController::class, 'new_member_foloosi_link'])->name('coffee.member.new_foloosi_link');
    Route::post('coffee/member/store_foloosi_link',[MemberController::class,'store_foloosi_link'])->name('coffee.member.store_foloosi_link');
    Route::get('coffee/member/create_noon_link',                            [MemberController::class, 'create_noon_link'])->name('coffee.member.create_noon_link');
     Route::post('coffee/member/store_noon_link',                            [MemberController::class,'store_noon_link'])->name('coffee.member.store_noon_link');
       Route::get('coffee/member/get_all_noon_links',                          [MemberController::class,'get_all_noon_links'])->name('coffee.member.get_all_noon_links');
       Route::get('coffee/member/noon_links',                                  [MemberController::class, 'noon_links'])->name('coffee.member.noon_links');
       
         // Routes For Fetch Payment Status
    Route::get('coffee/member/link_payments', [MemberController::class, 'link_payments'])->name('coffee.member.link_payments');
    Route::get('coffee/member/get_link_payments_status',    [MemberController::class, 'get_link_payments_status'])->name('coffee.member.get_link_payments_status');
});
// Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


// API CALL TO GET CLIENT DETAILS

// Route::middleware(['checkapikey'])->get('/tap-payments', 'API\TapPaymentController@index');
// Route::get('/tap-payments', [TapPaymentController::class, 'index']);
Route::middleware(['cors', 'checkapikey'])->get('/tap-payments', [TapPaymentController::class, 'index']);
Route::middleware(['cors', 'checkapikey'])->get('/generate-client-agreement', [TapPaymentController::class, 'generatePdf']);
Route::middleware(['cors', 'checkapikey'])->get('/download-client-agreement', [TapPaymentController::class, 'downloadAgreement']);
