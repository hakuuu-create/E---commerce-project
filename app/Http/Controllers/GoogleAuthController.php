<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleAuthController extends Controller
{
    /**
     * Redirect ke halaman autentikasi Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }

        // Cek apakah user sudah ada berdasarkan google_id
        $user = User::where('google_id', $googleUser->getId())->first();

        if (! $user) {
            // Cek apakah email sudah terdaftar (user biasa yang belum punya google_id)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Hanya tambahkan google_id, jangan ubah password yang sudah ada
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            } else {
                // Buat user baru dengan random password agar kolom tidak null
                // Password random ini tidak bisa dipakai login manual — hanya via Google
                $user = User::create([
                    'name'              => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'google_id'         => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'password'          => Hash::make(Str::random(24)),
                ]);
            }
        }

        Auth::guard('web')->login($user, true);

        return redirect()->intended('/');
    }
}