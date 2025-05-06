<?php
require_once __DIR__ . '/../../../classes/Helper.php';
require_once __DIR__ . '/../../../classes/Session.php';
require_once __DIR__ . '/../../../classes/CsrfToken.php';    
$session = Session::getInstance();
$helper = Helper::getInstance();
$csrf = CsrfToken::getInstance();

//  [_token] => 634468a75c9649b15b2562f077b838afb4093d6384641971b71412c8c3fb67d0
//  [user] => Array
//      (
//          [id] => 1
//          [store_location] => İstanbul
//          [store_owner_password] => $2y$10$gZK9tW.6LJGt1VOc/nfvy.UhMf5y/6jNiABuCUZyrTyWZj.rctgYm
//          [store_owner_mail] => test@store.com
//          [store_name] => Test Mağaza
//          [store_owner_phone] => 5551234567
//          [store_owner_name] => Test Mağaza Sahibi
//          [work_time] => 09:00 - 18:00
//          [store_adress] => Test Mağaza Adresi
//          [store_logo] => 
//          [store_phone] => 
//          [store_main_image] => 
//          [store_credits] => 10000
//          [store_statu] => active
//          [store_confirmed_ip_adress] => 
//          [created_at] => 2025-04-10 18:54:18
//          [updated_at] => 2025-04-10 18:54:18
//      )

//  [user_type] => store
//  [is_logged_in] => 1
//  [last_activity] => 1745142502
$storeData = $_SESSION['user'];


?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mağaza Paneli - Amandiyim</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?=Helper::url('panel/store/')?>assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <header class="store-header">
        <div class="header-left">
            <button class="menu-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?=Helper::storePanelView('anasayfa')?>" class="store-logo">Amandiyim</a>
        </div>
        <div class="store-profile">
            <img src="assets/images/profile.jpg" alt="Profile">
            <span>Test Mağaza</span>
            <div class="store-dropdown">
                <div class="store-dropdown-menu">
                    <a href="settings.php" class="store-dropdown-item">
                        <i class="fas fa-cog"></i> Ayarlar
                    </a>
                    <div class="store-divider"></div>
                    <a href="<?=Helper::controller('LogoutController')?>" class="store-dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Çıkış Yap
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <nav class="store-sidebar">
        <div class="sidebar-nav">
            <a href="<?=Helper::storePanelView('anasayfa')?>"
                class="sidebar-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-home"></i> Ana Sayfa
            </a>
            <a href="<?=Helper::storePanelView('campaigns/campaigns')?>"
                class="sidebar-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'campaigns.php' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i> Kampanyalarım
            </a>
            <a href="<?=Helper::storePanelView('analiz')?>"
                class="sidebar-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'analiz.php' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Analizler
            </a>
            <a href="<?=Helper::storePanelView('settings')?>"
                class="sidebar-nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Ayarlar
            </a>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="store-content-wrapper">