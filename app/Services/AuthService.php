<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function getAuthenticatedUser()
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User not authenticated');
        }

        return $user;
    }
}
