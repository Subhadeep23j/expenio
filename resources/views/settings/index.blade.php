@extends('layout.app')
@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'Configure your preferences')

@section('content')
    <div class="grid-2" style="margin-bottom:2rem;">
        <!-- Currency -->
        <div class="card">
            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div class="card-icon" style="background:rgba(61,107,79,0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <div class="card-title">Currency</div>
                    <div style="font-size:0.78rem; color:var(--muted);">Indian Rupee (INR)</div>
                </div>
            </div>
            <div style="font-size:0.82rem; color:var(--muted);">Currency is set to INR. Multi-currency support will be available in a future update.</div>
        </div>

        <!-- App Version -->
        <div class="card">
            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div class="card-icon" style="background:rgba(80,120,200,0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#5078c8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <div>
                    <div class="card-title">App Info</div>
                    <div style="font-size:0.78rem; color:var(--muted);">Expenio v1.0</div>
                </div>
            </div>
            <div style="font-size:0.82rem; color:var(--muted);">Built with Laravel. Track your expenses, income, budgets and generate reports.</div>
        </div>
    </div>

    <div class="grid-2" style="margin-bottom:2rem;">
        <!-- Account -->
        <div class="card">
            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div class="card-icon" style="background:rgba(61,107,79,0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div>
                    <div class="card-title">Account</div>
                    <div style="font-size:0.78rem; color:var(--muted);">{{ $user->email }}</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" style="font-size:0.82rem; color:var(--accent); text-decoration:none;">Manage your profile &rarr;</a>
        </div>

        <!-- Data Export -->
        <div class="card">
            <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1rem;">
                <div class="card-icon" style="background:rgba(184,137,42,0.1);">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#b8892a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                </div>
                <div>
                    <div class="card-title">Export Data</div>
                    <div style="font-size:0.78rem; color:var(--muted);">Download your reports</div>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" style="font-size:0.82rem; color:var(--accent); text-decoration:none;">Go to Reports &rarr;</a>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="card" style="border-color:rgba(184,58,36,0.2);">
        <div class="card-title" style="color:var(--danger); margin-bottom:0.5rem;">Danger Zone</div>
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
            <div>
                <div style="font-size:0.875rem; color:var(--text);">Sign out of your account</div>
                <div style="font-size:0.78rem; color:var(--muted);">You will need to log in again to access your data.</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="padding:0.5rem 1.25rem; background:none; border:1px solid var(--danger); color:var(--danger); border-radius:8px; font-size:0.82rem; cursor:pointer; font-family:inherit; transition:all 0.15s;"
                    onmouseover="this.style.background='var(--danger)'; this.style.color='#fff';"
                    onmouseout="this.style.background='none'; this.style.color='var(--danger)';">
                    Sign Out
                </button>
            </form>
        </div>
    </div>
@endsection
