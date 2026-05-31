<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    private const OTP_TTL_MINUTES = 10;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $email = strtolower($validated['email']);
        $user = User::where('email', $email)->first();

        if ($user) {
            $otp = $this->generateOtp();
            Cache::put(
                $this->otpCacheKey($email),
                ['hash' => Hash::make($otp)],
                now()->addMinutes(self::OTP_TTL_MINUTES)
            );

            Mail::to($email)->send(new PasswordResetOtp($otp, self::OTP_TTL_MINUTES));
        }

        $message = 'If your email exists in our system, we sent a 6-digit OTP.';

        if ($this->isApiRequest($request)) {
            return response()->json(['message' => $message]);
        }

        return redirect()
            ->route('password.reset', ['email' => $email])
            ->with('status', $message);
    }

    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', [
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'otp' => ['required', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $email = strtolower($validated['email']);
        $cachePayload = Cache::get($this->otpCacheKey($email));

        if (!is_array($cachePayload) || empty($cachePayload['hash'])) {
            return $this->invalidOtpResponse($request);
        }

        if (!Hash::check($validated['otp'], $cachePayload['hash'])) {
            return $this->invalidOtpResponse($request);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->invalidOtpResponse($request);
        }

        $user->update([
            'password' => $validated['password'],
        ]);

        Cache::forget($this->otpCacheKey($email));

        $message = 'Password reset successful. You can now sign in.';

        if ($this->isApiRequest($request)) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('login')->with('status', $message);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function generateOtp(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    private function otpCacheKey(string $email): string
    {
        return 'password_reset_otp:' . sha1($email);
    }

    private function invalidOtpResponse(Request $request)
    {
        $message = 'Invalid or expired OTP.';

        if ($this->isApiRequest($request)) {
            return response()->json(['message' => $message], 422);
        }

        return back()->withErrors(['otp' => $message])->withInput();
    }

    private function isApiRequest(Request $request): bool
    {
        return $request->expectsJson() || $request->is('api/*');
    }
}
