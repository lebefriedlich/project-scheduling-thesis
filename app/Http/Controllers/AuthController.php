<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Validasi email harus dari student.uin-malang.ac.id
            if (
                !str_ends_with($googleUser->getEmail(), '@student.uin-malang.ac.id') &&
                $googleUser->getEmail() != 'noval.akbar.906@gmail.com'
            ) {
                return redirect(route('login'))->with('error', 'Email tidak valid.');
            }

            $emailParts = explode('@', $googleUser->getEmail());
            $nim = $emailParts[0];

            // Cek apakah user sudah ada berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
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
                return redirect(route('admin.index'));
            } else {
                // Redirect user ke halaman dashboard
                return redirect(route('user'));
            }
        } catch (\Exception $e) {
            // Handle error
            return redirect(route('login'))->with('error', 'Terjadi kesalahan saat login.');
        }
    }

    public function viewEditProfile()
    {
        // return view edit profile
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if (!$user) {
            // Return error message
        }

        $messages = [
            'required' => 'The :attribute field is required.',
            'numeric' => 'The :attribute field must be a number.',
        ];

        $validator = Validator::make($request->all(), [
            'number_phone' => 'required|numeric|unique:users,number_phone,' . $user->id,
        ], $messages);

        if ($validator->fails()) {
            // Return error message
        }

        $user->number_phone = $request->number_phone;
        $user->save();

        Auth::setUser($user);
        Auth::user()->refresh();
        session()->regenerate();


        // Redirect user ke halaman edit profile
    }

    public function logout()
    {
        Auth::logout();

        return redirect(route('login'))->with('success', 'Logout berhasil.');
    }
}
