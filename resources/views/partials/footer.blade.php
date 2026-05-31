    </div>

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:40; background:rgba(0,0,0,.45);"
        onclick="document.getElementById('sidebar').classList.remove('open'); this.style.display='none';">
    </div>

    <script>
        (function() {
            const loader = document.getElementById('global-page-loader');
            if (!loader) {
                return;
            }

            let isHidden = false;
            const hardTimeoutMs = 15000;

            const showLoader = function() {
                isHidden = false;
                loader.classList.remove('is-hidden');
                loader.setAttribute('aria-hidden', 'false');
            };

            const hideLoader = function() {
                if (isHidden) {
                    return;
                }

                isHidden = true;
                loader.classList.add('is-hidden');
                loader.setAttribute('aria-hidden', 'true');
            };

            if (document.readyState === 'complete') {
                window.requestAnimationFrame(hideLoader);
            } else {
                window.addEventListener('load', hideLoader, {
                    once: true
                });
            }

            window.setTimeout(hideLoader, hardTimeoutMs);

            document.addEventListener('click', function(event) {
                const link = event.target.closest('a[href]');
                if (!link) {
                    return;
                }

                if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event
                    .shiftKey || event.altKey) {
                    return;
                }

                if (link.target === '_blank' || link.hasAttribute('download')) {
                    return;
                }

                const href = link.getAttribute('href') || '';
                if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
                    return;
                }

                const nextUrl = new URL(link.href, window.location.href);
                if (nextUrl.origin !== window.location.origin) {
                    return;
                }

                showLoader();
            });

            document.addEventListener('submit', function(event) {
                const form = event.target;
                if (!(form instanceof HTMLFormElement)) {
                    return;
                }

                showLoader();
            });
        })();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (!sidebar || !overlay) {
                return;
            }

            const closeSidebar = () => {
                sidebar.classList.remove('open');
                overlay.style.display = 'none';
            };

            document.querySelectorAll('#sidebar .nav-link').forEach((link) => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        closeSidebar();
                    }
                });
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifWrap = document.getElementById('topbar-notif-wrap');
            const notifToggle = document.getElementById('topbar-notif-toggle');
            const notifMenu = document.getElementById('topbar-notif-menu');

            if (!notifWrap || !notifToggle || !notifMenu) {
                return;
            }

            const openMenu = () => {
                notifMenu.classList.add('open');
                notifToggle.classList.add('open');
                notifToggle.setAttribute('aria-expanded', 'true');
            };

            const closeMenu = () => {
                notifMenu.classList.remove('open');
                notifToggle.classList.remove('open');
                notifToggle.setAttribute('aria-expanded', 'false');
            };

            notifToggle.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (notifMenu.classList.contains('open')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            document.addEventListener('click', function(event) {
                if (!notifWrap.contains(event.target)) {
                    closeMenu();
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });

            if (notifMenu.dataset.autoshow === '1') {
                openMenu();
            }
        });
    </script>

    @stack('scripts')
    </body>

    </html>
