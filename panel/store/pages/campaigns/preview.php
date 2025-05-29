<?php
require_once __DIR__ . '/../../includes/header.php';

// Kampanya verilerini işle
$campaign = [];

// Temel kampanya bilgileri
$campaign['title'] = filter_input(INPUT_POST, 'campaign_title', FILTER_SANITIZE_STRING);
$campaign['description'] = filter_input(INPUT_POST, 'campaign_description', FILTER_SANITIZE_STRING);
$campaign['type'] = filter_input(INPUT_POST, 'campaign_type', FILTER_SANITIZE_STRING);
$campaign['sub_category_id'] = filter_input(INPUT_POST, 'campaing_sub_id', FILTER_SANITIZE_NUMBER_INT);
$campaign['sub_sub_category_id'] = filter_input(INPUT_POST, 'campaing_sub_sub_id', FILTER_SANITIZE_NUMBER_INT);

// Tarih bilgileri
$campaign['start_date'] = filter_input(INPUT_POST, 'campaign_start_date', FILTER_SANITIZE_STRING);
$campaign['end_date'] = filter_input(INPUT_POST, 'campaign_end_date', FILTER_SANITIZE_STRING);

// Kampanya detayları
$campaign['discount'] = filter_input(INPUT_POST, 'campaign_discount', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$campaign['min_purchase'] = filter_input(INPUT_POST, 'campaign_min_purchase', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$campaign['details'] = filter_input(INPUT_POST, 'campaign_details', FILTER_SANITIZE_STRING);

// Kampanya koşulları
$campaign['conditions'] = isset($_POST['conditions']) ? array_map('filter_var', $_POST['conditions']) : [];

// Görsel işleme - Sadece geçici önizleme için
$campaign['image'] = '';
if (isset($_FILES['campaign_image']) && $_FILES['campaign_image']['error'] === UPLOAD_ERR_OK) {
    // Geçici dosyayı base64'e dönüştür
    $imageData = file_get_contents($_FILES['campaign_image']['tmp_name']);
    $base64Image = base64_encode($imageData);
    $campaign['image'] = 'data:' . $_FILES['campaign_image']['type'] . ';base64,' . $base64Image;
}

// Stok fotoğraf kontrolü
if (isset($_POST['selected_stock_photo']) && !empty($_POST['selected_stock_photo'])) {
    $campaign['image'] = Helper::upolads('images/stock_photos/') . $_POST['selected_stock_photo'];
}

// Veri doğrulama
$errors = [];
if (empty($campaign['title']))
    $errors[] = 'Kampanya başlığı gereklidir.';
if (empty($campaign['description']))
    $errors[] = 'Kampanya açıklaması gereklidir.';
if (empty($campaign['type']))
    $errors[] = 'Kampanya tipi seçilmelidir.';
if (empty($campaign['sub_category_id']))
    $errors[] = 'Kampanya kategorisi seçilmelidir.';
if (empty($campaign['start_date']))
    $errors[] = 'Başlangıç tarihi gereklidir.';
if (empty($campaign['end_date']))
    $errors[] = 'Bitiş tarihi gereklidir.';
if (empty($campaign['image']))
    $errors[] = 'Kampanya görseli gereklidir.';
if (empty($campaign['conditions']))
    $errors[] = 'En az bir kampanya koşulu eklenmelidir.';

// Hata varsa geri dön
if (!empty($errors)) {




    $session->flash('error', $errors);



    $_SESSION['campaign_form_data'] = $_POST; // Form verilerini session'a kaydet
    if (isset($_FILES['campaign_image'])) {
        $_SESSION['campaign_file_data'] = $_FILES['campaign_image'];
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// Kampanya verilerini session'a kaydet
$_SESSION['campaign_form_data'] = $_POST;
if (isset($_FILES['campaign_image'])) {
    $_SESSION['campaign_file_data'] = $_FILES['campaign_image'];
}
$campaignType = [
    'discount' => 'İndirim',
    'bogo' => 'Al Bir Bedava',
    'bundle' => 'Paket İndirim',
    'discount_amount' => 'TL İndirim'
];
$campaingprefix = ['discount' => '%', 'discount_amount' => 'TL'];


?>



<div class="preview-container">
    <div class="preview-header">
        <h1>Kampanya Önizleme</h1>
        <p>Kampanyanızın nasıl görüneceğini kontrol edin</p>
    </div>

    <div class="preview-sections">
        <!-- Anasayfa Önizleme -->
        <div class="preview-section home-preview">
            <h2>Anasayfa Görünümü</h2>
            <div class="campaign-cards-grid">
                <div class="campaign-card-preview">
                    <?php if (!empty($campaign['image'])): ?>
                        <img src="<?= htmlspecialchars($campaign['image']) ?>" alt="Kampanya" class="campaign-card-img">
                    <?php else: ?>
                        <div class="no-image">Görsel Yok</div>
                    <?php endif; ?>
                    <div class="campaign-card-content">
                        <h3 class="campaign-card-title"><?= htmlspecialchars($campaign['title']) ?></h3>
                        <p class="campaign-card-desc"><?= htmlspecialchars($campaign['description']) ?></p>
                        <div class="campaign-card-meta">
                            <div class="campaign-time">
                                <i class="far fa-clock"></i>
                                Bitiş: <?= date('d.m.Y H:i', strtotime($campaign['end_date'])) ?>
                            </div>
                            <a href="#" class="view-btn">İncele</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detay Sayfası Önizleme -->
        <div class="preview-section detail-preview">
            <h2>Detay Sayfası Görünümü</h2>
            <div class="campaign-detail-preview">
                <div class="campaign-header">
                    <h1><?= htmlspecialchars($campaign['title']) ?></h1>
                    <div class="campaign-timer" data-end="<?= $campaign['end_date'] ?>">
                        <div class="timer-label">Kampanyanın Bitmesine:</div>
                        <div class="timer-value">
                            <span class="days">00</span>:<span class="hours">00</span>:<span
                                class="minutes">00</span>:<span class="seconds">00</span>
                        </div>
                    </div>
                </div>

                <div class="campaign-details">
                    <?php if ($campaign['discount']): ?>
                        <div class="discount-badge">
                            <?= (int) $campaign['discount'] ?>    <?= $campaingprefix[$campaign['type']] ?> İndirim
                        </div>
                    <?php endif; ?>

                    <div class="campaign-description">
                        <?= nl2br(htmlspecialchars($campaign['description'])) ?>
                    </div>
                    <div class="campaign-description">
                        <?= nl2br(htmlspecialchars($campaign['details'])) ?>
                    </div>

                    <?php if ($campaign['min_purchase']): ?>
                        <div class="purchase-info">
                            <i class="fas fa-info-circle"></i>
                            Minimum <?= number_format((int) $campaign['min_purchase'], 2, ',', '.') ?> TL ve üzeri
                            alışverişlerde geçerlidir.
                        </div>
                    <?php endif; ?>

                    <div class="campaign-terms">
                        <h3>Kampanya Koşulları</h3>
                        <ul>
                            <li>Kampanya <?= date('d.m.Y H:i', strtotime($campaign['end_date'])) ?> tarihine kadar
                                geçerlidir.</li>
                            <?php if ($campaign['type'] == 'discount'): ?>
                                <li>İndirim oranı seçili ürünlerde geçerlidir.</li>
                            <?php elseif ($campaign['type'] == 'bogo'): ?>
                                <li>Bir ürün alana bir ürün bedava kampanyası seçili ürünlerde geçerlidir.</li>
                            <?php elseif ($campaign['type'] == 'bundle'): ?>
                                <li>Paket indirimi seçili ürün gruplarında geçerlidir.</li>
                            <?php endif; ?>
                            <?php foreach ($campaign['conditions'] as $condition): ?>
                                <li><?= htmlspecialchars($condition) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="preview-actions">
        <form id="campaignForm" action="<?= Helper::controller('campaignController') ?>" method="post"
            enctype="multipart/form-data">
            <?php
            // Orijinal form verilerini hidden input olarak ekle
            foreach ($_POST as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '[]" value="' . htmlspecialchars($v) . '">';
                    }
                } else {
                    echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                }
            }

            // Dosya verilerini ekle
            if (isset($_FILES['campaign_image'])) {
                echo '<input type="hidden" name="file_name" value="' . htmlspecialchars($_FILES['campaign_image']['name']) . '">';
                echo '<input type="hidden" name="file_type" value="' . htmlspecialchars($_FILES['campaign_image']['type']) . '">';
                echo '<input type="hidden" name="file_size" value="' . htmlspecialchars($_FILES['campaign_image']['size']) . '">';
                echo '<input type="hidden" name="file_tmp_name" value="' . htmlspecialchars($_FILES['campaign_image']['tmp_name']) . '">';
            }
            ?>
            <button type="button" class="btn btn-secondary" onclick="history.back()">Düzenle</button>
            <button type="submit" class="btn btn-primary">Kampanyayı Oluştur</button>
        </form>
    </div>
</div>

<style>
    .preview-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .preview-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .preview-sections {
        display: flex;
        flex-direction: column;
        gap: 30px;
        margin-bottom: 30px;
    }

    .preview-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .preview-section h2 {
        width: 100%;
        text-align: center;
        margin-bottom: 20px;
    }

    .home-preview .campaign-cards-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
        margin-top: 20px;
        justify-items: center;
    }

    .detail-preview {
        width: 100%;
    }

    .campaign-card-preview {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: transform 0.3s ease;
        width: 100%;
        max-width: 350px;
    }

    .campaign-card-preview:hover {
        transform: translateY(-5px);
    }

    .campaign-card-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }

    .campaign-card-content {
        padding: 12px;
    }

    .campaign-card-title {
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
        font-weight: 600;
        line-height: 1.3;
    }

    .campaign-card-desc {
        color: #666;
        margin-bottom: 12px;
        font-size: 13px;
        line-height: 1.4;
        height: 36px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .campaign-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid #eee;
    }

    .campaign-time {
        color: #666;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .campaign-time i {
        color: #007bff;
    }

    .view-btn {
        background: #007bff;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 13px;
        transition: background-color 0.3s ease;
    }

    .view-btn:hover {
        background: #0056b3;
        color: white;
        text-decoration: none;
    }

    .no-image {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        color: #6c757d;
        font-size: 13px;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Detay Sayfası Stili */
    .campaign-detail-preview {
        padding: 20px;
    }

    .campaign-header {
        margin-bottom: 30px;
    }

    .campaign-timer {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin-top: 15px;
    }

    .timer-value {
        font-size: 24px;
        font-weight: bold;
        color: #dc3545;
    }

    .discount-badge {
        background: #dc3545;
        color: white;
        padding: 5px 15px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .campaign-description {
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .purchase-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 4px;
        margin: 15px 0;
    }

    .campaign-terms {
        margin-top: 30px;
    }

    .campaign-terms ul {
        list-style: none;
        padding: 0;
    }

    .campaign-terms li {
        margin-bottom: 10px;
        padding-left: 20px;
        position: relative;
    }

    .campaign-terms li:before {
        content: "•";
        position: absolute;
        left: 0;
        color: #007bff;
    }

    .preview-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .campaign-card-img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    @media (max-width: 1200px) {
        .home-preview .campaign-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .home-preview .campaign-cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Geri sayım için timer fonksiyonu
    function updateTimer() {
        const timerElements = document.querySelectorAll('.campaign-timer');
        timerElements.forEach(timer => {
            const endDate = new Date(timer.dataset.end).getTime();
            const now = new Date().getTime();
            const distance = endDate - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timer.querySelector('.days').textContent = String(days).padStart(2, '0');
            timer.querySelector('.hours').textContent = String(hours).padStart(2, '0');
            timer.querySelector('.minutes').textContent = String(minutes).padStart(2, '0');
            timer.querySelector('.seconds').textContent = String(seconds).padStart(2, '0');
        });
    }

    // Her saniye timer'ı güncelle
    setInterval(updateTimer, 1000);
    updateTimer(); // İlk çalıştırma
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>