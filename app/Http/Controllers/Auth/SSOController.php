<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;

class SSOController extends Controller
{
    public function redirectToSso(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback(Request $request)
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?? explode('@', $email)[0];

        // Zoek of de gebruiker al bestaat
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Eerste keer inloggen → nieuwe gebruiker aanmaken
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => '', // Geen wachtwoord nodig
            ]);

            // 🛡️ Voeg hier eventueel een **standaardrol** toe
            // Bijvoorbeeld: geef standaard 'gebruiker' rol
            Log::info('New user created via Google SSO', ['email' => $email]);
        }

        Auth::login($user);

        Log::info('User logged in via Google SSO', ['user_id' => $user->id, 'email' => $user->email]);

        // ➡️ Redirect op basis van rol
        if ($user->hasRole('admin') || $user->hasRole('dj') || $user->hasRole('redactie') || $user->hasRole('beheer')) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/dashboard');
        }

    } catch (\Exception $e) {
        Log::error('Google SSO login failed', ['error' => $e->getMessage()]);
        return redirect()->route('login')->with('error', 'Fout bij Google-login: ' . $e->getMessage());
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info('User logged out');
        return redirect('/');
    }
}
