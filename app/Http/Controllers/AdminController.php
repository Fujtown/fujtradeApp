<?php

namespace App\Http\Controllers;

use App\Models\TapPaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TapPayment;
use App\Models\Refunds;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Helpers\UniqueNumberGenerator;
class AdminController extends Controller
{
    public function __construct()
{
    $this->middleware('admin');
}

    public function dashboard(Request $request)
    {
        // dd();
        // $user = Auth::guard('admin')->user();
        return view('pages.admin.dashboard');
    }

}
