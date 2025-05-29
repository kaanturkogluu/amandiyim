<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Stores.php';
require_once __DIR__ . '/../../../classes/StoreCategories.php';

$c = new StoreCategories();
$kategoriler = $c->all();
$storeStatus = ['active' => ["Aktif", "active"], "blocked" => ["Engellenmiş", "inactive"], "waiting" => ["Beklemede", "inactive"], 'suspend' => ['Askıda', 'inactive']];

$storesObject = new Stores();
// GET parametrelerinden sayfa, sıralama ve arama bilgilerini al

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$currentFilter = $_GET['filter'] ?? 'all';
if (isset($_GET['search']) && !empty($_GET['search'])) {


    $search = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');


    $stores = $storesObject->searchStores(['store_name' => $search, 'store_owner_phone' => $search]);
    $stores['total_pages'] = 'none';

} else {
    switch ($currentFilter) {
        case 'all':
            $stores = $storesObject->getAllStoresWithPage($page);
            break;

        case 'active':
            $stores = $storesObject->getActiveStoresWithPage($page);
            break;

        default:
            // Geçersiz filtre geldiğinde varsayılanı çalıştır
            $stores = $storesObject->getAllStoresWithPage();
            break;
    }

}

$totalPages = $stores['total_pages'];
$stores = $stores['data'];











?>
 

<div class="admin-content">
    <div class="content-header">
        <h1>Mağazalar</h1>
        <button class="btn btn-primary" onclick="openAddStoreModal()">
            <i class="fas fa-plus"></i> Yeni Mağaza Ekle
        </button>
    </div>

    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <form action="" method="get">
                <input type="text" placeholder="Mağaza ara..." name="search" id="storeSearch">
                <button type="submit" style="display:none;"></button>


            </form>
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active" data-filter="all"
                onclick="window.location.href='<?= Helper::adminViewWithParams('stores', 'filter', 'all') ?>'">Tümü</button>
            <button class="btn btn-outline" data-filter="active"
                onclick="window.location.href='<?= Helper::adminViewWithParams('stores', 'filter', 'active') ?>'">Aktif</button>
        </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Mağaza Adı</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Adres</th>
                    <th>Durum</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <!-- Örnek veri -->
                <?php
                if ($stores) {
                    foreach ($stores as $s) {
                        ?>
                        <tr>


                            <td><?= $s['store_name'] ?></td>
                            <td><?= $s['store_owner_mail'] ?></td>
                            <td><?= $s['store_owner_phone'] ?></td>
                            <td><?= $s['store_adress'] ?></td>
                            <td>

                                <span
                                    class="status-badge <?= $storeStatus[$s['store_statu']][1] ?>"><?= $storeStatus[$s['store_statu']][0] ?></span>
                            </td>
                            <td><?= $s['created_at'] ?></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-icon" onclick="openUpdateStoreModal(<?= $s['id'] ?>)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon" onclick="deleteStore(<?= $s['id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>

    <?php
    if (is_numeric($totalPages)) {
        ?>
        <div class="pagination">
            <!-- Önceki Sayfa Butonu -->
            <button class="btn btn-outline <?= $page <= 1 ? 'disabled' : '' ?>"
                onclick="window.location.href='?page=<?= $page - 1 ?>&filter=<?= $currentFilter ?>'">
                <i class="fas fa-chevron-left"></i>
            </button>


            <!-- Sayfa Numaraları -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <button class="btn btn-outline <?= $i == $page ? 'active' : '' ?>"
                    onclick="window.location.href='?page=<?= $i ?>&filter=<?= $currentFilter ?>'">
                    <?= $i ?>
                </button>
            <?php endfor; ?>


            <!-- Sonraki Sayfa Butonu -->
            <button class="btn btn-outline <?= $page >= $totalPages ? 'disabled' : '' ?>"
                onclick="window.location.href='?page=<?= $page + 1 ?>&filter=<?= $currentFilter ?>'">
                <i class="fas fa-chevron-right"></i>
            </button>

        </div>

        <?php
    }
    ?>


</div>

<!-- Mağaza Ekleme/ -->
<div class="modal" id="storeModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Yeni Mağaza Ekle</h2>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="storeForm">
                <!-- Mağaza Bilgileri -->
                <input type="hidden" name="action" value="add">
                <?php
                echo $csrf->getTokenField();
                ?>
                <div class="form-section">
                    <h3>Mağaza Bilgileri</h3>
                    <div class="form-group">
                        <label>Mağaza Adı</label>
                        <input type="text" name="store_name" required>
                    </div>
                    <div class="form-group">
                        <label>Mağaza Türü</label>
                        <select name="store_category">
                            <?php
                            foreach ($kategoriler as $k) {
                                ?>
                                <option value="<?= $k['id'] ?>"><?= $k['category_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mağaza Telefonu</label>
                        <input type="tel" name="store_phone" required>
                    </div>
                   
                    <div class="form-group">
                        <label>Mağaza Logosu</label>
                        <input type="file" name="store_logo" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Mağaza Ana Görseli</label>
                        <input type="file" name="store_main_image" accept="image/*">
                    </div>
                </div>

                <!-- Konum Bilgileri -->
                <div class="form-section">
                    <h3>Konum Bilgileri</h3>
                    <div class="form-group">
                        <label>Adres</label>
                        <textarea name="store_adress" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Açık Adres</label>
                        <textarea name="local_adress"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Konum (Enlem, Boylam)</label>
                        <div class="location-input-group">
                            <input type="text" name="store_location" id="store_location"
                                placeholder="Haritadan seçin veya koordinat girin" required>
                            <button onclick="konumuAl()" type="button" class="btn btn-outline"
                                onclick="openLocationPicker()">
                                <i class="fas fa-map-marker-alt"></i> Konum Al
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Açılış Saati</label>
                        <input type="time" name="store_opening_time">
                    </div>
                    <div class="form-group">
                        <label>Kapanis Saati</label>
                        <input type="time" name="store_closing_time">
                    </div>
                </div>

                <!-- Yetkili Bilgileri -->
                <div class="form-section">
                    <h3>Yetkili Bilgileri</h3>
                    <div class="form-group">
                        <label>Yetkili Adı</label>
                        <input type="text" name="store_owner_name" required>
                    </div>
                    <div class="form-group">
                        <label>Yetkili E-posta</label>
                        <input type="email" name="store_owner_mail" required>
                    </div>
                    <div class="form-group">
                        <label>Yetkili Telefon</label>
                        <input type="tel" name="store_owner_phone" required>
                    </div>
                    <div class="form-group">
                        <label>Şifre</label>
                        <input type="password" name="store_owner_password" required>
                    </div>
                </div>

                <!-- Diğer Ayarlar -->
                <div class="form-section">
                    <h3>Diğer Ayarlar</h3>
                    <div class="form-group">
                        <label>Başlangıç Kredisi</label>
                        <input type="number" name="store_credits" value="2800" required>
                    </div>
                    <div class="form-group">
                        <label>Durum</label>
                        <select name="store_statu" required>
                            <option value="active">Aktif</option>
                            <option value="waiting">Beklemede</option>
                            <option value="suspend">Askıda</option>
                            <option value="blocked">Engellenmiş</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                    <button type="button" class="btn btn-outline" onclick="closeModal()">İptal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Düzenleme Modal  -->
<div class="modal" id="updateStoreModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Mağaza Düzenle</h2>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="updateStoreForm">
                <!-- Mağaza Bilgileri -->

                <input type="hidden" name="action" value="update">
                <input type="hidden" name="update_store_id" id="update_store_id">
                <?php
                echo $csrf->getTokenField();
                ?>
                <div class="form-section">
                    <h3>Mağaza Bilgileri</h3>
                    <div class="form-group">
                        <label>Mağaza Adı</label>
                        <input type="text" name="update_store_name" required>
                    </div>
                    <div class="form-group">
                        <label>Mağaza Türü</label>
                        <select name="update_store_category">
                            <?php
                            foreach ($kategoriler as $k) {
                                ?>
                                <option value="<?= $k['id'] ?>"><?= $k['category_name'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mağaza Telefonu</label>
                        <input type="tel" name="update_store_phone" required>
                    </div>
                 
                    <div class="form-group">
                        <label>Mağaza Logosu</label>
                        <input type="file" name="update_store_logo" accept="image/*">
                        <img height="100" src="" alt="" id="update_store_logo_preview">
                    </div>
                    <div class="form-group">
                        <label>Mağaza Ana Görseli</label>
                        <input type="file" name="update_store_main_image" accept="image/*">
                        <img height="100" width="100" src="" alt="" id="update_store_main_image_preview">
                    </div>
                </div>

                <!-- Konum Bilgileri -->
                <div class="form-section">
                    <h3>Konum Bilgileri</h3>
                    <div class="form-group">
                        <label>Adres</label>
                        <textarea name="update_store_adress" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Açık Adres</label>
                        <textarea name="update_local_adress"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Açılış Saati</label>
                        <input type="time" name="update_store_opening_time">
                    </div>
                    <div class="form-group">
                        <label>Kapanis Saati</label>
                        <input type="time" name="update_store_closing_time">
                    </div>

                    <div class="form-group">
                        <label>Konum (Enlem, Boylam)</label>
                        <div class="location-input-group">
                            <input type="text" name="update_store_location" id="update_store_location"
                                placeholder="Haritadan seçin veya koordinat girin" required>
                            <button onclick="konumuAl()" type="button" class="btn btn-outline">
                                <i class="fas fa-map-marker-alt"></i> Konum Al
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Yetkili Bilgileri -->
                <div class="form-section">
                    <h3>Yetkili Bilgileri</h3>
                    <div class="form-group">
                        <label>Yetkili Adı</label>
                        <input type="text" name="update_store_owner_name" required>
                    </div>
                    <div class="form-group">
                        <label>Yetkili E-posta</label>
                        <input type="email" name="update_store_owner_mail" required>
                    </div>
                    <div class="form-group">
                        <label>Yetkili Telefon</label>
                        <input type="tel" name="update_store_owner_phone" required>
                    </div>

                </div>

                <!-- Diğer Ayarlar -->
                <div class="form-section">
                    <h3>Diğer Ayarlar</h3>
                    <div class="form-group">
                        <label>Başlangıç Kredisi</label>
                        <input type="number" name="update_store_credits" value="1000" required>
                    </div>
                    <div class="form-group">
                        <label>Durum</label>
                        <select name="update_store_statu" required>
                            <option value="active">Aktif</option>
                            <option value="waiting">Beklemede</option>
                            <option value="suspend">Askıda</option>
                            <option value="blocked">Engellenmiş</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                    <button type="button" class="btn btn-outline" onclick="closeModal()">İptal</button>
                </div>
            </form>
        </div>
    </div>
</div>


<style>
    .admin-content {
        padding: 20px;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .content-header h1 {
        font-size: 1.5rem;
        color: var(--dark);
    }

    .content-filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid var(--light);
        border-radius: var(--border-radius);
        font-size: 0.9rem;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
    }

    .content-table {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid var(--light);
    }

    th {
        font-weight: 500;
        color: var(--gray);
        background: var(--light);
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-badge.active {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status-badge.inactive {
        background: #FFEBEE;
        color: #C62828;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .btn-icon {
        padding: 5px;
        border: none;
        background: none;
        color: var(--gray);
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-icon:hover {
        color: var(--primary);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin-top: 20px;
    }

    .pagination .active {
        background-color: #8e44ad;
        color: white;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: var(--white);
        border-radius: var(--border-radius);
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid var(--light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 1.2rem;
        color: var(--dark);
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: var(--gray);
        cursor: pointer;
        padding: 5px;
        border-radius: var(--border-radius);
        transition: var(--transition);
    }

    .close-modal:hover {
        background: var(--light);
        color: var(--dark);
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: var(--dark);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid var(--light);
        border-radius: var(--border-radius);
        font-size: 0.9rem;
    }

    .form-group textarea {
        height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .form-section {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
    }

    .form-section h3 {
        margin-top: 0;
        margin-bottom: 15px;
        color: #333;
        font-size: 1.1em;
    }

    .location-input-group {
        display: flex;
        gap: 10px;
    }

    .location-input-group input {
        flex: 1;
    }

    #map {
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .selected-location {
        margin: 10px 0;
        padding: 10px;
        background: #f5f5f5;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .content-filters {
            flex-direction: column;
        }

        .search-box {
            width: 100%;
        }

        .filter-buttons {
            width: 100%;
            justify-content: space-between;
        }

        .filter-buttons .btn {
            flex: 1;
        }

        .modal-content {
            margin: 20px;
            max-height: calc(100vh - 40px);
        }
    }
</style>

<script>
    let kullaniciEnlem = null;
    let kullaniciBoylam = null;

    function konumuAl() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                kullaniciEnlem = position.coords.latitude;
                kullaniciBoylam = position.coords.longitude;

                document.getElementById("store_location").value =
                    kullaniciEnlem + "/" + kullaniciBoylam;
            }, function (error) {
                document.getElementById("konum").innerHTML =
                    "Konum alınamadı: " + error.message;
            });
        } else {
            document.getElementById("konum").innerHTML =
                "Tarayıcınız konum almayı desteklemiyor.";
        }
    }



    // Modal kapama işlevi
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function () {
            this.closest('.modal').classList.remove('active');
        });
    });


    // Form gönderme işlemi

    document.getElementById('storeForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        // Logo input'u al
        const logoInput = form.querySelector('input[name="store_logo"]');
        const file = logoInput?.files?.[0];

        // Eğer logo varsa ve image ise
        if (file && file.type.startsWith('image/')) {
            const resizedBlob = await resizeImage(file, 120, 120); // burada boyutları değiştirebilirsin
            formData.delete('logo'); // Orijinal logoyu çıkar
            formData.append('logo', resizedBlob, 'resized_logo.jpg'); // Yeniden boyutlandırılmış halini ekle
        }
        formData.append('_token', '<?= $csrf->getToken() ?>')

        try {
            const response = await fetch('/../../../controller/storeController.php', {
                method: 'POST',
                body: formData
            });

            const text = await response.text();
            let result;

            try {
                result = JSON.parse(text);
            } catch (jsonError) {
                console.error("JSON parse hatası:", jsonError);
                console.error("Sunucudan gelen ham yanıt:", text);
                alert("Sunucudan geçersiz yanıt geldi.");
                return;
            }

            if (response.ok && result.success) {
                alert('Mağaza başarıyla eklendi');
                window.location.reload();
            } else {
                console.warn("API yanıtı:", result);
                alert(result.message || "Bir hata oluştu.");
            }
        } catch (error) {
            console.error("İstek sırasında hata oluştu:", error);
            alert("Sunucuya bağlanılamadı.");
        }
    });


    function resizeImage(file, width = 120, height = 120) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
            };

            img.onload = function () {
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    if (blob) {
                        resolve(blob);
                    } else {
                        reject(new Error("Blob oluşturulamadı"));
                    }
                }, 'image/jpeg', 0.9); // kalite ayarı
            };

            img.onerror = function () {
                reject(new Error("Resim yüklenemedi"));
            };

            reader.readAsDataURL(file);
        });
    }



    // Modal işlemleri
    function openAddStoreModal() {
        document.getElementById('storeModal').classList.add('active');
        document.getElementById('storeForm').reset();
        document.querySelector('.modal-header h2').textContent = 'Yeni Mağaza Ekle';
    }

    function closeModal() {
        document.getElementById('storeModal').classList.remove('active');
    }

    // ESC tuşu ile modalı kapatma
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // Modal dışına tıklayarak kapatma
    document.getElementById('storeModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeModal();
        }
    });
    async function openUpdateStoreModal(storeId) {
        let data = await getStoreData(storeId);
        if (!data.success) {
            alert(data.message);
            return;
        }
        let storeData = data.data;

        // Önce varsa açık diğer modalı kapat
        document.querySelectorAll('.modal.active').forEach(modal => {
            modal.classList.remove('active');
        });

        // Mağaza bilgilerini modal içerisinde güncelle
        const modalContent = document.getElementById('updateStoreModal').querySelector('.modal-body');
        modalContent.querySelector('input[name="update_store_name"]').value = storeData.store_name;
        modalContent.querySelector('input[name="update_store_id"]').value = storeData.id;
        modalContent.querySelector('input[name="update_store_phone"]').value = storeData.store_phone;
        modalContent.querySelector('input[name="update_store_location"]').value = storeData.store_location;
        modalContent.querySelector('input[name="update_store_owner_name"]').value = storeData.store_owner_name;
        modalContent.querySelector('input[name="update_store_owner_mail"]').value = storeData.store_owner_mail;
        modalContent.querySelector('input[name="update_store_owner_phone"]').value = storeData.store_owner_phone;
        modalContent.querySelector('textarea[name="update_store_adress"]').value = storeData.store_adress;
        modalContent.querySelector('input[name="update_store_credits"]').value = storeData.store_credits;
        modalContent.querySelector('select[name="update_store_statu"]').value = storeData.store_statu;
        modalContent.querySelector('input[name="update_store_opening_time"]').value = storeData.store_opening_time;
        modalContent.querySelector('input[name="update_store_closing_time"]').value = storeData.store_closing_time;
        modalContent.querySelector('textarea[name="update_local_adress"]').value = storeData.local_adress;
        modalContent.querySelector('select[name="update_store_category"]').value = storeData.store_category;
        modalContent.querySelector('img[id="update_store_logo_preview"]').src = "<?= Helper::upolads('images/stores_logos/') ?>" + storeData.store_logo;
        modalContent.querySelector('img[id="update_store_main_image_preview"]').src = "<?= Helper::upolads('images/store_images/') ?>" + storeData.store_main_image;

        const modal = document.getElementById('updateStoreModal');
        modal.classList.add('active');
    }

    // Güncelleme formunu gönderme işlemi
    document.getElementById('updateStoreForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);
        formData.append('action', 'update');

        // Logo ve ana görsel için resize işlemi
        const logoInput = form.querySelector('input[name="update_store_logo"]');
        const mainImageInput = form.querySelector('input[name="update_store_main_image"]');

        // Logo resize
        if (logoInput?.files?.[0]) {
            const resizedLogo = await resizeImage(logoInput.files[0], 120, 120);
            formData.delete('update_store_logo');
            formData.append('update_store_logo', resizedLogo, 'resized_logo.jpg');
        }

        // Ana görsel resize
        if (mainImageInput?.files?.[0]) {
            const resizedMainImage = await resizeImage(mainImageInput.files[0], 800, 600);
            formData.delete('update_store_main_image');
            formData.append('update_store_main_image', resizedMainImage, 'resized_main_image.jpg');
        }

 

        try {
            const response = await fetch('<?= Helper::controller('storeController') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            console.log(result);
            if (result.success) {
                alert('Mağaza başarıyla güncellendi');
                window.location.reload();
            } else {
                alert(result.message || 'Güncelleme sırasında bir hata oluştu');
            }
        } catch (error) {
            console.error(error);
            alert('Sunucu ile iletişim sırasında bir hata oluştu');
        }
    });

    // Mağaza düzenleme
    async function getStoreData(id) {
        const formData = new FormData();
        formData.append('_token', '<?= $csrf->getToken() ?>');
        formData.append('action', 'getData');
        formData.append('store_id', id);

        let response = await fetch('/../../../controller/storeController.php', {
            method: 'POST',
            body: formData
        });

        let result = await response.json();
        return result;
    }


    // Mağaza silme
    async function deleteStore(id) {
        if (confirm('Bu mağazayı silmek istediğinizden emin misiniz?')) {
            const formData = new FormData();
            formData.append('store_id', id);
            formData.append('_token', '<?= $csrf->getToken() ?>');
            formData.append('action', 'delete');

            try {
                const response = await fetch('/../../../controller/storeController.php', {
                    method: 'POST',
                    body: formData
                });

                const text = await response.text();
                let result;

                try {
                    result = JSON.parse(text);
                } catch (jsonError) {
                    console.error("JSON parse hatası:", jsonError);
                    console.error("Sunucudan gelen ham yanıt:", text);
                    alert("Sunucudan geçersiz yanıt geldi.");
                    return;
                }

                if (response.ok && result.success) {
                    alert('Mağaza başarıyla silindi');
                    window.location.reload();
                    // Silinen mağazayı DOM'dan kaldırmak istersen burada yap
                } else {
                    console.warn("API yanıtı:", result);
                    alert(result.message || "Bir hata oluştu.");
                }
            } catch (error) {
                console.error("İstek sırasında hata oluştu:", error);
                alert("Sunucuya bağlanılamadı.");
            }
        }
    }




</script>



<?php
require_once __DIR__ . '/../includes/footer.php';
?>