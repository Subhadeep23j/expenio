@include('partials.header')

        {{-- ── Page Content ── --}}
        <main id="page-content">
            @yield('content')
        </main>

        {{-- ── Footer ── --}}
        @include('partials.footer-content')

@include('partials.footer')
