<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class GithubController extends Controller
{
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGithubCallback(Request $request)
    {
        try {
            $githubUser = Socialite::driver('github')->stateless()->user();

            // Find or create the user
            $user = User::updateOrCreate(
                ['email' => $githubUser->getEmail()],
                [
                    'name' => $githubUser->getName(),
                    'github_id' => $githubUser->getId(),
                    'github_avatar' => $githubUser->getAvatar(),
                    'password' => bcrypt('0000'), // Set default password '0000' on create
                ]
            );

            // Log the user in
            // Auth::login($user, true);

            return redirect('/home'); // Redirect to home or wherever you want
        } catch (\Exception $e) {
            Log::error('Error in GitHub callback: ' . $e->getMessage());
            return redirect('/login')->withErrors(['error' => 'Failed to authenticate with GitHub']);
        }
    }
}
