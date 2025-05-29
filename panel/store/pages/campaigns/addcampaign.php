<?php
require_once __DIR__ . '/../../includes/header.php';

require_once __DIR__ . "/../../../../classes/CampaignsSubCategories.php";

$subcategories = new CampaignsSubCategories();

$storeCategoryId = $_SESSION['user']['store_category'];
$altkategoriler = $subcategories->getSelectedColumns(['id', 'sub_category_name', 'sub_description'], ['store_categories_id' => $storeCategoryId]);

$errors = $session->getFlash('error');



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

    <?php if (!empty($errors) && is_array($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="campaignForm" class="campaign-form" action="<?= Helper::url('panel/store/pages/campaigns/preview.php') ?>"
        method="post" enctype="multipart/form-data">
        <?php echo $csrf->getTokenField(); ?>
        <div class="form-section">
            <h3>Kampanya Bilgileri</h3>
            <div class="form-group">
                <label for="campaign_title">Kampanya Başlığı</label>
                <input type="text" id="campaign_title" name="campaign_title" class="form-control" required
                    maxlength="255" placeholder="Mutfak Alışverişi"
                    value="<?= isset($_SESSION['campaign_form_data']['campaign_title']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_title']) : '' ?>">
                <div class="char-counter">
                    <span id="titleCharCount">0</span>/255
                </div>
            </div>

            <div class="form-group">
                <label for="campaign_description">Kampanya Açıklaması (Kısa Acıklamaları Giriniz)</label>
                <textarea id="campaign_description" name="campaign_description" class="form-control" rows="4" required
                    maxlength="255"
                    placeholder="Mutfak Alışverişiniz için geçerli ürünlerde %20 indirim"><?= isset($_SESSION['campaign_form_data']['campaign_description']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_description']) : '' ?></textarea>
                <div class="char-counter">
                    <span id="descriptionCharCount">0</span>/255
                </div>
            </div>

            <div class="form-group">
                <label for="">Kampanya Türünüzü Seçin</label>
                <select name="campaing_sub_id" id="campaing_sub_id" class="form-control" required>
                    <option value="">Seçiniz</option>
                    <?php
                    foreach ($altkategoriler as $ak) {
                        $selected = (isset($_SESSION['campaign_form_data']['campaing_sub_id']) && $_SESSION['campaign_form_data']['campaing_sub_id'] == $ak['id']) ? 'selected' : '';
                        ?>
                        <option value="<?= $ak['id'] ?>" <?= $selected ?>> <?= $ak['sub_category_name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <label for="">Alt Kampanya Türünüzü Seçin (Opsiyonel)</label>
                <select name="campaing_sub_sub_id" id="sub_sub_id" class="form-control">
                    <option value="">Seçiniz</option>
                </select>
            </div>
            <script>
                document.getElementById('campaing_sub_id').addEventListener('change', async function () {
                    const subId = this.value;
                    const subSubSelect = document.getElementById('sub_sub_id');

                    // Select'i temizle
                    subSubSelect.innerHTML = '<option value="">Seçiniz</option>';

                    if (!subId) {
                        subSubSelect.disabled = true;
                        return;
                    }

                    subSubSelect.disabled = false;

                    try {
                        const response = await fetch('<?= Helper::controller('subsubcategoriesController') ?>?action=getBySubId&sub_id=' + subId);
                        const data = await response.json();

                        if (data.success && data.data) {
                            data.data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.sub_sub_name;
                                subSubSelect.appendChild(option);
                            });
                        } else {
                            console.error('Veri alınamadı:', data.message);
                        }
                    } catch (error) {
                        console.error('Hata:', error);
                    }
                });

                // Form gönderilmeden önce kontrol
                document.getElementById('campaignForm').addEventListener('submit', function (e) {
                    const subId = document.getElementById('campaing_sub_id').value;

                    if (!subId) {
                        e.preventDefault();
                        alert('Lütfen kampanya türünü seçiniz!');
                        return;
                    }
                });
            </script>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_start_date">Başlangıç Tarihi</label>
                        <input type="datetime-local" id="campaign_start_date" name="campaign_start_date"
                            class="form-control" required
                            value="<?= isset($_SESSION['campaign_form_data']['campaign_start_date']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_start_date']) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="campaign_end_date">Bitiş Tarihi</label>
                        <input type="datetime-local" id="campaign_end_date" name="campaign_end_date"
                            class="form-control" required
                            value="<?= isset($_SESSION['campaign_form_data']['campaign_end_date']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_end_date']) : '' ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <style>
                .form-section {
                    background: #fff;
                    padding: 25px;
                    border-radius: 12px;
                    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
                    margin-bottom: 30px;
                }

                .form-section h3 {
                    color: #2d3748;
                    font-size: 1.25rem;
                    margin-bottom: 20px;
                    font-weight: 600;
                }

                .image-upload-options {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    margin-bottom: 15px;
                }

                .btn-stock-photo {
                    background: #f7fafc;
                    border: 2px dashed #e2e8f0;
                    color: #4a5568;
                    padding: 12px 20px;
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .btn-stock-photo:hover {
                    background: #edf2f7;
                    border-color: #cbd5e0;
                    color: #2d3748;
                }

                .btn-stock-photo i {
                    font-size: 1.1rem;
                    color: #4a5568;
                }

                .text-muted {
                    color: #718096;
                    font-size: 0.9rem;
                }

                input[type="file"] {
                    padding: 10px;
                    border: 2px dashed #e2e8f0;
                    border-radius: 8px;
                    width: 100%;
                    cursor: pointer;
                    transition: all 0.3s ease;
                }

                input[type="file"]:hover {
                    border-color: #cbd5e0;
                }

                .image-preview {
                    margin-top: 20px;
                    min-height: 200px;
                    border: 2px dashed #e2e8f0;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    position: relative;
                }

                .image-preview img {
                    max-width: 100%;
                    max-height: 300px;
                    object-fit: contain;
                }

                .image-preview:empty::before {
                    content: 'Görsel önizleme burada görünecek';
                    color: #a0aec0;
                    font-size: 0.9rem;
                }

                @media (max-width: 768px) {
                    .image-upload-options {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .text-muted {
                        text-align: center;
                    }
                }
            </style>
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
                <select id="campaign_type" name="campaign_type" class="form-control" required
                    onchange="toggleDiscountField()">
                    <option value="">Seçiniz</option>
                    <option value="discount" <?= (isset($_SESSION['campaign_form_data']['campaign_type']) && $_SESSION['campaign_form_data']['campaign_type'] == 'discount') ? 'selected' : '' ?>>% İndirim
                    </option>
                    <option value="discount_amount" <?= (isset($_SESSION['campaign_form_data']['campaign_type']) && $_SESSION['campaign_form_data']['campaign_type'] == 'discount_amount') ? 'selected' : '' ?>>TL İndirim
                    </option>
                    <option value="bogo" <?= (isset($_SESSION['campaign_form_data']['campaign_type']) && $_SESSION['campaign_form_data']['campaign_type'] == 'bogo') ? 'selected' : '' ?>>1 Alana 1 Bedava
                    </option>
                    <option value="bundle" <?= (isset($_SESSION['campaign_form_data']['campaign_type']) && $_SESSION['campaign_form_data']['campaign_type'] == 'bundle') ? 'selected' : '' ?>>Paket İndirimi
                    </option>
                </select>
            </div>


            <div class="form-group" id="discount_field_group" style="display: none;">
                <label for="campaign_discount">İndirim Oranı</label>
                <input type="number" id="campaign_discount" name="campaign_discount" class="form-control" min="0"
                    max="100"
                    value="<?= isset($_SESSION['campaign_form_data']['campaign_discount']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_discount']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="campaign_min_purchase">Minimum Alışveriş Tutarı(Alt limit Yok ise 0 giriniz)</label>
                <input type="number" id="campaign_min_purchase" name="campaign_min_purchase" class="form-control"
                    min="0"
                    value="<?= isset($_SESSION['campaign_form_data']['campaign_min_purchase']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_min_purchase']) : '0' ?>">
            </div>

            <div class="form-group">
                <label for="campaign_details">Kampanya İçerik Bilgisi (ürünler , kampanya veya hizmet özeti)</label>
                <textarea id="campaign_details" name="campaign_details" class="form-control" rows="4" required
                    placeholder="Kampanya içeriği hakkında bilgi giriniz"><?= isset($_SESSION['campaign_form_data']['campaign_details']) ? htmlspecialchars($_SESSION['campaign_form_data']['campaign_details']) : '' ?></textarea>
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
                                    <a href="javascript:void(0)" class="view-btn" onclick="showFullDetails()">Detayları
                                        Gör</a>
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

<link rel="stylesheet" href="<?= Helper::url('panel/store/assets/css/addcampaign.css') ?>">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Mevcut kampanya koşullarını yükle
        const selectedConditions = <?= isset($_SESSION['campaign_form_data']['conditions']) ? json_encode($_SESSION['campaign_form_data']['conditions']) : '[]' ?>;
        window.selectedConditions = selectedConditions; // Global değişkene ata

        // Koşulları container'a ekle
        const container = document.getElementById('selectedConditionsContainer');
        if (container && selectedConditions.length > 0) {
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
        }

        // Karakter sayaçlarını güncelle
        const titleInput = document.getElementById('campaign_title');
        const descriptionInput = document.getElementById('campaign_description');
        
        if (titleInput) {
            updateCharCounter(titleInput, 'titleCharCount');
            titleInput.addEventListener('input', function () {
                updateCharCounter(this, 'titleCharCount');
            });
        }
        
        if (descriptionInput) {
            updateCharCounter(descriptionInput, 'descriptionCharCount');
            descriptionInput.addEventListener('input', function () {
                updateCharCounter(this, 'descriptionCharCount');
            });
        }

        // Kampanya tipi seçiliyse indirim alanını göster
        const campaignType = document.getElementById('campaign_type');
        if (campaignType && campaignType.value === 'discount' || campaignType.value === 'discount_amount') {
            document.getElementById('discount_field_group').style.display = 'block';
        }

        // Alt kategori seçiliyse alt alt kategorileri yükle
        const subCategorySelect = document.getElementById('campaing_sub_id');
        if (subCategorySelect && subCategorySelect.value) {
            loadSubSubCategories(subCategorySelect.value);
        }
    });

    function updateCharCounter(input, counterId) {
        const counter = document.getElementById(counterId);
        if (counter) {
            counter.textContent = input.value.length;
        }
    }

    function openConditionsModal() {
        const modal = document.getElementById('conditionsModal');
        modal.classList.add('show');
        renderConditionsList();
    }

    function closeConditionsModal() {
        const modal = document.getElementById('conditionsModal');
        modal.classList.remove('show');
    }

    function renderConditionsList(conditions = []) {
        const list = document.getElementById('conditionsList');
        if (!list) return;
        
        list.innerHTML = '';

        // Tüm koşulları birleştir ve tekrarları kaldır
        const allConditions = [...new Set([...conditions, ...window.selectedConditions])];

        allConditions.forEach((condition, index) => {
            const isChecked = window.selectedConditions.includes(condition);
            const div = document.createElement('div');
            div.className = 'condition-checkbox';
            div.innerHTML = `
                <input type="checkbox" id="condition${index}" ${isChecked ? 'checked' : ''}>
                <label for="condition${index}">${condition}</label>
            `;

            const checkbox = div.querySelector('input');
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    if (!window.selectedConditions.includes(condition)) {
                        window.selectedConditions.push(condition);
                    }
                } else {
                    window.selectedConditions = window.selectedConditions.filter(c => c !== condition);
                }
            });

            list.appendChild(div);
        });
    }

    function saveConditions() {
        const container = document.getElementById('selectedConditionsContainer');
        if (!container) return;
        
        container.innerHTML = '';

        window.selectedConditions.forEach(condition => {
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
        window.selectedConditions = window.selectedConditions.filter(c => c !== condition);
        saveConditions();
    }

    function addCustomCondition() {
        const input = document.getElementById('customCondition');
        const condition = input.value.trim();

        if (condition) {
            if (!window.selectedConditions.includes(condition)) {
                window.selectedConditions.push(condition);
                renderConditionsList();
            }
            input.value = '';
        }
    }

    function applyTemplate() {
        const templateSelect = document.getElementById('conditionTemplate');
        const selectedTemplate = templateSelect.value;

        if (selectedTemplate && templates[selectedTemplate]) {
            renderConditionsList(templates[selectedTemplate]);
        }
    }

    function loadSubSubCategories(subId) {
        const subSubSelect = document.getElementById('sub_sub_id');
        if (!subSubSelect) return;

        fetch('<?= Helper::controller('subsubcategoriesController') ?>?action=getBySubId&sub_id=' + subId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    subSubSelect.innerHTML = '<option value="">Seçiniz</option>';
                    data.data.forEach(item => {
                        const selected = '<?= isset($_SESSION['campaign_form_data']['campaing_sub_sub_id']) ? $_SESSION['campaign_form_data']['campaing_sub_sub_id'] : '' ?>' == item.id ? 'selected' : '';
                        subSubSelect.innerHTML += `<option value="${item.id}" ${selected}>${item.sub_sub_name}</option>`;
                    });
                }
            })
            .catch(error => console.error('Hata:', error));
    }

    // Modal işlemleri
    async function openModal() {
        const subCategoryId = document.getElementById('campaing_sub_id').value;
        const subSubCategoryId = document.getElementById('sub_sub_id').value;

        // Alt kategori seçilmemişse uyarı ver
        if (!subCategoryId) {
            alert('Lütfen önce kampanya tipini seçiniz');
            return;
        }

        const modal = document.getElementById('stockPhotoModal');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';

        // Modal açıldığında fotoğrafları yükle
        await loadPhotos(subCategoryId, subSubCategoryId);
    }

    function closeModal() {
        const modal = document.getElementById('stockPhotoModal');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Fotoğrafları yükle
    async function loadPhotos(subCategoryId, subSubCategoryId) {
        const photosGrid = document.getElementById('stockPhotosGrid');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const noPhotosMessage = document.getElementById('noPhotosMessage');

        try {
            if (loadingIndicator) loadingIndicator.classList.remove('hidden');
            if (photosGrid) photosGrid.innerHTML = '';
            if (noPhotosMessage) noPhotosMessage.classList.add('hidden');

            const formData = new FormData();
            formData.append('action', 'getPhotos');
            formData.append('sub_id', subCategoryId);
            formData.append('sub_sub_id', subSubCategoryId || '0');
            formData.append('token', '<?= $csrf->getToken() ?>');

            const response = await fetch('<?= Helper::url('api/stock-photos.php') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (loadingIndicator) loadingIndicator.classList.add('hidden');

            if (!result.success || !result.data || result.data.length === 0) {
                if (noPhotosMessage) noPhotosMessage.classList.remove('hidden');
                return;
            }

            renderPhotos(result.data);
        } catch (error) {
            console.error('Error:', error);
            if (loadingIndicator) loadingIndicator.classList.add('hidden');
            if (noPhotosMessage) {
                noPhotosMessage.classList.remove('hidden');
                noPhotosMessage.querySelector('p').textContent = 'Fotoğraflar yüklenirken bir hata oluştu';
            }
        }
    }

    // Fotoğrafları render et
    function renderPhotos(photos) {
        const photosGrid = document.getElementById('stockPhotosGrid');
        if (!photosGrid) return;

        photosGrid.innerHTML = '';
        photos.forEach(photo => {
            const photoElement = document.createElement('div');
            photoElement.className = 'stock-photo-item';
            photoElement.innerHTML = `
                <img src="<?= Helper::upolads('images/stock_photos/') ?>${photo.url}" alt="${photo.stock_photo_title}">
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

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function () {
        // Modal açma butonu
        const openModalBtn = document.querySelector('.btn-stock-photo');
        if (openModalBtn) {
            openModalBtn.onclick = function (e) {
                e.preventDefault();
                openModal();
            };
        }

        // Dosya yükleme input'u için event listener
        const fileInput = document.querySelector('input[name="campaign_image"]');
        if (fileInput) {
            fileInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Stok fotoğraf seçimini temizle
                    const stockPhotoInput = document.querySelector('input[name="selected_stock_photo"]');
                    if (stockPhotoInput) {
                        stockPhotoInput.remove();
                    }

                    // Önizleme alanını temizle ve yeni görseli göster
                    const previewContainer = document.getElementById('image_preview');
                    if (previewContainer) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewContainer.innerHTML = `
                                <div class="preview-container">
                                    <img src="${e.target.result}" alt="Seçilen görsel" style="max-width: 300px; margin-top: 10px;">
                                    <div class="image-info" style="font-size: 12px; color: #666; margin-top: 5px;">
                                        Dosya: ${file.name}<br>
                                        Boyut: ${(file.size / 1024).toFixed(2)} KB
                                    </div>
                                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeUploadedImage()">
                                        <i class="fas fa-times"></i> Görseli Kaldır
                                    </button>
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });
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

    // Yüklenen görseli kaldır
    function removeUploadedImage() {
        const previewContainer = document.getElementById('image_preview');
        const fileInput = document.querySelector('input[name="campaign_image"]');

        if (previewContainer) {
            previewContainer.innerHTML = '';
        }
        if (fileInput) {
            fileInput.value = '';
        }
    }

    function toggleDiscountField() {
        const campaignType = document.getElementById('campaign_type').value;
        const discountFieldGroup = document.getElementById('discount_field_group');
        const discountLabel = discountFieldGroup.querySelector('label');
        const discountInput = document.getElementById('campaign_discount');

        if (campaignType === 'discount') {
            discountFieldGroup.style.display = 'block';
            discountLabel.textContent = 'İndirim Oranı (%)';
            discountInput.max = '100';
            discountInput.placeholder = '0-100 arası bir değer giriniz';
        } else if (campaignType === 'discount_amount') {
            discountFieldGroup.style.display = 'block';
            discountLabel.textContent = 'İndirim Tutarı (TL)';
            discountInput.max = '999999';
            discountInput.placeholder = 'İndirim tutarını giriniz';
        } else {
            discountFieldGroup.style.display = 'none';
        }
    }

    // Sayfa yüklendiğinde mevcut seçimi kontrol et
    document.addEventListener('DOMContentLoaded', function() {
        toggleDiscountField();
    });
</script>

<style>
    .stock-photo-item {
        width: 150px;
        height: 150px;
        margin: 10px;
        border: 2px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .stock-photo-item:hover {
        border-color: #007bff;
        transform: scale(1.05);
    }

    .stock-photo-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stock-photo-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stock-photo-item:hover .stock-photo-overlay {
        opacity: 1;
    }

    .stock-photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 15px;
        padding: 15px;
        max-height: 500px;
        overflow-y: auto;
    }

    .loading-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .loading-indicator .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .message-box {
        text-align: center;
        padding: 20px;
        color: #666;
    }

    .message-box i {
        font-size: 24px;
        margin-bottom: 10px;
        color: #dc3545;
    }

    .hidden {
        display: none;
    }
</style>



<?php
require_once __DIR__ . '/../../includes/footer.php';
?>