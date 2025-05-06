    </div> <!-- End of admin-content-wrapper -->

    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.admin-sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            const contentWrapper = document.querySelector('.admin-content-wrapper');
            const adminProfile = document.querySelector('.admin-profile');
            const adminDropdown = document.querySelector('.admin-dropdown');

            function toggleMenu() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                contentWrapper.classList.toggle('sidebar-active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }

            menuToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleMenu();
            });

            overlay.addEventListener('click', toggleMenu);

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    const isClickInside = sidebar.contains(e.target) || menuToggle.contains(e.target);
                    if (!isClickInside && sidebar.classList.contains('active')) {
                        toggleMenu();
                    }
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    contentWrapper.classList.remove('sidebar-active');
                    document.body.style.overflow = '';
                }
            });

            // Handle escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                    toggleMenu();
                }
            });

            // Toggle admin dropdown
            adminProfile.addEventListener('click', function(e) {
                e.stopPropagation();
                adminDropdown.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!adminProfile.contains(e.target)) {
                    adminDropdown.classList.remove('active');
                }
            });

            // Close dropdown when pressing ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    adminDropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html> 