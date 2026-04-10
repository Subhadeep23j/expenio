    </div>

    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay"
        style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:40; background:rgba(0,0,0,.45);"
        onclick="document.getElementById('sidebar').classList.remove('open'); this.style.display='none';">
    </div>

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
