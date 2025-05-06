// Sidebar Toggle Function
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.mobile-overlay');
    const mainContent = document.querySelector('.main-content');
    
    sidebar.classList.toggle('show');
    
    // Create overlay if it doesn't exist
    if (!overlay) {
        const newOverlay = document.createElement('div');
        newOverlay.className = 'mobile-overlay';
        document.body.appendChild(newOverlay);
        newOverlay.classList.add('show');
        
        // Close sidebar when clicking overlay
        newOverlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            newOverlay.classList.remove('show');
        });
    } else {
        overlay.classList.toggle('show');
    }
    
    // Prevent body scroll when sidebar is open
    if (sidebar.classList.contains('show')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = '';
    }
}

// Close sidebar when clicking outside
document.addEventListener('click', (e) => {
    const sidebar = document.querySelector('.sidebar');
    const toggleButton = document.querySelector('.toggle-sidebar');
    
    if (sidebar && sidebar.classList.contains('show')) {
        if (!sidebar.contains(e.target) && !toggleButton.contains(e.target)) {
            toggleSidebar();
        }
    }
});

// Close sidebar on window resize if screen becomes larger
window.addEventListener('resize', () => {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.mobile-overlay');
    
    if (window.innerWidth > 1024) {
        if (sidebar) {
            sidebar.classList.remove('show');
        }
        if (overlay) {
            overlay.classList.remove('show');
        }
        document.body.style.overflow = '';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.mobile-overlay');
    const body = document.body;

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            if (overlay) {
                overlay.classList.toggle('show');
            }
            body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        });

        // Close sidebar when clicking overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                overlay.classList.remove('show');
                body.style.overflow = '';
            });
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !menuToggle.contains(event.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                if (overlay) {
                    overlay.classList.remove('show');
                }
                body.style.overflow = '';
            }
        });
    }

    // User Menu Dropdown
    const userMenuButton = document.querySelector('.user-menu-button');
    const dropdownMenu = document.querySelector('.dropdown-menu');

    if (userMenuButton && dropdownMenu) {
        userMenuButton.addEventListener('click', function(event) {
            event.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }

    // Search Box Focus
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    }

    // Modal Handling
    const modalTriggers = document.querySelectorAll('[data-modal]');
    const modals = document.querySelectorAll('.modal');

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.querySelector(`#${modalId}`);
            if (modal) {
                modal.classList.add('show');
                body.style.overflow = 'hidden';
            }
        });
    });

    modals.forEach(modal => {
        const closeButtons = modal.querySelectorAll('.modal-close, .modal-cancel');
        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                modal.classList.remove('show');
                body.style.overflow = '';
            });
        });

        // Close modal when clicking outside
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                body.style.overflow = '';
            }
        });
    });

    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                event.preventDefault();
            }
        });
    });

    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.card, .campaign-card, .store-card');
    cards.forEach(card => {
        card.classList.add('fade-in');
    });

    // Handle responsive tables
    const tables = document.querySelectorAll('.table');
    tables.forEach(table => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('table-wrapper');
        table.parentNode.insertBefore(wrapper, table);
        wrapper.appendChild(table);
    });
}); 