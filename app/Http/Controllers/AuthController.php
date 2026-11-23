<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'provider' => 'sql',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        $request->session()->put('owner_key', 'sql_'.$user->id);
        $request->session()->put('auth_mode', 'sql');

        return redirect()
            ->route('todos.index')
            ->with('success', 'Registrasi berhasil. Selamat datang!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (
            !$user ||
            empty($user->password) ||
            !Hash::check($credentials['password'], $user->password)
        ) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        $request->session()->put('owner_key', 'sql_'.$user->id);
        $request->session()->put('auth_mode', 'sql');

        return redirect()
            ->route('todos.index')
            ->with('success', 'Login SQL berhasil.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
