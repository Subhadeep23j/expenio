@include('partials.header')

<div style="min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1rem;">
    
    <div style="width: 100%; max-width: 420px; background: var(--surface); border-radius: 12px; padding: 2.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        
        <!-- Logo/Brand -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 56px; height: 56px; background: var(--accent); border-radius: 12px; margin-bottom: 1rem;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="5" width="20" height="14" rx="2"/>
                    <line x1="2" y1="10" x2="22" y2="10"/>
                </svg>
            </div>
            <h1 class="serif" style="font-size: 1.75rem; margin: 0 0 0.25rem; color: var(--text);">Welcome Back</h1>
            <p style="font-size: 0.875rem; color: var(--muted); margin: 0;">Sign in to your account</p>
        </div>

        <!-- Flash Messages -->
        @if (session('error'))
            <div style="background: #fdecea; border-left: 4px solid #e05a42; color: #7a2010; padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #fdecea; border-left: 4px solid #e05a42; color: #7a2010; padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div style="margin-bottom: 1.25rem;">
                <label for="email" style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--text); margin-bottom: 0.5rem;">
                    Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9375rem; background: var(--surface); color: var(--text); transition: border-color 0.15s;"
                    onfocus="this.style.borderColor='var(--accent)'; this.style.outline='none'"
                    onblur="this.style.borderColor='var(--border)'"
                >
            </div>

            <!-- Password -->
            <div style="margin-bottom: 1.5rem;">
                <label for="password" style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--text); margin-bottom: 0.5rem;">
                    Password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--border); border-radius: 8px; font-size: 0.9375rem; background: var(--surface); color: var(--text); transition: border-color 0.15s;"
                    onfocus="this.style.borderColor='var(--accent)'; this.style.outline='none'"
                    onblur="this.style.borderColor='var(--border)'"
                >
            </div>

            <!-- Remember Me & Forgot Password -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--text); cursor: pointer;">
                    <input type="checkbox" name="remember" style="width: 16px; height: 16px; cursor: pointer;">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--accent); text-decoration: none;">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button 
                type="submit"
                style="width: 100%; padding: 0.875rem; background: var(--accent); color: white; border: none; border-radius: 8px; font-size: 0.9375rem; font-weight: 500; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='var(--accent-lt)'"
                onmouseout="this.style.background='var(--accent)'"
            >
                Sign In
            </button>
        </form>

        <!-- Register Link -->
        @if (Route::has('register'))
            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <p style="font-size: 0.875rem; color: var(--muted); margin: 0;">
                    Don't have an account? 
                    <a href="{{ route('register') }}" style="color: var(--accent); text-decoration: none; font-weight: 500;">
                        Sign up
                    </a>
                </p>
            </div>
        @endif

    </div>

</div>

@include('partials.footer')
