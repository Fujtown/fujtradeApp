<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signin()
    {
        return view('pages.signin');
    }
    public function signup()
    {
        return view('pages.signup');
    }
    public function forgot_password()
    {
        return view('pages.forgotPassword');
    }
    public function logout()
    {

    }
}
