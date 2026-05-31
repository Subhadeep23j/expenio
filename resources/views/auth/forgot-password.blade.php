@include('partials.header')

<div
    style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">

    <div
        style="width: 100%; max-width: 420px; background: var(--surface); border-radius: 12px; padding: 2.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

        <!-- Logo/Brand -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div
                style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: var(--accent); border-radius: 12px; margin-bottom: 1rem;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2" />
                    <line x1="2" y1="10" x2="22" y2="10" />
                </svg>
            </div>
            <h1 class="serif" style="font-size: 1.75rem; margin: 0 0 0.25rem; color: var(--text);">Forgot Password</h1>
            <p style="font-size: 0.875rem; color: var(--muted); margin: 0;">We will send a one-time code to your email
            </p>
        </div>

        <!-- Flash Messages -->
        @if (session('status'))
            <div
                style="background: #e7f6ec; border-left: 4px solid #3aa76d; color: #1f5b3b; padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1.5rem;">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="background: #fdecea; border-left: 4px solid #e05a42; color: #7a2010; padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Request OTP Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom: 1.5rem;">
                <label for="email"
                    style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--text); margin-bottom: 0.5rem;">
                    Email Address
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9375rem; background: var(--surface); color: var(--text); transition: border-color 0.15s;"
                    onfocus="this.style.borderColor='var(--accent)'; this.style.outline='none'"
                    onblur="this.style.borderColor='var(--border)'">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                style="width: 100%; padding: 0.875rem; background: var(--accent); color: white; border: none; border-radius: 8px; font-size: 0.9375rem; font-weight: 500; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='var(--accent-lt)'"
                onmouseout="this.style.background='var(--accent)'">
                Send OTP
            </button>
        </form>

        <!-- Back to Login -->
        <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <p style="font-size: 0.875rem; color: var(--muted); margin: 0;">
                Remembered your password?
                <a href="{{ route('login') }}" style="color: var(--accent); text-decoration: none; font-weight: 500;">
                    Sign in
                </a>
            </p>
        </div>

    </div>

</div>

@include('partials.footer')
