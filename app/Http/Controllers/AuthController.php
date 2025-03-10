<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Validasi email harus dari student.uin-malang.ac.id
            if (!str_ends_with($googleUser->getEmail(), '@student.uin-malang.ac.id')) {
                // Return error message
            }

            $emailParts = explode('@', $googleUser->getEmail());
            $nim = $emailParts[0];

            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->orWhere('nim', $nim)
                ->first();

            if (!$user) {
                $user = User::create([
                    'google_id' => $googleUser->getId(),
                    'nim' => $nim,
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'number_phone' => null,
                ]);
            }

            // Login user
            Auth::login($user);

            if ($user->is_admin) {
                // Redirect user ke halaman admin
            } else {
                // Redirect user ke halaman dashboard
            }
        } catch (\Exception $e) {
            dd($e);
            // Return error message
        }
    }

    public function logout()
    {
        Auth::logout();

        // Redirect user ke halaman login
    }
}
