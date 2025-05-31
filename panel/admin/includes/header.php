<?php
require_once __DIR__ . '/../../../classes/Helper.php';
require_once __DIR__ . '/../../../classes/Session.php';
require_once __DIR__ . '/../../../classes/CsrfToken.php';
$helper = Helper::getInstance();
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();

define('classes', __DIR__ . "/../../../classes/");

require_once __DIR__ . "/permission.php";
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

    <style>
        /* Flash Messages */
        .flash-message {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 4px;
            color: white;
            font-weight: 500;
            z-index: 9999;
            display: none;
            opacity: 1;
            transition: opacity 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .flash-message.success {
            background-color: #28a745;
        }

        .flash-message.error {
            background-color: #dc3545;
        }

        .flash-message.warning {
            background-color: #ffc107;
            color: #212529;
        }

        .flash-message.info {
            background-color: #17a2b8;
        }

        .close-flash {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            padding: 0 5px;
            font-size: 18px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .close-flash:hover {
            opacity: 1;
        }

        /* Existing styles */
    </style>
</head>

<body>
    <?php if ($session->getFlash('success')): ?>
        <div class="flash-message success">
            <?= $session->getFlash('success') ?>
            <button type="button" class="close-flash">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($session->getFlash('error')): ?>
        <div class="flash-message error">
            <?= $session->getFlash('error') ?>
            <button type="button" class="close-flash">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($session->getFlash('warning')): ?>
        <div class="flash-message warning">
            <?= $session->getFlash('warning') ?>
            <button type="button" class="close-flash">&times;</button>
        </div>
    <?php endif; ?>

    <?php if ($session->getFlash('info')): ?>
        <div class="flash-message info">
            <?= $session->getFlash('info') ?>
            <button type="button" class="close-flash">&times;</button>
        </div>
    <?php endif; ?>

    <div class="admin-container">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="admin-logo">Amandiyim</span>
            </div>
            <div class="admin-profile">
                <img src="<?= Helper::url() ?>/panel/admin/assets/images/user.webp" alt="Admin Avatar">
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
                        <a href="<?= Helper::controller("LogoutController") ?>" class="admin-dropdown-item">
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
                <a href="<?= Helper::adminPanelView("anasayfa") ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i>
                    Ana Sayfa
                </a>
                <a href="<?= Helper::adminPanelView('stores') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'stores.php' ? 'active' : ''; ?>">
                    <i class="fas fa-store"></i>
                    Mağazalar
                </a>
                <a href="<?= Helper::adminPanelView('campaigns') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'campaigns.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tags"></i>
                    Kampanyalar
                </a> <a href="<?= Helper::adminPanelView('categories/categories') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'cartegories.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    Kategoriler
                </a>
                <a href="<?= Helper::adminPanelView('users') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'users.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i>
                    Kullanıcılar
                </a>
                <a href="<?= Helper::adminPanelView('reports') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i>
                    Raporlar
                </a> <a href="<?= Helper::adminPanelView('stock/photos') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'photos.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i>
                    Stok Fotolar
                </a> </a> <a href="<?= Helper::adminPanelView('featured/featured') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'featrued.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i>
                    Öne Cıkarılanlar
                </a>
                <div class="sidebar-divider"></div>
                <a href="<?= Helper::adminPanelView('settings') ?>"
                    class="sidebar-nav-item <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                    <i class="fas fa-cog"></i>
                    Ayarlar
                </a>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="admin-content-wrapper">