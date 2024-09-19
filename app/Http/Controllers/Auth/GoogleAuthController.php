<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // dd($googleUser);
             // Retrieve the user's profile picture
             $avatar = $googleUser->getAvatar();
            $user = Customer::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'username' => $googleUser->getName(),
                    'photo' => $avatar,
                    // You can set a random password, or leave it null and handle login logic accordingly
                    'password' =>bcrypt(Str::random(24)),
                    'account_ctype'=>'google'
                ]
            );

            Auth::login($user);
            return redirect()->intended('home');
        } catch (\Exception $e) {
            // Handle exception
            return redirect()->route('signup')->withErrors('Login failed: ' . $e->getMessage());
        }
    }
}

