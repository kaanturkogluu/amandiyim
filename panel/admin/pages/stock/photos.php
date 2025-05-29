<?php
require_once __DIR__ . '/../../includes/header.php';
require_once classes . 'StoreCategories.php';

require_once classes . 'StockPhoto.php';

$storecategories = new StoreCategories();
$stockPhotos = new StockPhoto();

$storecategories = $storecategories->all();


?>

<div class="container">
            <div class="card">
                <div class="card-header">
            <div class="header-content">
                <h3 class="card-title">Stok Fotoğrafları</h3>
                        <div class="card-tools">
                    <button type="button" class="btn" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Yeni Fotoğraf Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
            <!-- Kategori Seçimi -->
            <div class="category-selectors">
                <div class="select-group">
                    <div class="select-item">
                        <label for="mainCategory">Ana Kategori</label>
                        <select id="mainCategory" onchange="loadSubCategories()">
                            <option value="">Seçiniz</option>
                            <?php foreach ($storecategories as $category): ?>
                                <option value="<?= $category['id'] ?>">
                                    <?= htmlspecialchars($category['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="select-item">
                        <label for="subCategory">Alt Kategori</label>
                        <select id="subCategory" onchange="loadSubSubCategories()" disabled>
                            <option value="">Önce Ana Kategori Seçin</option>
                        </select>
                    </div>
                    <div class="select-item">
                        <label for="subSubCategory">Alt Alt Kategori</label>
                        <select id="subSubCategory" disabled>
                            <option value="">Önce Alt Kategori Seçin</option>
                        </select>
                    </div>
                </div>
                <div class="button-group">
                    <button id="getir" class="btn" onclick="getPhotos()">Eşleşmeleri Getir</button>
                </div>
            </div>

            <div id="photosContainer" class="photos-grid">
                <!-- Fotoğraflar buraya gelecek -->
            </div>
        </div>
    </div>
</div>

<!-- Yeni Fotoğraf Ekleme Modalı -->
<div id="addPhotoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Yeni Fotoğraf Ekle</h2>
            <span class="close" onclick="closeAddModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addPhotoForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photoTitle">Fotoğraf Başlığı</label>
                    <input type="text" id="photoTitle" name="title" required>
                </div>
                <div class="form-group">
                    <label for="modalMainCategory">Ana Kategori</label>
                    <select id="modalMainCategory" name="main_category" required onchange="loadModalSubCategories()">
                        <option value="">Seçiniz</option>
                        <?php foreach ($storecategories as $category): ?>
                            <option value="<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['category_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modalSubCategory">Alt Kategori</label>
                    <select id="modalSubCategory" name="sub_category" required onchange="loadModalSubSubCategories()"
                        disabled>
                        <option value="">Önce Ana Kategori Seçin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="modalSubSubCategory">Alt Alt Kategori</label>
                    <select id="modalSubSubCategory" name="sub_sub_category" disabled>
                        <option value="">Önce Alt Kategori Seçin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="photoFile">Fotoğraf</label>
                    <div class="file-upload">
                        <input type="file" id="photoFile" name="photo" accept="image/*" required
                            onchange="previewImage(this)">
                        <div class="file-upload-preview">
                            <img id="imagePreview" src="" alt="Preview" style="display: none;">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Fotoğraf seçmek için tıklayın</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .photo-item {
        transition: all 0.3s ease;
    }

    .photo-item:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .btn-group {
        width: 100%;
    }

    .btn-group .btn {
        flex: 1;
    }

    #currentImage {
        text-align: center;
        margin-top: 10px;
    }

    #currentImage img {
        max-width: 100%;
        height: auto;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .category-selectors {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .select-group {
        display: flex;
        gap: 20px;
    }

    .select-item {
        flex: 1;
    }

    .select-item label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
        font-size: 14px;
    }

    .select-item select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 14px;
        color: #495057;
        background-color: #fff;
        height: 38px;
    }

    .select-item select:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
    }

    .select-item select:focus {
        outline: none;
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .button-group {
        margin-top: 1rem;
        text-align: center;
    }

    .photos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
        margin-top: 2rem;
    }

    .photo-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .photo-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .photo-info {
        padding: 1rem;
    }

    .photo-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 500;
    }

    .photo-category {
        color: #666;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .loading {
        text-align: center;
        padding: 2rem;
        font-size: 1.2rem;
        color: #666;
    }

    .no-photos {
        text-align: center;
        padding: 2rem;
        color: #666;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .select-group {
            flex-direction: column;
            gap: 15px;
        }

        .container {
            padding: 10px;
        }

        .card-header {
            padding: 10px 15px;
        }

        .card-body {
            padding: 15px;
        }
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #333;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #333;
    }

    .form-group input[type="text"],
    .form-group select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .form-group input[type="file"] {
        width: 100%;
        padding: 8px 0;
    }

    .image-preview {
        margin-top: 10px;
        max-width: 200px;
        max-height: 200px;
        overflow: hidden;
        border-radius: 4px;
    }

    .image-preview img {
        width: 100%;
        height: auto;
        display: none;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .file-upload {
        position: relative;
        width: 100%;
    }

    .file-upload-preview {
        width: 100%;
        height: 200px;
        border: 2px dashed #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .file-upload-preview:hover {
        border-color: #007bff;
    }

    .file-upload input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .upload-placeholder {
        text-align: center;
        color: #666;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        z-index: 1;
    }

    .upload-placeholder i {
        font-size: 48px;
        margin-bottom: 10px;
        color: #007bff;
        display: block;
    }

    .upload-placeholder span {
        display: block;
        font-size: 14px;
    }

    .file-upload-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: relative;
        z-index: 1;
    }

    .photo-image-container {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .photo-overlay {
        position: absolute;
        top: 0;
        right: 0;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .photo-card:hover .photo-overlay {
        opacity: 1;
    }

    .delete-btn {
        background-color: rgba(255, 0, 0, 0.8);
        color: white;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: rgba(255, 0, 0, 1);
    }

    .delete-btn i {
        font-size: 14px;
    }
</style>

<script>
    function loadSubCategories() {
        const mainCategoryId = document.getElementById('mainCategory').value;
        const subCategorySelect = document.getElementById('subCategory');
        const subSubCategorySelect = document.getElementById('subSubCategory');

        // Alt kategori select'ini sıfırla ve devre dışı bırak
        subCategorySelect.innerHTML = '<option value="">Yükleniyor...</option>';
        subCategorySelect.disabled = true;

        // Alt alt kategori select'ini sıfırla ve devre dışı bırak
        subSubCategorySelect.innerHTML = '<option value="">Önce Alt Kategori Seçin</option>';
        subSubCategorySelect.disabled = true;

        // Ana kategori seçilmemişse
        if (!mainCategoryId) {
            subCategorySelect.innerHTML = '<option value="">Önce Ana Kategori Seçin</option>';
            return;
        }

        // Alt kategorileri getir
        fetch('<?= Helper::url('api/categoriesApi.php') ?>?action=getSubCategories&main_id=' + mainCategoryId + '&token=<?= $csrf->getToken() ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    // Select'i temizle ve yeni seçenekleri ekle
                    subCategorySelect.innerHTML = '<option value="">Seçiniz</option>';
                    data.data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.sub_category_name;
                        subCategorySelect.appendChild(option);
                    });
                    // Select'i aktif et
                    subCategorySelect.disabled = false;
                } else {
                    subCategorySelect.innerHTML = '<option value="">Alt kategori bulunamadı</option>';
                    console.error('Veri alınamadı:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subCategorySelect.innerHTML = '<option value="">Bir hata oluştu</option>';
            });
    }

    function loadSubSubCategories() {
        const subCategoryId = document.getElementById('subCategory').value;
        const subSubCategorySelect = document.getElementById('subSubCategory');

        // Alt alt kategori select'ini sıfırla ve devre dışı bırak
        subSubCategorySelect.innerHTML = '<option value="">Yükleniyor...</option>';
        subSubCategorySelect.disabled = true;

        // Alt kategori seçilmemişse
        if (!subCategoryId) {
            subSubCategorySelect.innerHTML = '<option value="">Önce Alt Kategori Seçin</option>';
            return;
        }

        // Alt alt kategorileri getir
        fetch('<?= Helper::controller('subsubcategoriesController') ?>?action=getBySubId&sub_id=' + subCategoryId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    // Select'i temizle ve yeni seçenekleri ekle
                    subSubCategorySelect.innerHTML = '<option value="">Seçiniz</option>';
                    data.data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.sub_sub_name;
                        subSubCategorySelect.appendChild(option);
                    });
                    // Select'i aktif et
                    subSubCategorySelect.disabled = false;
                } else {
                    subSubCategorySelect.innerHTML = '<option value="">Alt alt kategori bulunamadı</option>';
                    console.error('Veri alınamadı:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subSubCategorySelect.innerHTML = '<option value="">Bir hata oluştu</option>';
            });
    }

    function filterPhotos() {
        const mainCategoryId = document.getElementById('mainCategory').value;
        const subCategoryId = document.getElementById('subCategory').value;
        const subSubCategoryId = document.getElementById('subSubCategory').value;
        const photos = document.querySelectorAll('.photo-item');

        photos.forEach(photo => {
            const matchesMain = !mainCategoryId || photo.dataset.mainCategory === mainCategoryId;
            const matchesSub = !subCategoryId || photo.dataset.subCategory === subCategoryId;
            const matchesSubSub = !subSubCategoryId || photo.dataset.subSubCategory === subSubCategoryId;

            if (matchesMain && matchesSub && matchesSubSub) {
                photo.style.display = 'block';
            } else {
                photo.style.display = 'none';
            }
        });
    }

    function getPhotos() {
        const mainCategoryId = document.getElementById('mainCategory').value;
        const subCategoryId = document.getElementById('subCategory').value;
        const subSubCategoryId = document.getElementById('subSubCategory').value || '0';
        const photosContainer = document.getElementById('photosContainer');

        // Yükleniyor mesajını göster
        photosContainer.innerHTML = '<div class="loading">Fotoğraflar yükleniyor...</div>';

        // API'ye istek at
        fetch('<?= Helper::url('api/categoriesApi.php') ?>?action=getPhotos&main_id=' + mainCategoryId +
            '&sub_id=' + subCategoryId + '&sub_sub_id=' + subSubCategoryId +
            '&token=<?= $csrf->getToken() ?>')
            .then(response => response.json())

            .then(data => {
                console.log(data);
                if (data.success && data.data) {
                    if (data.data.length === 0) {
                        photosContainer.innerHTML = '<div class="no-photos">Seçilen kategorilerde fotoğraf bulunamadı</div>';
                        return;
                    }

                    // Fotoğrafları grid'e ekle
                    photosContainer.innerHTML = data.data.map(photo => `
                        <div class="photo-card">
                            <div class="photo-image-container">
                                <img src="<?= Helper::upolads('images/stock_photos/') ?>${photo.url}" 
                                     alt="${photo.stock_photo_title}" 
                                     class="photo-image">
                                <div class="photo-overlay">
                                    <button class="delete-btn" onclick="deletePhoto(${photo.id})">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="photo-info">
                                <h3 class="photo-title">${photo.stock_photo_title}</h3>
                                <div class="photo-category">
                                    ${photo.category_name}
                                    ${photo.sub_category_name ? ' > ' + photo.sub_category_name : ''}
                                    ${photo.sub_sub_category_name ? ' > ' + photo.sub_sub_category_name : ''}
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    photosContainer.innerHTML = '<div class="no-photos"> ' + data.message + ' </div>';

                }
            })
            .catch(error => {
                console.error('Error:', error);
                photosContainer.innerHTML = '<div class="no-photos">Bir hata oluştu</div>';
            });
    }

    function openAddModal() {
        document.getElementById('addPhotoModal').style.display = 'block';
    }

    function closeAddModal() {
        document.getElementById('addPhotoModal').style.display = 'none';
        document.getElementById('addPhotoForm').reset();
        document.getElementById('imagePreview').src = '';
    }

    function loadModalSubCategories() {
        const mainCategoryId = document.getElementById('modalMainCategory').value;
        const subCategorySelect = document.getElementById('modalSubCategory');
        const subSubCategorySelect = document.getElementById('modalSubSubCategory');

        subCategorySelect.innerHTML = '<option value="">Yükleniyor...</option>';
        subCategorySelect.disabled = true;
        subSubCategorySelect.innerHTML = '<option value="">Önce Alt Kategori Seçin</option>';
        subSubCategorySelect.disabled = true;

        if (!mainCategoryId) {
            subCategorySelect.innerHTML = '<option value="">Önce Ana Kategori Seçin</option>';
            return;
        }

        fetch('<?= Helper::url('api/categoriesApi.php') ?>?action=getSubCategories&main_id=' + mainCategoryId + '&token=<?= $csrf->getToken() ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    subCategorySelect.innerHTML = '<option value="">Seçiniz</option>';
                    data.data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.sub_category_name;
                        subCategorySelect.appendChild(option);
                    });
                    subCategorySelect.disabled = false;
                } else {
                    subCategorySelect.innerHTML = '<option value="">Alt kategori bulunamadı</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subCategorySelect.innerHTML = '<option value="">Bir hata oluştu</option>';
            });
    }

    function loadModalSubSubCategories() {
        const subCategoryId = document.getElementById('modalSubCategory').value;
        const subSubCategorySelect = document.getElementById('modalSubSubCategory');

        subSubCategorySelect.innerHTML = '<option value="">Yükleniyor...</option>';
        subSubCategorySelect.disabled = true;

        if (!subCategoryId) {
            subSubCategorySelect.innerHTML = '<option value="">Önce Alt Kategori Seçin</option>';
            return;
        }

        fetch('<?= Helper::controller('subsubcategoriesController') ?>?action=getBySubId&sub_id=' + subCategoryId)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    subSubCategorySelect.innerHTML = '<option value="">Seçiniz</option>';
                    data.data.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.sub_sub_name;
                        subSubCategorySelect.appendChild(option);
                    });
                    subSubCategorySelect.disabled = false;
                } else {
                    subSubCategorySelect.innerHTML = '<option value="">Alt alt kategori bulunamadı</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subSubCategorySelect.innerHTML = '<option value="">Bir hata oluştu</option>';
            });
    }

    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        const placeholder = document.querySelector('.upload-placeholder');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'block';
        }
    }

    // Form gönderimi
    document.getElementById('addPhotoForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        formData.append('_token', '<?= $csrf->getToken() ?>');
        formData.append('action', 'create');

        // Yükleniyor durumunu göster
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Yükleniyor...';

        fetch('<?= Helper::controller('stockPhotosController') ?>', {
                method: 'POST',
                body: formData
        })
            .then(response => response.json())
            .then(data => {

                if (data.success) {
                    alert('Fotoğraf başarıyla eklendi');
                    closeAddModal();
                    getPhotos(); // Fotoğrafları yeniden yükle
                } else {
                    alert(data.message || 'Bir hata oluştu');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu');
            })
            .finally(() => {
                // Butonu eski haline getir
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
    });

    // Modal dışına tıklandığında kapatma
    window.onclick = function (event) {
        const modal = document.getElementById('addPhotoModal');
        if (event.target == modal) {
            closeAddModal();
        }
    }

    function deletePhoto(photoId) {
        if (confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) {
            const formData = new FormData();
            formData.append('action', 'deletePhoto');
            formData.append('id', photoId);
            formData.append('token', '<?= $csrf->getToken() ?>');

            fetch('<?= Helper::url('api/categoriesApi.php') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Fotoğraf başarıyla silindi');
                    getPhotos(); // Fotoğrafları yeniden yükle
                } else {
                    alert(data.message || 'Bir hata oluştu');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Bir hata oluştu');
            });
        }
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>