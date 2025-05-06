<?php
require_once __DIR__ . '/../../../classes/Helper.php';
require_once __DIR__ . '/../../../classes/Session.php';
$session = Session::getInstance();
$helper = Helper::getInstance();

 

// Kullanıcı bilgilerini al
$user = $session->get('user');
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Müşteri Paneli</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="customer-layout">
        <!-- Mobile Menu Toggle Button -->
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay"></div>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../assets/images/logo.png" alt="Logo">
                <h3>Müşteri Paneli</h3>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="anasayfa.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'anasayfa.php' ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i>
                            <span>Anasayfa</span>
                        </a>
                    </li>
                    <li>
                        <a href="campaigns.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'campaigns.php' ? 'active' : ''; ?>">
                            <i class="fas fa-tag"></i>
                            <span>Kampanyalar</span>
                        </a>
                    </li>
                    <li>
                        <a href="stores.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'stores.php' ? 'active' : ''; ?>">
                            <i class="fas fa-store"></i>
                            <span>Mağazalar</span>
                        </a>
                    </li>
                    <li>
                        <a href="favorites.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'favorites.php' ? 'active' : ''; ?>">
                            <i class="fas fa-heart"></i>
                            <span>Favoriler</span>
                        </a>
                    </li>
                    <li>
                        <a href="complaints.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'complaints.php' ? 'active' : ''; ?>">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Şikayetler</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <p>&copy; 2024 Müşteri Paneli</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Ara...">
                </div>
                <div class="user-menu">
                    <button class="user-menu-button">
                        <img src="../assets/images/avatar.png" alt="User Avatar">
                        <span>Kullanıcı Adı</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a href="profile.php">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="settings.php">
                            <i class="fas fa-cog"></i>
                            <span>Ayarlar</span>
                        </a>
                        <a href="<?=Helper::controller("LogoutController")?>">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Çıkış Yap</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Ana İçerik -->
            <div class="page-content">