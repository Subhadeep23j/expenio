@extends('layout.app')

@section('title', $title)
@section('page-title', $title)
@section('page-subtitle', $subtitle ?? 'This feature is coming soon')

@section('content')

    <div class="card" style="text-align: center; padding: 4rem 2rem;">

        <div style="margin-bottom: 1.5rem;">
            {!! $icon !!}
        </div>

        <div class="serif" style="font-size: 1.75rem; font-weight: 600; color: var(--text); margin-bottom: 0.5rem;">
            {{ $title }}
        </div>

        <p style="font-size: 0.9rem; color: var(--muted); max-width: 400px; margin: 0 auto 2rem; line-height: 1.6;">
            {{ $description }}
        </p>

        <a href="{{ route('expenses.index') }}"
            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.5rem;
                   background: var(--accent); color: white; border-radius: 8px; font-size: 0.875rem;
                   font-weight: 500; text-decoration: none; transition: background 0.15s;"
            onmouseover="this.style.background='var(--accent-lt)'" onmouseout="this.style.background='var(--accent)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="1" x2="12" y2="23" />
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
            </svg>
            Go to Expenses
        </a>
    </div>

@endsection
