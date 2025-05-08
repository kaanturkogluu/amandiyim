<?php
require_once __DIR__ . '/../../../classes/Helper.php';
require_once __DIR__ . '/../../../classes/Session.php';
require_once __DIR__ . '/../../../classes/CsrfToken.php';
$helper = Helper::getInstance();
$session = Session::getInstance();
$csrf =CsrfToken::getInstance(); 

require_once __DIR__."/permission.php";
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Amandiyim</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= Helper::url() ?>/panel/admin/assets/css/style.css">

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);


    $page_css = [
        'reports.php' => 'reports.css',
        'settings.php' => 'settings.css'
    ];

    if (isset($page_css[$current_page])) {
        echo '<link rel="stylesheet" href="../assets/css/' . $page_css[$current_page] . '">';
    }
    ?>
</head>

<body>
    <!-- Header -->
    <header class="admin-header">
        <div class="header-left">
            <button class="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <span class="admin-logo">Amandiyim</span>
        </div>
        <div class="admin-profile">
            <img src="<?=Helper::url()?>/panel/admin/assets/images/user.webp" alt="Admin Avatar">
            <span>Admin</span>
            <div class="admin-dropdown">
                <div class="admin-dropdown-menu">
                    <a href="#" class="admin-dropdown-item">
                        <i class="fas fa-user"></i>
                        Profil
                    </a>
                    <a href="#" class="admin-dropdown-item">
                        <i class="fas fa-cog"></i>
                        Ayarlar
                    </a>
                    <div class="admin-divider"></div>
                    <a href="<?=Helper::controller("LogoutController")?>" class="admin-dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Çıkış Yap
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-logo">
        </div>
        <nav class="sidebar-nav">
            <a href="<?=Helper::adminPanelView("anasayfa")?>" class="sidebar-nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i>
                Ana Sayfa
            </a>
            <a href="stores.php" class="sidebar-nav-item <?php echo $current_page == 'stores.php' ? 'active' : ''; ?>">
                <i class="fas fa-store"></i>
                Mağazalar
            </a>
            <a href="campaigns.php"
                class="sidebar-nav-item <?php echo $current_page == 'campaigns.php' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i>
                Kampanyalar
            </a>
            <a href="users.php" class="sidebar-nav-item <?php echo $current_page == 'users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                Kullanıcılar
            </a>
            <a href="reports.php"
                class="sidebar-nav-item <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-bar"></i>
                Raporlar
            </a>
            <div class="sidebar-divider"></div>
            <a href="settings.php"
                class="sidebar-nav-item <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i>
                Ayarlar
            </a>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="admin-content-wrapper">