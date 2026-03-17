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

    @stack('scripts')
    </body>

    </html>
