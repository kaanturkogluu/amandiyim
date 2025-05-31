<?php

require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/CsrfToken.php";
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Hatay Dörtyol'daki en güncel indirim ve kampanyaları keşfedin. Yerel mağazalar, marketler ve işletmelerde kaçırılmayacak fırsatlar sizleri bekliyor. Para tasarrufu yapmanın en kolay yolu!">

    <!-- Keywords -->
    <meta name="keywords"
        content="Dörtyol indirimler, Hatay kampanyalar, Dörtyol fırsatlar, Hatay alışveriş indirimleri, Dörtyol market indirimleri, Hatay Dörtyol kampanyalar, indirimli mağazalar Dörtyol, Hatay ekonomik alışveriş, Dörtyol uygun fiyatlar, Hatay Dörtyol fırsat takibi">
    <meta name="google-site-verification" content="GQoe3OVcbQHY4twx7lyJHR-DIaCeeckXE-1Bkc5tne8" />
    <!-- Open Graph Meta Tags (for social media sharing) -->
    <meta property="og:title" content="Hatay Dörtyol İndirimler ve Kampanyalar">
    <meta property="og:description"
        content="Hatay Dörtyol'daki en güncel indirim ve kampanyaları keşfedin. Yerel mağazalar, marketler ve işletmelerde kaçırılmayacak fırsatlar sizleri bekliyor.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://amandiyim.com/">

    <title>Aman Diym - Hatay / Dörtyol İndirimler ve Kampanyalar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/css.css">
    <!-- <link rel="stylesheet" href="../assets/css/style.css"> -->
</head>

<body>

    <!-- Header & Navigation -->
    <div class="preloader">
        <!-- SVG kodu buraya -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200">
            <defs>
                <linearGradient id="gradient-primary" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#6a11cb" />
                    <stop offset="100%" stop-color="#2575fc" />
                </linearGradient>
                <linearGradient id="gradient-secondary" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ff0844" />
                    <stop offset="100%" stop-color="#ffb199" />
                </linearGradient>
            </defs>

            <!-- Ana çember -->
            <circle cx="100" cy="100" r="70" fill="none" stroke="#8e44ad" stroke-width="4" stroke-dasharray="440"
                stroke-dashoffset="440">
                <animate attributeName="stroke-dashoffset" from="440" to="0" dur="2s" repeatCount="indefinite"
                    fill="freeze" calcMode="linear" />
            </circle>

            <!-- İç çember (dönen) -->
            <circle cx="100" cy="100" r="50" fill="none" stroke="url(#gradient-primary)" stroke-width="8">
                <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="3s"
                    repeatCount="indefinite" />
            </circle>

            <!-- Pulsing accent renk noktası -->
            <circle cx="100" cy="100" r="10" fill="#f1c40f">
                <animate attributeName="r" values="10;15;10" dur="1.5s" repeatCount="indefinite" />
                <animate attributeName="opacity" values="1;0.7;1" dur="1.5s" repeatCount="indefinite" />
            </circle>

            <!-- Dönen renkli parçalar -->
            <g>
                <circle cx="100" cy="30" r="8" fill="#3498db">
                    <animateTransform attributeName="transform" type="rotate" from="0 100 100" to="360 100 100" dur="2s"
                        repeatCount="indefinite" />
                </circle>

                <circle cx="100" cy="30" r="8" fill="#e74c3c">
                    <animateTransform attributeName="transform" type="rotate" from="120 100 100" to="480 100 100"
                        dur="2s" repeatCount="indefinite" />
                </circle>

                <circle cx="100" cy="30" r="8" fill="#2ecc71">
                    <animateTransform attributeName="transform" type="rotate" from="240 100 100" to="600 100 100"
                        dur="2s" repeatCount="indefinite" />
                </circle>
            </g>
        </svg>
        <div class="preloader-text">Yükleniyor...</div>
    </div>

    <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: var(--transition);
        }

        .preloader svg {
            width: 100px;
            height: 100px;
        }

        .preloader-text {
            margin-top: 20px;
            color: var(--primary);
            font-weight: bold;
            letter-spacing: 2px;
        }

        /* Sayfa yüklendiğinde preloader'ı gizlemek için */
        .preloader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .mobile-icon {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-icon {
                display: inline-block;
                margin-right: 8px;
            }
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .auth-buttons .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .auth-buttons {
                flex-direction: column;
                width: 100%;
            }

            .auth-buttons .btn {
                width: 100%;
                text-align: center;
            }
        }

        .mobile-only {
            display: none;
        }

        @media (max-width: 768px) {
            .mobile-only {
                display: block;
            }
        }
    </style>
    <script>
        window.addEventListener('load', function () {

            document.querySelector('.preloader').classList.add('hidden');

        });
    </script>
    <?php
    $userType = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'guest';
    $currentPath = $_SERVER['PHP_SELF'];
    ?>
    <header>
        <div class="nav-container container">
            <a href="anasayfa.php" class="logo">
                <!-- <i class="fas fa-percent"></i> -->
                <span>Amandiyim</span>
            </a>

            <nav class="nav-links">
                <a href="anasayfa.php" class="nav-link <?php echo $currentPath == '/anasayfa.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home mobile-icon"></i> Anasayfa
                </a>

                <a href="magazalar.php"
                    class="nav-link <?php echo $currentPath == '/magazalar.php' ? 'active' : ''; ?>">
                    <i class="fas fa-store mobile-icon"></i> Mağazalar
                </a> <a href="iletisim.php" class="nav-link ">
                    <i class="fas fa-envelope mobile-icon"></i> İletişim
                </a>
                <?php if ($userType === 'customer'): ?>
                    <a href="favorilerim.php"
                        class="nav-link <?php echo $currentPath == '/favorilerim.php' ? 'active' : ''; ?>">
                        <i class="fas fa-heart mobile-icon"></i> Favorilerim
                    </a>
                    <a href="profilim.php" class="nav-link <?php echo $currentPath == '/profilim.php' ? 'active' : ''; ?>">
                        <i class="fas fa-user mobile-icon"></i> Profilim
                    </a>
                <?php endif; ?>
            </nav>

            <div class="nav-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Kampanya ara...">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="auth-buttons">
                    <?php if ($userType === 'guest'): ?>
                        <a href="giris.php" class="btn btn-outline">Giriş Yap</a>
                        <a href="kayit.php" class="btn btn-primary">Kayıt Ol</a>
                    <?php else: ?>
                        <a href="<?= Helper::controller("LogoutController") ?>" class="btn btn-outline">Çıkış Yap</a>
                    <?php endif; ?>
                </div>
            </div>

            <button class="mobile-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="mobile-menu">
            <nav class="nav-links">
                <a href="anasayfa.php" class="nav-link <?php echo $currentPath == '/anasayfa.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Anasayfa
                </a>

                <a href="magazalar.php"
                    class="nav-link <?php echo $currentPath == '/magazalar.php' ? 'active' : ''; ?>">
                    <i class="fas fa-store"></i> Mağazalar
                </a>
                <?php if ($userType === 'customer'): ?>
                    <a href="favorilerim.php"
                        class="nav-link <?php echo $currentPath == '/favorilerim.php' ? 'active' : ''; ?>">
                        <i class="fas fa-heart"></i> Favorilerim
                    </a>
                    <a href="profilim.php" class="nav-link <?php echo $currentPath == '/profilim.php' ? 'active' : ''; ?>">
                        <i class="fas fa-user"></i> Profilim
                    </a>
                <?php endif; ?>
            </nav>
            <div class="nav-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Kampanya ara...">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="auth-buttons">
                    <?php if ($userType === 'guest'): ?>
                        <a href="giris.php" class="btn btn-outline">Giriş Yap</a>
                        <a href="kayit.php" class="btn btn-primary">Kayıt Ol</a>
                    <?php else: ?>
                        <a href="cikis.php" class="btn btn-outline">Çıkış Yap</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile menu toggle elements
            const mobileToggle = document.querySelector('.mobile-toggle');
            const mobileMenu = document.querySelector('.mobile-menu');

            // Header for scroll behavior
            const header = document.querySelector('header');

            // Variables for scroll tracking
            let lastScrollTop = 0;
            const scrollThreshold = 100; // Pixels to scroll before hiding navbar

            // Mobile menu toggle functionality
            function toggleMobileMenu() {
                mobileMenu.classList.toggle('active');

                // Prevent body scrolling when menu is open
                if (mobileMenu.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = 'auto';
                }
            }

            // Add click event to mobile toggle button
            mobileToggle.addEventListener('click', toggleMobileMenu);

            // Close mobile menu when clicking outside
            document.addEventListener('click', (e) => {
                if (mobileMenu.classList.contains('active') &&
                    !mobileMenu.contains(e.target) &&
                    !mobileToggle.contains(e.target)) {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            });

            // Mobile menu links close menu when clicked
            const mobileMenuLinks = document.querySelectorAll('.mobile-menu .nav-link');
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            });

            // Scroll event for navbar hide/show
            window.addEventListener('scroll', () => {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                const scrollDirection = scrollTop > lastScrollTop ? 'down' : 'up';

                // Only apply transformations if scroll is beyond threshold
                if (scrollTop > scrollThreshold) {
                    if (scrollDirection === 'down') {
                        // Hide navbar when scrolling down
                        header.style.transform = 'translateY(-100%)';
                        header.style.transition = 'transform 0.3s ease';
                    } else {
                        // Show navbar when scrolling up
                        header.style.transform = 'translateY(0)';
                        header.style.transition = 'transform 0.3s ease';
                    }
                } else {
                    // Always show navbar at top of page
                    header.style.transform = 'translateY(0)';
                }

                // Update last scroll position
                lastScrollTop = scrollTop;
            });

            // Preloader handling
            window.addEventListener('load', function () {
                const preloader = document.querySelector('.preloader');
                if (preloader) {
                    preloader.classList.add('hidden');
                }
            });
        });
    </script>