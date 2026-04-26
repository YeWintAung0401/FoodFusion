<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodFusion Admin</title>
    <link rel="stylesheet" href="./adminStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="ff-admin">
    <!-- Navigation Bar -->
    <nav class="ff-admin-nav" aria-label="Main navigation">
        <!-- Mobile Toggle Button -->
        <button class="ff-admin-nav__mobile-toggle" aria-expanded="false" aria-controls="ff-admin-nav-container">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>

        <!-- Branding -->
        <div class="ff-admin-nav__brand">
            <img src="../img/admin.png" alt="FoodFusion" class="ff-admin-nav__brand-logo">
            <h1 class="ff-admin-nav__brand-title">Admin Dashboard</h1>
        </div>

        <!-- Navigation Container -->
        <div id="ff-admin-nav-container" class="ff-admin-nav__container">
            <!-- Navigation Links -->
            <ul class="ff-admin-nav__list">
                <li class="ff-admin-nav__item">
                    <a href="./index.php" class="ff-admin-nav__link">
                        <i class="fas fa-tachometer-alt ff-admin-nav__icon"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="ff-admin-nav__item ff-admin-nav__dropdown">
                    <button class="ff-admin-nav__dropdown-toggle" aria-expanded="false" aria-controls="ff-admin-users-menu">
                        <i class="fas fa-users-cog ff-admin-nav__icon"></i>
                        <span>User Management</span>
                    </button>
                    <ul id="ff-admin-users-menu" class="ff-admin-nav__dropdown-menu">
                        <li class="ff-admin-nav__dropdown-item">
                            <a href="./usersList.php" class="ff-admin-nav__dropdown-link">
                                <i class="fas fa-list ff-admin-nav__icon"></i>
                                <span>Users List</span>
                            </a>
                        </li>
                        <li class="ff-admin-nav__dropdown-item">
                            <a href="./usersMessages.php" class="ff-admin-nav__dropdown-link">
                                <i class="fas fa-message ff-admin-nav__icon"></i>
                                <span>User Messages</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="ff-admin-nav__item ff-admin-nav__dropdown">
                    <button class="ff-admin-nav__dropdown-toggle" aria-expanded="false" aria-controls="ff-admin-recipes-menu">
                        <i class="fas fa-utensils ff-admin-nav__icon"></i>
                        <span>Recipes</span>
                    </button>
                    <ul id="ff-admin-recipes-menu" class="ff-admin-nav__dropdown-menu">
                        <li class="ff-admin-nav__dropdown-item">
                            <a href="./recipesList.php" class="ff-admin-nav__dropdown-link">
                                <i class="fas fa-list ff-admin-nav__icon"></i>
                                <span>All Recipes</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- User Area -->
            <div class="ff-admin-nav__user-area">
                <a href="../user/logout.php" class="ff-admin-nav__logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ff-admin-nav__logout-text">Logout</span>
                </a>
            </div>
        </div>
    </nav>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileToggle = document.querySelector('.ff-admin-nav__mobile-toggle');
            const navContainer = document.querySelector('.ff-admin-nav__container');
            const dropdownToggles = document.querySelectorAll('.ff-admin-nav__dropdown-toggle');
            const currentPath = window.location.pathname;

            // Mobile toggle functionality
            mobileToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                navContainer.classList.toggle('ff-admin-nav__container--expanded');
            });

            // Initialize dropdown behavior based on screen size
            function initDropdowns() {
                if (window.innerWidth > 1200) {
                    // Desktop - hover behavior
                    dropdownToggles.forEach(toggle => {
                        toggle.addEventListener('mouseenter', openDropdown);
                        toggle.parentElement.addEventListener('mouseleave', closeDropdown);
                        toggle.removeEventListener('click', toggleDropdown);
                    });
                } else {
                    // Mobile - click behavior
                    dropdownToggles.forEach(toggle => {
                        toggle.addEventListener('click', toggleDropdown);
                        toggle.removeEventListener('mouseenter', openDropdown);
                        toggle.parentElement.removeEventListener('mouseleave', closeDropdown);
                    });
                }
            }

            // Dropdown functions
            function openDropdown() {
                const dropdown = this.nextElementSibling;
                closeAllDropdowns();
                dropdown.classList.add('ff-admin-nav__dropdown-menu--show');
                this.setAttribute('aria-expanded', 'true');
            }

            function closeDropdown() {
                const dropdown = this.querySelector('.ff-admin-nav__dropdown-menu');
                if (dropdown) {
                    dropdown.classList.remove('ff-admin-nav__dropdown-menu--show');
                    this.querySelector('.ff-admin-nav__dropdown-toggle').setAttribute('aria-expanded', 'false');
                }
            }

            function toggleDropdown(e) {
                e.preventDefault();
                const dropdown = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                closeAllDropdowns();
                
                if (!isExpanded) {
                    dropdown.classList.add('ff-admin-nav__dropdown-menu--show');
                    this.setAttribute('aria-expanded', 'true');
                }
            }

            function closeAllDropdowns() {
                document.querySelectorAll('.ff-admin-nav__dropdown-menu').forEach(menu => {
                    menu.classList.remove('ff-admin-nav__dropdown-menu--show');
                    const toggle = menu.previousElementSibling;
                    if (toggle && toggle.classList.contains('ff-admin-nav__dropdown-toggle')) {
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Highlight active link
            function highlightActiveLink() {
                const links = document.querySelectorAll(`
                    .ff-admin-nav__link:not(.ff-admin-nav__dropdown-toggle), 
                    .ff-admin-nav__dropdown-link
                `);
                
                links.forEach(link => {
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('ff-admin-nav__link--active');
                        
                        // Expand parent dropdown if exists
                        const dropdown = link.closest('.ff-admin-nav__dropdown-menu');
                        if (dropdown) {
                            dropdown.classList.add('ff-admin-nav__dropdown-menu--show');
                            const toggle = document.querySelector(`[aria-controls="${dropdown.id}"]`);
                            if (toggle) toggle.setAttribute('aria-expanded', 'true');
                        }
                    }
                });
            }

            // Close dropdowns when clicking outside (mobile only)
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 1200 && 
                    !e.target.closest('.ff-admin-nav__container')) {
                    closeAllDropdowns();
                }
            });

            // Handle window resize
            window.addEventListener('resize', initDropdowns);

            // Initialize
            initDropdowns();
            highlightActiveLink();
        });
    </script>
</body>
</html>