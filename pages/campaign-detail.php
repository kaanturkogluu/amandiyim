<?php
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../classes/Campaigns.php';
require_once __DIR__ . '/../classes/Stores.php';
require_once __DIR__ . '/../classes/CampaingsView.php';
// Kampanya ID'sini al
$campaignId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Kampanya sınıfını başlat
$campaignsObj = new Campaigns();
$campaingsViewObj = new CampaingsView();
$storesObj = new Stores();
// Görüntülenme sayısını artır
$campaingsViewObj->updateCampaignView($campaignId);


// Kampanya detaylarını getir
$campaign = $campaignsObj->find($campaignId);
$store = $storesObj->find($campaign['store_id']);


// Kampanya bulunamadıysa veya aktif değilse 404 sayfasına yönlendir


// Görüntülenme sayısını artır
// $campaignsObj->incrementViewCount($campaignId);

// Son bakılan kampanya id'sini cookie'ye yaz
if (isset($campaignId) && $campaignId > 0) {
    $_SESSION['last_campaign_id']= $campaignId; // 7 gün sakla
}
?>

<div class="campaign-detail-page">
    <!-- Kampanya Banner -->
    <div class="campaign-banner">
        <!-- Yarı saydam overlay -->
        <div class="banner-overlay">
            <div class="container">
                <!-- Mağaza Başlık Bilgileri -->
                <div class="store-header">
                    <div class="store-header-content">
                        <div class="store-image">
                            <img src="<?= htmlspecialchars($store['store_main_image']) ?>" height="150px"
                                alt="<?= htmlspecialchars($store['store_name']) ?>">
                            <div class="store-badge">
                                <i class="fas fa-check-circle"></i>
                                <span>Onaylı Mağaza</span>
                            </div>
                        </div>
                        <div class="store-info">
                            <nav class="store-breadcrumb">
                                <a href="">
                                    <i class="fas fa-home"></i>
                                </a>
                                <span class="separator">/</span>
                                <a href="/stores">Mağazalar</a>
                                <span class="separator">/</span>
                                <span class="current"><?= htmlspecialchars($store['store_name']) ?></span>
                            </nav>
                            <h6 class="store-name"><?= htmlspecialchars($store['store_name']) ?></h6>
                            <p class="store-address">
                                <i class="fas fa-map-marker-alt"></i>
                                <?= htmlspecialchars($store['store_adress']) ?>
                            </p>
                            <div class="store-meta">
                                <div class="meta-item">
                                    <i class="fas fa-phone"></i>
                                    <a
                                        href="tel:<?= htmlspecialchars($store['store_phone']) ?>"><?= htmlspecialchars($store['store_phone']) ?></a>
                                </div>

                                <div class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    <span>09:00 - 18:00</span>
                                </div>
                            </div>
                            <div class="store-actions">
                                <button class="btn-local-address" onclick="openLocalAddressModal()">
                                    <i class="fas fa-map"></i>
                                    Yerel Adres
                                </button>
                                <button class="btn-location"
                                    onclick="openGoogleMaps('<?= htmlspecialchars($store['store_location']) ?>')">
                                    <i class="fas fa-map-marked-alt"></i>
                                    Yol Tarifi Al
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Yerel Adres Modal -->
    <div class="local-address-modal" id="localAddressModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detaylı Adres Tarifi</h2>
                <button class="close-modal" onclick="closeLocalAddressModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="address-detail">
                    <div class="address-section">
                        <h3>Mağaza Yerel Adresi</h3>

                        <p class="location-detail"><?= htmlspecialchars($store['local_adress']) ?></p>
                    </div>

                    <!-- <div class="address-section">
                        <h3>Yakın Çevre</h3>
                        <ul class="landmarks">
                            <li><i class="fas fa-building"></i> Yakındaki önemli binalar ve işyerleri</li>
                            <li><i class="fas fa-bus"></i> Toplu taşıma durakları</li>
                            <li><i class="fas fa-road"></i> Ana caddeler ve sokaklar</li>
                            <li><i class="fas fa-parking"></i> Park yerleri</li>
                        </ul>
                    </div> -->

                    <div class="address-section">
                        <h3>İletişim</h3>
                        <p><i class="fas fa-phone"></i> <?= htmlspecialchars($store['store_phone']) ?></p>
                        <p><i class="fas fa-clock"></i> Çalışma Saatleri: 09:00 - 18:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="campaign-content">
            <!-- Kampanya Başlığı ve Süre -->
            <div class="campaign-header">
                <h1><?= htmlspecialchars($campaign['campaign_title']) ?></h1>
                <div class="campaign-timer" data-end="<?= $campaign['campaign_end_time'] ?>">
                    <div class="timer-label">Kampanyanın Bitmesine:</div>
                    <div class="timer-value">
                        <span class="days">00</span>:<span class="hours">00</span>:<span class="minutes">00</span>:<span
                            class="seconds">00</span>
                    </div>
                </div>
            </div>

            <!-- Kampanya Detayları -->
            <div class="campaign-details">
                <?php if ($campaign['campaign_disscount_off']): ?>
                <div class="discount-badge">
                    %<?= (int) $campaign['campaign_disscount_off'] ?> İndirim
                </div>
                <?php endif; ?>

                <div class="campaign-description">
                    <?= nl2br(htmlspecialchars($campaign['campaign_sub_description'])) ?>
                </div>
                <div class="campaign-description">
                    <?= nl2br(htmlspecialchars($campaign['campaign_details'])) ?>
                </div>

                <?php if ($campaign['campaign_min_purchase']): ?>
                <div class="purchase-info">
                    <i class="fas fa-info-circle"></i>
                    Minimum <?= number_format((int)$campaign['campaign_min_purchase'], 2, ',', '.') ?> TL ve üzeri
                    alışverişlerde
                    geçerlidir.
                </div>
                <?php endif; ?>

                <!-- Kampanya Koşulları -->
                <div class="campaign-terms">
                    <h3>Kampanya Koşulları</h3>
                    <ul>
                        <li>Kampanya <?= date('d.m.Y H:i', strtotime($campaign['campaign_end_time'])) ?> tarihine kadar
                            geçerlidir.</li>
                        <?php if ($campaign['campaign_type'] == 'discount'): ?>
                        <li>İndirim oranı seçili ürünlerde geçerlidir.</li>
                        <?php elseif ($campaign['campaign_type'] == 'bogo'): ?>
                        <li>Bir ürün alana bir ürün bedava kampanyası seçili ürünlerde geçerlidir.</li>
                        <?php elseif ($campaign['campaign_type'] == 'bundle'): ?>
                        <li>Paket indirimi seçili ürün gruplarında geçerlidir.</li>
                        <?php endif; ?>
                        <li>Diğer kampanyalarla birleştirilemez.</li>
                        <li>Kampanya stoklarla sınırlıdır.</li>
                    </ul>
                </div>

                <!-- Kampanyaya Katıl Butonu -->
                <div class="campaign-action">
                    <?php
                    $lastCampaignId = isset($_COOKIE['last_campaign_id']) ? (int)$_COOKIE['last_campaign_id'] : 0;
                    $backUrl = 'anasayfa.php#campaigns';
                    if ($lastCampaignId && $lastCampaignId !== $campaignId) {
                        $backUrl = 'campaign-detail.php?id=' . $lastCampaignId . '&store=' . urlencode($_GET['store'] ?? '');
                    }
                    ?>
                    <a href="<?=$backUrl?>" class="btn-shop-now" style="background:#eee;color:#333;margin-right:12px;">
                        <i class="fas fa-arrow-left"></i> Kampanyalara Geri Dön
                    </a>
                    <a href="magaza-detay.php?id=<?=$_GET['store']?>" class="btn-shop-now">
                        Mağazaya Git
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.campaign-banner {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
    background: #000;
    margin-top: 80px;
    /* Navbar yüksekliği kadar margin */
}

.banner-image {
    width: 100%;
    height: 100%;
    position: relative;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.9;
}

/* Overlay */
.banner-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg,
            rgba(88, 86, 217, 0.85) 0%,
            rgba(255, 45, 83, 0.75) 100%);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    color: #fff;
    display: flex;
    align-items: center;
    padding: 30px 0;
}

.store-header {
    width: 100%;
    padding: 40px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.store-header-content {
    display: flex;
    align-items: flex-start;
    gap: 50px;
    position: relative;
}

.store-image {
    position: relative;
    flex-shrink: 0;
    padding: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 25px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.store-image:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
}

.store-image img {
    width: 220px;
    height: 220px;
    border-radius: 20px;
    object-fit: cover;
    border: 3px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
}

.store-image:hover img {
    transform: scale(1.02);
    border-color: rgba(255, 255, 255, 0.5);
}

.store-badge {
    position: absolute;
    bottom: -20px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 10px 25px;
    border-radius: 30px;
    font-size: 14px;
    white-space: nowrap;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    z-index: 1;
}

.store-badge i {
    font-size: 16px;
}

.store-badge:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateX(-50%) translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.store-info {
    flex: 1;
    max-width: 600px;
    /* Bilgilerin çok fazla genişlememesi için */
    padding: 10px 0;
}

.store-breadcrumb {
    display: flex;
    align-items: center;

    gap: 10px;
    margin-bottom: 15px;
    font-size: 14px;
    margin: 5px;

}


.store-breadcrumb a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: color 0.3s ease;
}

.store-breadcrumb a:hover {
    color: #fff;
}

.store-breadcrumb .separator {
    color: rgba(255, 255, 255, 0.6);
}

.store-breadcrumb .current {
    color: #fff;
}

.store-name {
    font-size: 36px;
    font-weight: 700;
    margin: 0 0 15px 0;
    color: #fff;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    letter-spacing: -0.5px;
}

.store-address {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 0 0 20px 0;
    color: rgba(255, 255, 255, 0.9);
    font-size: 16px;
    padding: 10px 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.store-meta {
    display: flex;
    gap: 25px;
    margin-bottom: 25px;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-size: 15px;
    transition: all 0.3s ease;
}

.meta-item:hover {
    transform: translateY(-2px);
}

.meta-item i {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.8);
}

.meta-item a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.meta-item a:hover {
    color: #fff;
}

.store-actions {
    display: flex;
    gap: 15px;
}

.btn-local-address {

    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    border: none;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.btn-location {

    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 25px;
    border: none;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
}

.btn-local-address:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.btn-location:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.campaign-detail-page {
    background-color: #f8f9fa;
    min-height: 100vh;
}

.campaign-banner {
    width: 100%;
    height: 400px;
    overflow: hidden;
    position: relative;
    background: #000;
}

.banner-image {
    width: 100%;
    height: 100%;
}

.banner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.9;
}

.campaign-content {
    margin-top: -50px;
    position: relative;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-bottom: 50px;
}

.campaign-header {
    text-align: center;
    margin-bottom: 30px;
}

.campaign-header h1 {
    font-size: 32px;
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
}

.campaign-timer {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    display: inline-block;
}

.timer-label {
    font-size: 14px;
    color: #666;
    margin-bottom: 5px;
}

.timer-value {
    font-size: 24px;
    font-weight: 600;
    color: #dc3545;
}

.timer-value span {
    background: #dc3545;
    color: #fff;
    padding: 5px 10px;
    border-radius: 5px;
    margin: 0 2px;
}

.campaign-details {
    max-width: 800px;
    margin: 0 auto;
}

.discount-badge {
    display: inline-block;
    background: #dc3545;
    color: #fff;
    padding: 10px 20px;
    border-radius: 25px;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
}

.campaign-description {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 30px;
}

.purchase-info {
    background: #e9ecef;
    padding: 15px;
    border-radius: 8px;
    color: #495057;
    font-size: 14px;
    margin-bottom: 30px;
}

.purchase-info i {
    color: #007bff;
    margin-right: 5px;
}

.campaign-terms {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.campaign-terms h3 {
    font-size: 18px;
    color: #333;
    margin-bottom: 15px;
}

.campaign-terms ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.campaign-terms li {
    position: relative;
    padding-left: 20px;
    margin-bottom: 10px;
    color: #666;
}

.campaign-terms li:before {
    content: "•";
    color: #dc3545;
    position: absolute;
    left: 0;
    font-size: 20px;
    line-height: 1;
}

.campaign-action {
    text-align: center;
    margin-top: 40px;
}

.btn-shop-now {
    display: inline-flex;
    align-items: center;
    background: #dc3545;
    color: #fff;
    padding: 15px 30px;
    border-radius: 30px;
    font-size: 18px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-shop-now:hover {
    background: #c82333;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
}

.btn-shop-now i {
    margin-left: 10px;
    transition: transform 0.3s ease;
}

.btn-shop-now:hover i {
    transform: translateX(5px);
}

.store-map {
    display: none;
}

#map,
.btn-directions {
    display: none;
}

@media (max-width: 1200px) {
    .store-header-content {
        flex-direction: column;
        align-items: center;
    }



    .store-breadcrumb {
        justify-content: center;
    }

    .store-info {
        width: 100%;
        max-width: none;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .campaign-banner {
        height: auto;
        min-height: 600px;
        margin-top: 60px;
        /* Mobilde navbar daha alçak olabilir */
    }

    .banner-overlay {
        padding: 20px 0;
    }

    .store-header {
        padding: 25px;
    }

    .campaign-content {
        margin-top: -30px;
        padding: 20px;
    }

    .campaign-header h1 {
        font-size: 24px;
    }

    .timer-value {
        font-size: 20px;
    }

    .discount-badge {
        font-size: 16px;
    }

    .btn-shop-now {
        width: 100%;
        justify-content: center;
    }

    .store-header {
        padding: 20px;
    }

    .store-header-content {
        flex-direction: column;
        text-align: center;
        gap: 40px;
    }

    .store-image {
        padding: 6px;
    }

    .store-image img {
        width: 180px;
        height: 180px;
    }

    .store-name {
        font-size: 28px;
    }

    .store-meta {
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .store-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        width: 100%;
        margin-top: 15px;
    }

    .btn-local-address,
    .btn-location {
        width: 100%;
        justify-content: center;
    }

    .store-header-content {
        gap: 25px;
    }

    .store-info {
        padding: 0;
    }

    .modal-content {
        width: 95%;
        margin: 20px;
    }

    .modal-header h2 {
        font-size: 20px;
    }

    #map {
        height: 250px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .store-image img {
        width: 180px;
        height: 180px;
    }
}

/* Local Address Modal Styles */
.local-address-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.local-address-modal.active {
    display: flex;
    opacity: 1;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    width: 90%;
    max-width: 600px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}

.local-address-modal.active .modal-content {
    transform: translateY(0);
}

.modal-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h2 {
    margin: 0;
    font-size: 24px;
    color: #333;
}

.close-modal {
    background: none;
    border: none;
    font-size: 24px;
    color: #666;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
}

.close-modal:hover {
    color: #333;
}

.modal-body {
    padding: 30px;
}

.address-section {
    margin-bottom: 30px;
}

.address-section h3 {
    color: #333;
    margin-bottom: 15px;
    font-size: 18px;
}

.location-detail {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 10px;
    margin: 10px 0;
    font-size: 16px;
    line-height: 1.6;
    color: #555;
}

.landmarks {
    list-style: none;
    padding: 0;
    margin: 0;
}

.landmarks li {
    padding: 10px 0;
    color: #666;
    display: flex;
    align-items: center;
    gap: 10px;
}

.landmarks li i {
    color: #dc3545;
    width: 20px;
}
</style>

<script>
// Geri sayım fonksiyonu
function updateTimer(endDate) {
    const now = new Date().getTime();
    const end = new Date(endDate).getTime();
    const distance = end - now;

    if (distance < 0) {
        document.querySelector('.campaign-timer').innerHTML = '<div class="timer-label">Kampanya Sona Erdi</div>';
        return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.querySelector('.timer-value .days').textContent = String(days).padStart(2, '0');
    document.querySelector('.timer-value .hours').textContent = String(hours).padStart(2, '0');
    document.querySelector('.timer-value .minutes').textContent = String(minutes).padStart(2, '0');
    document.querySelector('.timer-value .seconds').textContent = String(seconds).padStart(2, '0');
}

// Sayfa yüklendiğinde geri sayımı başlat
document.addEventListener('DOMContentLoaded', function() {
    const timerElement = document.querySelector('.campaign-timer');
    const endDate = timerElement.dataset.end;

    updateTimer(endDate);
    setInterval(() => updateTimer(endDate), 1000);
});

function openGoogleMaps(address) {
    const encodedAddress = encodeURIComponent(address);
    window.open(`https://www.google.com/maps/search/?api=1&query=${encodedAddress}`, '_blank');
}

function contactStore() {
    window.location.href = '/contact';
}

// Modal functions
function openLocalAddressModal() {
    const modal = document.getElementById('localAddressModal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLocalAddressModal() {
    const modal = document.getElementById('localAddressModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('localAddressModal');
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeLocalAddressModal();
        }
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeLocalAddressModal();
        }
    });
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>