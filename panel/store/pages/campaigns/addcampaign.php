<?php
require_once __DIR__ . '/../../includes/header.php';

?>

<script>
    const templates = {
        general: [
            "Kampanya stoklarla sınırlıdır.",
            "Kampanya başka kampanyalarla birleştirilemez.",
            "İşletme kampanyayı sonlandırma hakkını saklı tutar.",
            "Kampanya süresince ürün iadesi kabul edilmemektedir."
        ],
        discount: [
            "İndirim sadece belirtilen ürünlerde geçerlidir.",
            "Maksimum indirim tutarı 500TL ile sınırlıdır.",
            "İndirim nakit olarak talep edilemez.",
            "Kampanya stoklarla sınırlıdır."
        ],
        seasonal: [
            "Sezonluk ürünlerde geçerlidir.",
            "Stoklar ile sınırlıdır.",
            "Sezon sonunda iade kabul edilmez.",
            "Kampanya tarihleri arasında geçerlidir."
        ]
    };
</script>




<div class="campaign-form-container">
    <div class="content-header">
        <h1 style="text-align: center;">Kampanya Ekle</h1>
    </div>


    <form id="campaignForm" class="campaign-form" action="<?= Helper::controller('campaignController') ?>" method="post" >
        <?php echo $csrf->getTokenField(); ?>
        <div class="form-section">
            <h3>Kampanya Bilgileri</h3>
            <div class="form-group">
                <label for="campaign_title">Kampanya Başlığı</label>
                <input type="text" id="campaign_title" name="campaign_title" class="form-control" required
                    placeholder="Mutfak Alışverişi">
            </div>

            <div class="form-group">
                <label for="campaign_description">Kampanya Açıklaması</label>
                <textarea id="campaign_description" name="campaign_description" class="form-control" rows="4" required
                    placeholder="Mutfak Alışverişiniz için geçerli ürünlerde %20 indirim"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_start_date">Başlangıç Tarihi</label>
                        <input type="datetime-local" id="campaign_start_date" name="campaign_start_date"
                            class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_end_date">Bitiş Tarihi</label>
                        <input type="datetime-local" id="campaign_end_date" name="campaign_end_date"
                            class="form-control" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3>Kampanya Kapak Görseli</h3>
            <div class="form-group">

                <label for="campaign_image">Görsel Seç</label>
                <div class="image-upload-options">
                    <button type="button" class="btn btn-outline-primary btn-stock-photo" data-bs-toggle="modal"
                        data-bs-target="#stockPhotoModal">
                        <i class="fas fa-images"></i>
                        Stok Fotoğraf Seç
                    </button>
                    <span class="text-muted">veya</span>
                    <input type="file" name="campaign_image" class="form-control" accept="image/*">
                </div>

                <div id="image_preview" class="image-preview mt-2"></div>
            </div>
        </div>

        <div class="form-section">
            <h3>Kampanya Detayları</h3>
            <div class="form-group">
                <label for="campaign_type">Kampanya Tipi</label>
                <select id="campaign_type" name="campaign_type" class="form-control" required>
                    <option value="">Seçiniz</option>
                    <option value="discount">İndirim</option>
                    <option value="bogo">1 Alana 1 Bedava</option>
                    <option value="bundle">Paket İndirimi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="campaign_discount">İndirim Oranı (%)</label>
                <input type="number" id="campaign_discount" name="campaign_discount" class="form-control" min="0"
                    max="100">
            </div>

            <div class="form-group">
                <label for="campaign_min_purchase">Minimum Alışveriş Tutarı</label>
                <input type="number" id="campaign_min_purchase" name="campaign_min_purchase" class="form-control"
                    min="0">
            </div>

            <div class="form-group">
                <label for="campaign_details">Kampanya İçerik Bilgisi (Opsiyonel)</label>
                <textarea id="campaign_details" name="campaign_details" class="form-control" rows="4" required
                    placeholder="Kampanya içeriği hakkında bilgi giriniz"></textarea>
            </div>
        </div>
        <div class="form-group">
            <h4 class="mb-3">Kampanya Koşulları (ZORUNLU ALAN)</h4>
            <button type="button" class="btn btn-primary mb-3" onclick="openConditionsModal()">
                <i class="fas fa-plus"></i> Koşul Ekle
            </button>

            <!-- Seçilen koşulların gösterileceği alan -->
            <div id="selectedConditionsContainer" style="margin-top: 10px;" class="selected-conditions">
                <!-- Seçili koşullar buraya eklenecek -->
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kampanya Oluştur</button>
            <button type="button" class="btn btn-secondary" onclick="history.back()">İptal</button>
        </div>
    </form>
</div>

<!-- Custom Modal -->
<div id="stockPhotoModal" class="custom-modal">
    <div class="modal-wrapper">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Stok Fotoğraf Seçin</h5>
                <button type="button" class="close-modal" onclick="closeModal()">×</button>
            </div>
            <div class="modal-body">
                <!-- Yükleniyor Göstergesi -->
                <div id="loadingIndicator" class="loading-indicator">
                    <div class="spinner"></div>
                    <p>Fotoğraflar Yükleniyor...</p>
                </div>

                <!-- Fotoğraf Grid -->
                <div id="stockPhotosGrid" class="stock-photos-grid"></div>

                <!-- Fotoğraf Bulunamadı Mesajı -->
                <div id="noPhotosMessage" class="message-box hidden">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Fotoğraf bulunamadı</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kampanya Koşulları Modalı -->
<div id="conditionsModal" class="custom-modal">
    <div class="modal-wrapper">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kampanya Koşulları</h5>
                <button type="button" class="close-modal" onclick="closeConditionsModal()">×</button>
            </div>
            <div class="modal-body">
                <!-- Şablon Seçimi -->
                <div class="template-selection mb-4">
                    <label for="conditionTemplate" class="form-label">Hazır Şablonlar</label>
                    <div class="d-flex gap-2">
                        <select id="conditionTemplate" class="form-control">
                            <option value="">Şablon Seçin</option>
                            <option value="general">Genel Koşullar</option>
                            <option value="discount">İndirim Koşulları</option>
                            <option value="seasonal">Sezonluk Kampanya Koşulları</option>
                        </select>
                        <button type="button" class="btn btn-outline-primary" onclick="applyTemplate()">Listele</button>
                    </div>
                </div>

                <!-- Koşul Listesi -->
                <div class="conditions-container">
                    <div class="conditions-list" id="conditionsList"></div>
                </div>

                <!-- Özel Koşul Ekleme -->
                <div class="custom-condition-input mt-3">
                    <label class="form-label">Özel Koşul Ekle</label>
                    <div class="input-group">
                        <input type="text" id="customCondition" class="form-control " style="margin-bottom: 10px;"
                            placeholder="Özel koşul girin...">
                        <button type="button" class="btn btn-primary" onclick="addCustomCondition()">Ekle</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveConditions()">Koşulları Kaydet</button>
                <button type="button" class="btn btn-secondary" onclick="closeConditionsModal()">İptal</button>
            </div>
        </div>
    </div>
</div>

<!-- Kampanya Önizleme Modalı -->
<div id="previewModal" class="custom-modal">
    <div class="modal-wrapper">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kampanya Önizleme</h5>
                <button type="button" class="close-modal" onclick="closePreviewModal()">×</button>
            </div>
            <div class="modal-body">
                <div class="preview-container">
                    <h4 class="mb-3">Kampanyanız kullanıcılara bu şekilde görünecek:</h4>
                    
                    <!-- Kampanya Kartı Önizlemesi -->
                    <div class="campaign-card-preview">
                        <div class="campaign-card">
                            <span id="previewDiscountBadge" class="campaign-discount"></span>
                            <img id="previewImage" src="" alt="Kampanya" class="campaign-card-img">
                            <div class="campaign-card-content">
                                <h3 id="previewTitle" class="campaign-card-title"></h3>
                                <p id="previewDescription" class="campaign-card-desc"></p>
                                <div class="campaign-card-meta">
                                    <div class="campaign-time">
                                        <i class="far fa-clock"></i> 
                                        <span id="previewDates"></span>
                                    </div>
                                    <a href="javascript:void(0)" class="view-btn" onclick="showFullDetails()">Detayları Gör</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detaylı Bilgiler (başlangıçta gizli) -->
                    <div id="fullDetails" class="campaign-full-details" style="display: none;">
                        <h4 class="mt-4 mb-3">Kampanya Detayları</h4>
                        <div class="details-container">
                            <div class="detail-group">
                                <label>Kampanya Tipi:</label>
                                <span id="previewType"></span>
                            </div>
                            <div class="detail-group">
                                <label>Minimum Alışveriş Tutarı:</label>
                                <span id="previewMinPurchase"></span>
                            </div>
                            <div class="detail-group">
                                <label>Detaylı Açıklama:</label>
                                <p id="previewDetails"></p>
                            </div>
                            <div class="detail-group">
                                <label>Kampanya Koşulları:</label>
                                <ul id="previewConditions" class="conditions-list"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submitCampaign()">Kampanyayı Oluştur</button>
                <button type="button" class="btn btn-secondary" onclick="closePreviewModal()">Düzenle</button>
            </div>
        </div>
    </div>
</div>

<style>
    .mobile-overlay {
        display: none;
    }

    .admin-content {
        padding: 20px;
        background-color: #f8f9fa;
        min-height: calc(100vh - 60px);
    }

    .content-header {
        margin-bottom: 30px;
    }

    .content-header h1 {
        font-size: 24px;
        color: #333;
        margin: 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
    }

    .campaign-form-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .campaign-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-section {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .form-section h3 {
        font-size: 18px;
        color: #495057;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #495057;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin: -10px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 10px;
    }

    .image-preview {
        margin-top: 10px;
        max-width: 300px;
    }

    .image-preview img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border: 1px solid #0056b3;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }

    .btn-secondary {
        background-color: #6c757d;
        border: 1px solid #545b62;
        color: #fff;
    }

    .btn-secondary:hover {
        background-color: #545b62;
        border-color: #4e555b;
    }

    /* Responsive Tasarım */
    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .campaign-form-container {
            padding: 15px;
        }

        .form-section {
            padding: 15px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }
    }

    /* Form Validation Styles */
    .form-control:invalid {
        border-color: #dc3545;
    }

    .form-control:invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    /* Custom Select Styling */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23343a40' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 12px;
        padding-right: 32px;
    }

    /* File Input Styling */
    input[type="file"].form-control {
        padding: 6px 12px;
    }

    input[type="file"].form-control::file-selector-button {
        padding: 6px 12px;
        margin: -6px 12px -6px -12px;
        border: none;
        background-color: #e9ecef;
        color: #495057;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    input[type="file"].form-control::file-selector-button:hover {
        background-color: #dde2e6;
    }

    /* Custom Modal Styles */
    .custom-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .custom-modal.show {
        display: flex !important;
        opacity: 1;
        align-items: center;
        justify-content: center;
    }

    .modal-wrapper {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;

        max-width: 1200px;
        max-height: 90vh;
    }

    .modal-content {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .modal-body {
        padding: 20px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        background: white;
        position: sticky;
        bottom: 0;
        z-index: 10;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .conditions-container {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: white;
        margin: 15px 0;
    }

    .conditions-list {
        max-height: calc(50vh - 100px);
        overflow-y: auto;
        padding: 15px;
    }

    .condition-checkbox {
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 8px;
        background: white;
        display: flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .condition-checkbox:last-child {
        margin-bottom: 0;
    }

    .condition-checkbox:hover {
        background: #f8f9fa;
    }

    .template-selection {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .custom-condition-input {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    /* Mobil Görünüm */
    @media (max-width: 768px) {
        .modal-wrapper {
            width: 100%;
            height: 100%;
            max-height: 100%;
            margin: 0;
            border-radius: 0;
        }

        .modal-header {
            padding: 15px;
        }

        .modal-body {
            padding: 15px;
        }

        .modal-footer {
            padding: 15px;
            flex-direction: column;
        }

        .modal-footer .btn {
            width: 100%;
            margin: 0;
            padding: 12px;
        }

        .template-selection {
            padding: 15px;
        }

        .template-selection .d-flex {
            flex-direction: column;
        }

        .template-selection .form-select {
            margin-bottom: 10px;
        }

        .template-selection .btn {
            width: 100%;
        }

        .conditions-list {
            max-height: calc(100vh - 300px);
        }

        .condition-checkbox {
            padding: 15px;
        }

        .condition-checkbox input[type="checkbox"] {
            width: 24px;
            height: 24px;
            margin-right: 12px;
        }

        .custom-condition-input {
            padding: 15px;
        }

        .custom-condition-input .input-group {
            flex-direction: column;
        }

        .custom-condition-input .form-control {
            margin-bottom: 10px;
            width: 100%;
        }

        .custom-condition-input .btn {
            width: 100%;
        }
    }

    /* Tablet Görünüm */
    @media (min-width: 769px) and (max-width: 1024px) {
        .modal-wrapper {
            width: 90%;
            max-width: 800px;
        }

        .conditions-list {
            max-height: calc(60vh - 100px);
        }
    }

    /* Animasyonlar */
    .custom-modal.show .modal-wrapper {
        animation: modalSlideIn 0.3s ease forwards;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Touch Cihaz Optimizasyonları */
    @media (hover: none) {

        .condition-checkbox,
        .btn,
        .form-control,
        .form-select {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }

        .condition-checkbox {
            min-height: 54px;
        }

        .btn {
            min-height: 44px;
        }
    }

    .selected-conditions {
        border: 1px solid #dee2e6;
        border-radius: 4px;
        padding: 15px;
        min-height: 100px;
        background-color: #f8f9fa;
    }

    .condition-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 12px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .condition-item:last-child {
        margin-bottom: 0;
    }

    .condition-item .remove-btn {
        color: #dc3545;
        cursor: pointer;
        padding: 4px 8px;
        border: none;
        background: none;
    }

    .condition-item .remove-btn:hover {
        color: #bd2130;
    }

    .conditions-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .condition-checkbox {
        display: flex;
        align-items: center;
        padding: 8px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background-color: #fff;
        transition: background-color 0.2s;
    }

    .condition-checkbox:hover {
        background-color: #f8f9fa;
    }

    .condition-checkbox input[type="checkbox"] {
        margin-right: 10px;
    }

    .d-flex {
        display: flex;
    }

    .gap-2 {
        gap: 0.5rem;
    }

    /* Yükleniyor ve Mesaj Stilleri */
    .loading-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: white;
        border-radius: 8px;
        text-align: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #007bff;
        border-radius: 50%;
        margin-bottom: 15px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .message-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        text-align: center;
        background: white;
        border-radius: 8px;
        margin: 20px 0;
    }

    .message-box i {
        font-size: 32px;
        margin-bottom: 15px;
        color: #6c757d;
    }

    .message-box p {
        margin: 0;
        color: #495057;
        font-size: 16px;
    }

    .message-box.error {
        background-color: #fff8f8;
        border: 1px solid #ffebee;
    }

    .message-box.error i {
        color: #dc3545;
    }

    .message-box.error p {
        color: #dc3545;
    }

    /* Mobil Görünüm İçin Mesaj Düzenlemeleri */
    @media (max-width: 768px) {
        .loading-indicator {
            padding: 30px 15px;
        }

        .spinner {
            width: 32px;
            height: 32px;
        }

        .message-box {
            padding: 20px 15px;
            margin: 15px 0;
        }

        .message-box i {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .message-box p {
            font-size: 14px;
        }
    }

    /* Stok Fotoğraf Grid Düzenlemeleri */
    .stock-photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
        background: white;
        width: 100%;
    }

    .stock-photo-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
        background: white;
    }

    .stock-photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .stock-photo-item:hover {
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .stock-photo-item.selected {
        border-color: #007bff;
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .stock-photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stock-photo-item:hover .stock-photo-overlay,
    .stock-photo-item.selected .stock-photo-overlay {
        opacity: 1;
    }

    .hidden {
        display: none !important;
    }

    @media (max-width: 768px) {
        .stock-photos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 10px;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .stock-photos-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
    }

    @media (min-width: 1025px) {
        .stock-photos-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    /* Kampanya Kartı Stilleri */
    .campaign-card-preview {
        max-width: 400px;
        margin: 0 auto;
    }

    .campaign-card {
        position: relative;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .campaign-card:hover {
        transform: translateY(-5px);
    }

    .campaign-discount {
        position: absolute;
        top: 15px;
        right: 15px;
        background: #ff4757;
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        z-index: 1;
    }

    .campaign-card-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .campaign-card-content {
        padding: 20px;
    }

    .campaign-card-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2d3436;
    }

    .campaign-card-desc {
        font-size: 14px;
        color: #636e72;
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .campaign-card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .campaign-time {
        font-size: 13px;
        color: #636e72;
    }

    .campaign-time i {
        color: #ff4757;
        margin-right: 5px;
    }

    .view-btn {
        background: #2d3436;
        color: #fff;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .view-btn:hover {
        background: #636e72;
        color: #fff;
    }

    /* Detaylı Bilgiler Stilleri */
    .campaign-full-details {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .details-container {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
    }

    .detail-group {
        margin-bottom: 15px;
    }

    .detail-group:last-child {
        margin-bottom: 0;
    }

    .detail-group label {
        display: block;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 5px;
    }

    .conditions-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .conditions-list li {
        padding: 8px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #636e72;
    }

    .conditions-list li:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .campaign-card-preview {
            max-width: 100%;
        }
    }
</style>
<script>
    // Şablon verileri


    let selectedConditions = [];

    function openConditionsModal() {
        const modal = document.getElementById('conditionsModal');
        modal.classList.add('show');
        renderConditionsList();
    }

    function closeConditionsModal() {
        const modal = document.getElementById('conditionsModal');
        modal.classList.remove('show');
    }

    function applyTemplate() {
        const templateSelect = document.getElementById('conditionTemplate');
        const selectedTemplate = templateSelect.value;

        if (selectedTemplate && templates[selectedTemplate]) {
            renderConditionsList(templates[selectedTemplate]);
        }
    }

    function renderConditionsList(conditions = []) {
        const list = document.getElementById('conditionsList');
        list.innerHTML = '';

        const allConditions = [...new Set([...conditions, ...selectedConditions])];

        allConditions.forEach((condition, index) => {
            const isChecked = selectedConditions.includes(condition);
            const div = document.createElement('div');
            div.className = 'condition-checkbox';
            div.innerHTML = `
                <input type="checkbox" id="condition${index}" ${isChecked ? 'checked' : ''}>
                <label for="condition${index}">${condition}</label>
            `;

            const checkbox = div.querySelector('input');
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    if (!selectedConditions.includes(condition)) {
                        selectedConditions.push(condition);
                    }
                } else {
                    selectedConditions = selectedConditions.filter(c => c !== condition);
                }
            });

            list.appendChild(div);
        });
    }

    function addCustomCondition() {
        const input = document.getElementById('customCondition');
        const condition = input.value.trim();

        if (condition) {
            selectedConditions.push(condition);
            renderConditionsList();
            input.value = '';
        }
    }

    function saveConditions() {
        const container = document.getElementById('selectedConditionsContainer');
        container.innerHTML = '';

        selectedConditions.forEach(condition => {
            const div = document.createElement('div');
            div.className = 'condition-item';
            div.innerHTML = `
                <span>${condition}</span>
                <input type="hidden" name="conditions[]" value="${condition}">
                <button type="button" class="remove-btn" onclick="removeCondition('${condition.replace(/'/g, "\\'")}')">
                    <i class="fas fa-times"></i>
                </button>
            `;
            container.appendChild(div);
        });

        closeConditionsModal();
    }

    function removeCondition(condition) {
        selectedConditions = selectedConditions.filter(c => c !== condition);
        saveConditions();
    }

    // Sayfa yüklendiğinde event listener'ları ekle
    document.addEventListener('DOMContentLoaded', function () {
        // Modal dışına tıklama ile kapatma
        const modal = document.getElementById('conditionsModal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeConditionsModal();
                }
            });
        }

        // ESC tuşu ile kapatma
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
                closeConditionsModal();
            }
        });

        // Custom condition input için enter tuşu desteği
        const customInput = document.getElementById('customCondition');
        if (customInput) {
            customInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addCustomCondition();
                }
            });
        }
    });
</script>
<script>
    // Modal işlemleri
    async function openModal() {
        console.log('Modal açılıyor...');
        const modal = document.getElementById('stockPhotoModal');
        if (!modal) {
            console.error('Modal elementi bulunamadı!');
            return;
        }
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Modal açıldığında fotoğrafları yükle
        await loadPhotos();
    }

    function closeModal() {
        console.log('Modal kapatılıyor...');
        const modal = document.getElementById('stockPhotoModal');
        if (!modal) {
            console.error('Modal elementi bulunamadı!');
            return;
        }
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Fotoğrafları yükle
    async function loadPhotos() {
        const photosGrid = document.getElementById('stockPhotosGrid');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noPhotosMessage = document.getElementById('noPhotosMessage');

        try {
            if (loadingIndicator) loadingIndicator.classList.remove('hidden');
            if (photosGrid) photosGrid.innerHTML = '';
            if (noPhotosMessage) noPhotosMessage.classList.add('hidden');

            const token = '<?= $csrf->getToken() ?>';
            const url = `<?= Helper::url('api/stock-photos.php') ?>?_token=${token}`;
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const responseText = await response.text();
            let result;
            try {
                result = JSON.parse(responseText);
            } catch (jsonError) {
                throw new Error('API yanıtı geçerli bir JSON formatında değil');
            }

            if (!result.status) {
                throw new Error(result.message || 'Fotoğraflar yüklenemedi');
            }

            if (loadingIndicator) loadingIndicator.classList.add('hidden');

            if (!result.data || result.data.length === 0) {
                if (noPhotosMessage) noPhotosMessage.classList.remove('hidden');
                return;
            }

            renderPhotos(result.data);
        } catch (error) {
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            if (noPhotosMessage) {
                noPhotosMessage.classList.remove('hidden');
                noPhotosMessage.querySelector('p').textContent = error.message;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        // Modal açma butonu
        const openModalBtn = document.querySelector('.btn-stock-photo');
        if (openModalBtn) {
            openModalBtn.onclick = function (e) {
                e.preventDefault();
                openModal();
            };
        } else {
            console.error('Modal açma butonu bulunamadı!');
        }

        // Modal dışına tıklama ile kapatma
        const modal = document.getElementById('stockPhotoModal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // ESC tuşu ile kapatma
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
                closeModal();
            }
        });
    });

    // Fotoğrafları render et
    function renderPhotos(photos) {
        const photosGrid = document.getElementById('stockPhotosGrid');
        if (!photosGrid) return;

        photosGrid.innerHTML = '';
        photos.forEach(photo => {
            const photoElement = document.createElement('div');
            photoElement.className = 'stock-photo-item';
            photoElement.innerHTML = `
                <img src="<?= Helper::upolads('images/stock_photos/') ?>${photo.url}" alt="${photo.title}">
                <div class="stock-photo-overlay">
                    <button class="btn btn-light">Seç</button>
                </div>
            `;

            photoElement.addEventListener('click', () => {
                selectPhoto(photoElement, photo.url);
            });

            photosGrid.appendChild(photoElement);
        });
    }

    // Fotoğraf seçimi
    function selectPhoto(element, photoUrl) {
        const allPhotos = document.querySelectorAll('.stock-photo-item');
        allPhotos.forEach(photo => photo.classList.remove('selected'));
        element.classList.add('selected');

        updateSelectedPhoto(photoUrl);
        closeModal();
    }

    // Seçilen fotoğrafı güncelle
    function updateSelectedPhoto(photoUrl) {
        const previewContainer = document.getElementById('image_preview');
        const fileInput = document.querySelector('input[name="campaign_image"]');

        if (previewContainer) {
            previewContainer.innerHTML = `<img src="<?= Helper::upolads('images/stock_photos/') ?>${photoUrl}" alt="Seçilen stok fotoğraf">`;
        }

        if (fileInput) {
            let hiddenInput = document.querySelector('input[name="selected_stock_photo"]');
            if (!hiddenInput) {
                hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_stock_photo';
                fileInput.parentNode.appendChild(hiddenInput);
            }
            hiddenInput.value = photoUrl;
        }
    }
</script>

<script>
    // Görsel işleme yardımcı fonksiyonları
    async function processImage(file) {
        const MAX_WIDTH = 640;
        const MAX_HEIGHT = 640;
        const QUALITY = 0.8;

        return new Promise((resolve, reject) => {
            if (!file || !file.type.startsWith('image/')) {
                reject(new Error('Geçersiz dosya formatı'));
                return;
            }

            const img = new Image();
            img.onload = async () => {
                let width = img.width;
                let height = img.height;
                
                if (width > MAX_WIDTH) {
                    height = Math.round((height * MAX_WIDTH) / width);
                    width = MAX_WIDTH;
                }
                
                if (height > MAX_HEIGHT) {
                    width = Math.round((width * MAX_HEIGHT) / height);
                    height = MAX_HEIGHT;
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                try {
                    // WebP formatına dönüştür ve base64'e çevir
                    const base64Data = canvas.toDataURL('image/webp', QUALITY);

                    resolve({
                        base64: base64Data,
                        width: width,
                        height: height,
                        size: Math.round((base64Data.length * 3) / 4) // Base64 boyutunu yaklaşık hesapla
                    });
                } catch (error) {
                    reject(error);
                }
            };

            img.onerror = () => reject(new Error('Görsel yüklenemedi'));
            img.src = URL.createObjectURL(file);
        });
    }

    // Dosya seçildiğinde önizleme ve işleme
    document.querySelector('input[name="campaign_image"]').addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (file) {
            try {
                // Stok fotoğraf seçimini temizle
                let stockPhotoInput = document.querySelector('input[name="selected_stock_photo"]');
                if (stockPhotoInput) {
                    stockPhotoInput.remove();
                }

                // Yükleme göstergesi
                const previewDiv = document.getElementById('image_preview');
                previewDiv.innerHTML = '<div class="loading-indicator"><div class="spinner"></div><p>Görsel işleniyor...</p></div>';

                // Görseli işle
                const processedImage = await processImage(file);
                
                // Önizleme göster
                previewDiv.innerHTML = `
                    <div class="preview-container">
                        <img src="${processedImage.base64}" alt="İşlenmiş görsel" style="max-width: 300px; margin-top: 10px;">
                        <div class="image-info" style="font-size: 12px; color: #666; margin-top: 5px;">
                            Boyut: ${(processedImage.size / 1024).toFixed(2)} KB
                            Genişlik: ${processedImage.width}px
                            Yükseklik: ${processedImage.height}px
                        </div>
                        <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeUploadedImage()">
                            <i class="fas fa-times"></i> Görseli Kaldır
                        </button>
                    </div>
                `;

                // Base64 verisini gizli input'a ekle
                let base64Input = document.querySelector('input[name="image_base64"]');
                if (!base64Input) {
                    base64Input = document.createElement('input');
                    base64Input.type = 'hidden';
                    base64Input.name = 'image_base64';
                    this.parentNode.appendChild(base64Input);
                }
                base64Input.value = processedImage.base64;

                // Görsel boyutlarını gizli input'lara ekle
                let dimensionsInput = document.createElement('input');
                dimensionsInput.type = 'hidden';
                dimensionsInput.name = 'image_dimensions';
                dimensionsInput.value = JSON.stringify({
                    width: processedImage.width,
                    height: processedImage.height,
                    size: processedImage.size
                });
                this.parentNode.appendChild(dimensionsInput);

            } catch (error) {
                console.error('Görsel işleme hatası:', error);
                const previewDiv = document.getElementById('image_preview');
                previewDiv.innerHTML = `
                    <div class="alert alert-danger">
                        Görsel işlenirken bir hata oluştu: ${error.message}
                    </div>
                `;
            }
        }
    });

    // Görseli kaldır
    function removeUploadedImage() {
        const previewDiv = document.getElementById('image_preview');
        const fileInput = document.querySelector('input[name="campaign_image"]');
        const base64Input = document.querySelector('input[name="image_base64"]');
        const dimensionsInput = document.querySelector('input[name="image_dimensions"]');
        
        if (previewDiv) previewDiv.innerHTML = '';
        if (fileInput) fileInput.value = '';
        if (base64Input) base64Input.remove();
        if (dimensionsInput) dimensionsInput.remove();
    }

    // Form gönderimi
    document.getElementById('campaignForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Form gönderimini engelle
        
        // Form verilerini kontrol et
        const fileInput = document.querySelector('input[name="campaign_image"]');
        const stockPhotoInput = document.querySelector('input[name="selected_stock_photo"]');
        const base64Input = document.querySelector('input[name="image_base64"]');
        
        // Görsel kontrolü
        if (!(stockPhotoInput && stockPhotoInput.value) && !(base64Input && base64Input.value)) {
            alert('Lütfen bir görsel seçin veya yükleyin!');
            return;
        }

        // Önizleme modalını göster
        showPreviewModal();
    });

    function showPreviewModal() {
        // Form verilerini al
        const title = document.querySelector('input[name="campaign_title"]').value;
        const description = document.querySelector('textarea[name="campaign_description"]').value;
        const startDate = new Date(document.querySelector('input[name="campaign_start_date"]').value);
        const endDate = new Date(document.querySelector('input[name="campaign_end_date"]').value);
        const type = document.querySelector('select[name="campaign_type"]').value;
        const discount = document.querySelector('input[name="campaign_discount"]').value;
        const minPurchase = document.querySelector('input[name="campaign_min_purchase"]').value;
        const details = document.querySelector('textarea[name="campaign_details"]').value;
        
        // Kampanya tipini Türkçe'ye çevir
        const campaignTypes = {
            'discount': 'İndirim',
            'bogo': '1 Alana 1 Bedava',
            'bundle': 'Paket İndirimi'
        };

        // Kalan gün sayısını hesapla
        const today = new Date();
        const diffTime = endDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        // Önizleme alanlarını doldur
        document.getElementById('previewTitle').textContent = title;
        document.getElementById('previewDescription').textContent = description;
        document.getElementById('previewDates').textContent = `${diffDays} gün kaldı`;
        document.getElementById('previewType').textContent = campaignTypes[type] || type;
        document.getElementById('previewMinPurchase').textContent = minPurchase ? `${minPurchase} TL` : '-';
        document.getElementById('previewDetails').textContent = details;
        
        // İndirim badge'ini göster
        const discountBadge = document.getElementById('previewDiscountBadge');
        if (discount) {
            discountBadge.textContent = `%${discount} İndirim`;
            discountBadge.style.display = 'block';
        } else {
            discountBadge.style.display = 'none';
        }

        // Koşulları listele
        const conditionsList = document.getElementById('previewConditions');
        conditionsList.innerHTML = '';
        selectedConditions.forEach(condition => {
            const li = document.createElement('li');
            li.textContent = condition;
            conditionsList.appendChild(li);
        });

        // Görseli ayarla
        const previewImage = document.getElementById('previewImage');
        const stockPhotoInput = document.querySelector('input[name="selected_stock_photo"]');
        const base64Input = document.querySelector('input[name="image_base64"]');

        if (stockPhotoInput && stockPhotoInput.value) {
            previewImage.src = `<?= Helper::upolads('images/stock_photos/') ?>${stockPhotoInput.value}`;
        } else if (base64Input && base64Input.value) {
            previewImage.src = base64Input.value;
        }

        // Modalı göster
        const modal = document.getElementById('previewModal');
        modal.classList.add('show');
    }

    function showFullDetails() {
        const fullDetails = document.getElementById('fullDetails');
        if (fullDetails.style.display === 'none') {
            fullDetails.style.display = 'block';
        } else {
            fullDetails.style.display = 'none';
        }
    }

    function closePreviewModal() {
        const modal = document.getElementById('previewModal');
        modal.classList.remove('show');
    }

    function submitCampaign() {
        // Görsel kaynağını belirle
        const stockPhotoInput = document.querySelector('input[name="selected_stock_photo"]');
        const imageSourceInput = document.createElement('input');
        imageSourceInput.type = 'hidden';
        imageSourceInput.name = 'image_source';
        imageSourceInput.value = stockPhotoInput && stockPhotoInput.value ? 'stock' : 'upload';
        
        // Form'a ekle ve gönder
        const form = document.getElementById('campaignForm');
        form.appendChild(imageSourceInput);
        form.submit();
    }

    // Modal dışına tıklama ile kapatma
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('previewModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closePreviewModal();
                }
            });
        }

        // ESC tuşu ile kapatma
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && modal.classList.contains('show')) {
                closePreviewModal();
            }
        });
    });
</script>




<?php
require_once __DIR__ . '/../../includes/footer.php';
?>