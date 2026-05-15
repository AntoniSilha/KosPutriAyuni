<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegister()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user());
        }

        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:16'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:13'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'no_ktp' => $request->no_ktp,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role for registration (matches DB enum)
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Akun Anda berhasil dibuat!');
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user());
        }

        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->redirectByRole(auth()->user());
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password - generate token and show reset form directly
     * Since mail is not configured, we use a simplified token approach
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
        }

        // Generate a simple token
        $token = Str::random(64);

        // Store in cache for 60 minutes (no DB table needed)
        cache()->put('password_reset_' . $token, $user->email, now()->addMinutes(60));

        // Redirect directly to reset form (since mail is not configured)
        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email])
            ->with('success', 'Silakan atur ulang password Anda di halaman berikut.');
    }

    /**
     * Show reset password form
     */
    public function showResetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Handle reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $cachedEmail = cache()->get('password_reset_' . $request->token);

        if (!$cachedEmail || $cachedEmail !== $request->email) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kedaluwarsa.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Remove used token
        cache()->forget('password_reset_' . $request->token);

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru.');
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectByRole($user)
    {
        if ($user->isAdmin()) {
            return redirect('/admin');
        }

        if ($user->isPenghuni()) {
            return redirect('/dashboard');
        }

        return redirect('/');
    }
}
