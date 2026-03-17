@extends('layout.app')
@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-subtitle', 'Manage your account details')

@section('content')
    <div class="grid-2" style="margin-bottom:2rem;">
        <!-- Update Profile -->
        <div class="card">
            <div class="card-title" style="margin-bottom:0.25rem;">Profile Information</div>
            <div style="font-size:0.82rem; color:var(--muted); margin-bottom:1.25rem;">Update your name and email address.</div>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn-submit" style="width:auto; padding:0.6rem 1.5rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Update Password -->
        <div class="card">
            <div class="card-title" style="margin-bottom:0.25rem;">Change Password</div>
            <div style="font-size:0.82rem; color:var(--muted); margin-bottom:1.25rem;">Use a strong password to keep your account secure.</div>

            <form method="POST" action="{{ route('profile.update-password') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="form-input" required>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="password">New Password</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>

                <button type="submit" class="btn-submit" style="width:auto; padding:0.6rem 1.5rem;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Update Password
                </button>
            </form>
        </div>
    </div>

    <!-- Account Info -->
    <div class="card">
        <div class="card-title" style="margin-bottom:1rem;">Account Overview</div>
        <div style="display:flex; align-items:center; gap:1.25rem; flex-wrap:wrap;">
            <div style="width:64px; height:64px; border-radius:50%; background:var(--accent); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.5rem; font-weight:600; flex-shrink:0;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:1.1rem; font-weight:600; color:var(--text);">{{ $user->name }}</div>
                <div style="font-size:0.85rem; color:var(--muted);">{{ $user->email }}</div>
                <div style="font-size:0.75rem; color:var(--muted); margin-top:0.25rem;">Member since {{ $user->created_at->format('F j, Y') }}</div>
            </div>
        </div>
    </div>
@endsection
