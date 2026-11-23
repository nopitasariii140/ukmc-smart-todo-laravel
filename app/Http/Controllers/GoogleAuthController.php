<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        if (
            blank(config('services.google.client_id')) ||
            blank(config('services.google.client_secret'))
        ) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'Google Login belum dikonfigurasi. Isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET pada file .env.',
                ]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $google = Socialite::driver('google')->user();

            $user = User::where('email', $google->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $google->getName() ?: 'Google User',
                    'email' => $google->getEmail(),
                    'password' => null,
                    'provider' => 'google',
                    'google_id' => $google->getId(),
                    'avatar' => $google->getAvatar(),
                ]);
            } else {
                $user->google_id = $google->getId();
                $user->avatar = $google->getAvatar();

                if (blank($user->provider)) {
                    $user->provider = 'google';
                }

                $user->save();
            }

            Auth::login($user);
            $request->session()->regenerate();

            // Penting untuk sinkronisasi dengan Flutter:
            // Flutter juga harus menggunakan googleUser.id.
            $request->session()->put(
                'owner_key',
                'google_'.$google->getId()
            );
            $request->session()->put('auth_mode', 'google');

            return redirect()
                ->route('todos.index')
                ->with('success', 'Login Google berhasil.');
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'Login Google gagal. Periksa OAuth Client dan redirect URI.',
                ]);
        }
    }
}
