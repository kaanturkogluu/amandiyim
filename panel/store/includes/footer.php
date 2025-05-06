    </div> <!-- store-content-wrapper end -->

    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.store-sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            const contentWrapper = document.querySelector('.store-content-wrapper');
            const storeProfile = document.querySelector('.store-profile');
            const storeDropdown = document.querySelector('.store-dropdown');

            // Toggle mobile menu
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
                contentWrapper.classList.toggle('sidebar-active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
                contentWrapper.classList.remove('sidebar-active');
                document.body.style.overflow = '';
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                        contentWrapper.classList.remove('sidebar-active');
                        document.body.style.overflow = '';
                    }
                }
            });

            // Toggle store dropdown
            storeProfile.addEventListener('click', function(e) {
                e.stopPropagation();
                storeDropdown.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!storeProfile.contains(e.target)) {
                    storeDropdown.classList.remove('active');
                }
            });

            // Close dropdown when pressing ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    storeDropdown.classList.remove('active');
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    contentWrapper.classList.remove('sidebar-active');
                    document.body.style.overflow = '';
                    storeDropdown.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html> 