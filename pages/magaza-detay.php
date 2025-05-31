<?php
//
$current_page = 'store-detail';
$store_id = isset($_GET['id']) ? $_GET['id'] : null;

include __DIR__ . '/../includes/navbar.php';

include __DIR__ . '/../classes/Stores.php';
$store = new Stores();

$storedata = $store->getStoreDataWithCampaign($store_id);
$kampanyalar = [];

if ($storedata && isset($storedata['campaigns'])) {
    // Tek bir kampanya varsa array'e çevir
    if (is_string($storedata['campaigns'])) {
        $kampanyalar[] = json_decode($storedata['campaigns'], true);
    } else {
        $kampanyalar = $storedata['campaigns'];
    }
}

?>
<div class="store-detail-page">
    <div class="container">
        <!-- Mağaza Başlık Bilgileri -->
        <div class="store-header">
            <div class="store-header-content">
                <div class="store-image">
                    <img src="https://endecormob.com/tema/genel/uploads/urunler/smaller-2021-02-18T11_23_11.871Z.jpeg"
                        alt="Mağaza Adı">
                    <div class="store-status active">Aktif</div>
                </div>
                <div class="store-info">
                    <a href="magazalar.php" class="back-to-stores">
                        <i class="fas fa-arrow-left"></i>
                        <span>Mağazalara Dön</span>
                    </a>
                    <h6>Dörtyol Merkez, Hatay</h6>
                    <h1>Örnek Mağaza</h1>
                    <div class="store-meta">
                        <div class="store-owner">
                            <i class="fas fa-user"></i>
                            <span>Ahmet Yılmaz</span>
                        </div>
                        <div class="store-location" onclick="openGoogleMaps()">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Konuma Git</span>
                        </div>
                        <div class="store-hours">
                            <i class="fas fa-clock"></i>
                            <span>09:00 - 18:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mağaza İçeriği -->
        <div class="store-content">
            <!-- Aktif Kampanyalar -->
            <div class="campaigns-section">
                <div class="section-header">
                    <h2>Aktif Kampanyalar</h2>
                    <span class="campaign-count"><?= count($kampanyalar) ?> Kampanya</span>
                </div>
                <div class="campaigns-grid">
                    <?php
                    foreach ($kampanyalar as $k) {
                        // Kampanya tipine göre badge metni
                        $badgeText = '';
                        switch ($k['type']) {
                            case 'discount':
                                $badgeText = '%' . $k['discount_off'] . ' İndirim';
                                break;
                            case 'bogo':
                                $badgeText = 'Al 1 Öde 1';
                                break;
                            case 'bundle':
                                $badgeText = 'Paket İndirim';
                                break;
                            case 'discount_amount':
                                $badgeText = $k['discount_off'] . ' TL İndirim';
                                break;
                        }

                        // Tarihleri formatla
                        $startDate = date('d F', strtotime($k['start_time']));
                        $endDate = date('d F', strtotime($k['end_time']));
                        ?>
                        <div class="campaign-card" onclick="openTermsModal(<?= $k['id'] ?>)" style="cursor: pointer;">
                            <div class="campaign-badge"><?= $badgeText ?></div>
                            <div class="campaign-content">
                                <h3><?= $k['title'] ?></h3>
                                <p><?= $k['sub_description'] ?></p>
                                <div class="campaign-details">
                                    <div class="campaign-date">
                                        <i class="far fa-calendar"></i>
                                        <span><?= $startDate ?> - <?= $endDate ?></span>
                                    </div>
                                    <?php if ($k['min_purchase']) { ?>
                                        <div class="campaign-min-purchase">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span>Min. <?= $k['min_purchase'] ?> TL</span>
                                        </div>
                                    <?php } ?>
                                    <div class="campaign-terms">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Kampanya Koşulları</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kampanya Koşulları Modal -->
<div class="terms-modal" id="termsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Kampanya Koşulları</h3>
            <button class="close-modal" onclick="closeTermsModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="campaign-info">
                <div class="campaign-badge" id="modalCampaignBadge"></div>
                <h4 id="modalCampaignTitle"></h4>
                <div class="campaign-date">
                    <i class="far fa-calendar"></i>
                    <span id="modalCampaignDate"></span>
                </div>
            </div>
            <div class="terms-content">
                <h5>Kampanya Detayları</h5>
                <div id="modalCampaignDetails"></div>
            </div>
        </div>
    </div>
</div>

<style>
    .store-detail-page {
        padding: 80px 0;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .store-header {
        background: var(--white);
        border-radius: 15px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-sm);
    }

    .store-header-content {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .store-image {
        position: relative;
        width: 300px;
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
    }

    .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-status {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .store-status.active {
        background: #28a745;
        color: white;
    }

    .store-info {
        flex: 1;
    }

    .store-info h1 {
        font-size: 2rem;
        color: var(--dark);
        margin-bottom: 20px;
    }

    .store-meta {
        display: grid;
        gap: 15px;
    }

    .store-owner,
    .store-location,
    .store-hours {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray);
    }

    .store-content {
        background: var(--white);
        border-radius: 15px;
        padding: 30px;
        box-shadow: var(--shadow-sm);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-header h2 {
        font-size: 1.5rem;
        color: var(--dark);
    }

    .campaign-count {
        background: var(--primary);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .campaigns-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .campaign-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 25px;
        position: relative;
        transition: transform 0.3s ease;
        min-height: 200px;
        display: flex;
        flex-direction: column;
    }

    .campaign-card:hover {
        transform: translateY(-5px);
    }

    .campaign-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--primary);
        color: white;
        padding: 6px 15px;
        border-radius: 15px;
        font-size: 0.9rem;
        font-weight: 500;
        z-index: 1;
    }

    .campaign-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        margin-top: 40px;
    }

    .campaign-content h3 {
        font-size: 1.2rem;
        color: var(--dark);
        margin-bottom: 10px;
        padding-right: 20px;
    }

    .campaign-content p {
        color: var(--gray);
        margin-bottom: 15px;
        flex: 1;
        padding-right: 20px;
    }

    .campaign-details {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .campaign-date,
    .campaign-terms {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--gray);
        font-size: 0.9rem;
    }

    .campaign-terms {
        color: var(--primary);
        cursor: pointer;
    }

    /* Modal Stilleri */
    .terms-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: var(--white);
        border-radius: 15px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: modalSlideIn 0.3s ease;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        font-size: 1.5rem;
        color: var(--dark);
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: var(--gray);
        cursor: pointer;
        padding: 5px;
        transition: color 0.3s ease;
    }

    .close-modal:hover {
        color: var(--dark);
    }

    .modal-body {
        padding: 20px;
    }

    .campaign-info {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .campaign-info h4 {
        font-size: 1.3rem;
        color: var(--dark);
        margin: 15px 0;
    }

    .terms-content {
        color: var(--gray);
    }

    .terms-content h5 {
        color: var(--dark);
        font-size: 1.1rem;
        margin-bottom: 15px;
    }

    .terms-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .terms-content li {
        margin-bottom: 10px;
        padding-left: 25px;
        position: relative;
    }

    .terms-content li:before {
        content: "•";
        color: var(--primary);
        position: absolute;
        left: 0;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @media (max-width: 768px) {
        .store-header-content {
            flex-direction: column;
        }

        .store-image {
            width: 100%;
            height: 200px;
        }

        .store-info h1 {
            font-size: 1.8rem;
        }

        .campaigns-grid {
            grid-template-columns: 1fr;
        }

        .modal-content {
            width: 95%;
            margin: 10px;
        }
    }

    .store-location {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--gray);
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .store-location:hover {
        color: var(--primary);
    }

    .store-location i {
        font-size: 1.1rem;
    }

    .back-to-stores {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--primary);
        text-decoration: none;
        font-size: 0.95rem;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .back-to-stores:hover {
        color: var(--primary-dark);
    }

    .back-to-stores i {
        font-size: 0.9rem;
    }
</style>

<script>
    let campaigns = <?= json_encode($kampanyalar) ?>;

    function openTermsModal(campaignId) {
        const campaign = campaigns.find(c => c.id == campaignId);
        if (!campaign) return;

        // Badge metnini oluştur
        let badgeText = '';
        switch (campaign.type) {
            case 'discount':
                badgeText = '%' + campaign.discount_off + ' İndirim';
                break;
            case 'bogo':
                badgeText = 'Al 1 Öde 1';
                break;
            case 'bundle':
                badgeText = 'Paket İndirim';
                break;
            case 'discount_amount':
                badgeText = campaign.discount_off + ' TL İndirim';
                break;
        }

        // Tarihleri formatla
        const startDate = new Date(campaign.start_time).toLocaleDateString('tr-TR', { day: 'numeric', month: 'long' });
        const endDate = new Date(campaign.end_time).toLocaleDateString('tr-TR', { day: 'numeric', month: 'long' });

        // Modal içeriğini doldur
        document.getElementById('modalCampaignBadge').textContent = badgeText;
        document.getElementById('modalCampaignTitle').textContent = campaign.title;
        document.getElementById('modalCampaignDate').textContent = `${startDate} - ${endDate}`;

        // Kampanya detaylarını oluştur
        const detailsHtml = `
            <ul>
                <li>${campaign.sub_description}</li>
                ${campaign.min_purchase ? `<li>Minimum ${campaign.min_purchase} TL alışveriş yapılmalıdır.</li>` : ''}
                <li>Kampanya ${startDate} - ${endDate} tarihleri arasında geçerlidir.</li>
                <li>Kampanya stoklarla sınırlıdır.</li>
                <li>Mağaza kampanyayı sonlandırma hakkını saklı tutar.</li>
            </ul>
        `;
        document.getElementById('modalCampaignDetails').innerHTML = detailsHtml;

        // Modalı göster
        document.getElementById('termsModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeTermsModal() {
        document.getElementById('termsModal').style.display = 'none';
        document.body.style.overflow = '';
    }

    // Modal dışına tıklandığında kapatma
    document.getElementById('termsModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeTermsModal();
        }
    });

    // ESC tuşu ile kapatma
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeTermsModal();
        }
    });

    function openGoogleMaps() {
        // Dörtyol, Hatay koordinatları
        const latitude = 36.8397;
        const longitude = 36.2167;

        const storeName = encodeURIComponent("Örnek Mağaza");

        // Google Maps URL'si
        const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${latitude},${longitude}`;

        // Yeni sekmede aç
        window.open(mapsUrl, '_blank');
    }
</script>

<?php
require_once __DIR__ . "/../includes/footer.php";
?>