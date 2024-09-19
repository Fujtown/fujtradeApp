<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class AdminAuthController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.superadmin.login');
    }

    public function login_admin(Request $request)
    {
    $validated = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt to log the user in
    if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
        // The admin user is logged in...
        $admin = Auth::guard('admin')->user();

        // Check if the admin status is active
        if ($admin->status == 'active') {
            // Set user_type in session
            session(['user_type' => $admin->user_type]);

            return response()->json([
                'message' => 'Successfully logged in',
                'user_type' => $admin->user_type,
            ]);
        } else {
            // If the status is not active, log out the user
            Auth::guard('admin')->logout();

            return response()->json([
                'message' => 'Your account is not active',
            ], 403); // Forbidden status code
        }
    }

    // If login attempt was unsuccessful
    throw ValidationException::withMessages([
        'email' => [trans('auth.failed')],
    ]);
}
}
