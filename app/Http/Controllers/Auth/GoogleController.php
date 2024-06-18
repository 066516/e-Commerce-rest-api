<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find or create the user
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // User does not exist, create them with a default password
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt('0000'), // Set default password '0000'
                ]);
            }else{
                $user = User::update([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }


           

            return redirect('/home'); // Redirect to home or wherever you want
        } catch (\Exception $e) {
            Log::error('Error in Google callback: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Failed to authenticate with Google']);
        }
    }
}
