<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Stores.php';

$stores = new Stores();

$storeid = (int) $session->getUserId();

$m = $stores->find($storeid);


 ;

?>

<div class="store-content"> <?php if ($session->getFlash('success')): ?>
        <div class="alert alert-success"><?= $session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if ($session->getFlash('error')): ?>
        <div class="alert alert-danger"><?= $session->getFlash('error') ?></div>
    <?php endif; ?>
    <div class="content-header">
        <h1>Ayarlar</h1>

    </div>

    <!-- Ayarlar Grid -->
    <div class="settings-grid">


        <!-- Mağaza Bilgileri -->
        <form id="store-info-form" enctype="multipart/form-data" method="post"
            action="<?= Helper::controller('storeSettingsController') ?>">
            <div class="settings-card">

                <input type="hidden" name="update_store_id" value="<?= $session->getUserId() ?>">
                <input type="hidden" name="action" value="update">
                <div class="settings-card-header">
                    <h3>Mağaza Bilgileri  - Bilgi Değişiklikleri Haftada 1 Kez Yapılabilir</h3>
                    <button class="btn-icon" onclick="toggleCard('store-info')" type="button">
                        <i class="fas fa-chevron-down"></i>
                    </button> <?php
                    echo $csrf->getTokenField();
                    ?>
                </div>
                <div class="settings-card-body" id="store-info">
                    <div class="form-group">
                        <label>Mağaza Adı</label>
                        <input type="text" name="update_store_name" value="<?= $m['store_name'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Konum (Enlem, Boylam)</label>
                        <div class="location-input-group">
                            <input type="text" name="update_store_location" id="update_store_location" readonly
                                placeholder="Haritadan seçin veya koordinat girin" required
                                value="<?= $m['store_location'] ?>">
                            <button onclick="konumuAl()" type="button" class="btn btn-outline">
                                <i class="fas fa-map-marker-alt"></i> Konum Al
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="tel" name="update_store_phone" value="<?= $m['store_phone'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Adres (Genel Adres Bilgisi)</label>
                        <textarea name="update_store_adress" rows="3"><?= $m['store_adress'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Açık Adres</label>
                        <textarea name="update_local_adress" rows="3"><?= $m['local_adress'] ?></textarea>
                    </div>

                    <div class="form-group time-group">
                        <label for="opening_time">Açılış Saati</label>
                        <input type="time" name="update_store_opening_time" id="opening_time"
                            value="<?= $m['store_opening_time'] ?>">
                        <label for="closing_time">Kapanış Saati</label>
                        <input type="time" name="update_store_closing_time" id="closing_time"
                            value="<?= $m['store_closing_time'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Logo</label>
                        <div class="file-upload">
                            <input type="file" name="update_store_logo" accept="image/*">
                            <div class="file-preview">
                                <img class="logo-preview"
                                    src="<?= Helper::upolads('images/stores_logos/') . $m['store_logo'] ?>"
                                    alt="Store Logo"  onerror="this.onerror=null;this.src='<?= Helper::upolads('images/stores_logos/store-default-icon.jpg') ?>';">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mağaza Ana Görseli</label>
                        <div class="file-upload">
                            <input type="file" name="update_store_main_image" accept="image/*">
                            <div class="file-preview">
                                <img class="main-image-preview"
                                    src="<?= Helper::upolads('images/store_images/') . $m['store_main_image'] ?>"
                                    alt="Store Main Image"
                                    onerror="this.onerror=null;this.src='<?= Helper::upolads('images/store_images/store-default-image.jpg') ?>';">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </div>
        </form>



        <!-- Güvenlik Ayarları -->

     
     
        <form id="security-form" action="<?= Helper::controller('storeSettingsController') ?>" method="post">
            <input type="hidden" value="<?= $session->getUserId() ?>" name="store_id">
            <?=
                $csrf->getTokenField() ?>
            <input type="hidden" name="action" value="security">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3>Güvenlik Ayarları</h3>
                    <button class="btn-icon" onclick="toggleCard('security')" type="button">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="settings-card-body" id="security">
                    <div class="form-group">
                        <label>Mevcut Şifre</label>
                        <input type="password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre</label>
                        <input type="password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre (Tekrar)</label>
                        <input type="password" name="new_password_confirm">
                    </div>
                    <!-- <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="two_factor_auth">
                            İki Faktörlü Doğrulama
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Oturum Süresi (Dakika)</label>
                        <input type="number" name="session_timeout" value="30">
                    </div> -->
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Kart Açma/Kapama
        function toggleCard(cardId) {
            const card = document.getElementById(cardId);
            const icon = event.target;

            if (card.style.display === 'none' || !card.style.display) {
                card.style.display = 'block';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                card.style.display = 'none';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        // Logo önizleme
        var logoInput = document.querySelector('input[name="store_logo"]');
        if (logoInput) {
            logoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.querySelector('.logo-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Ana görsel önizleme
        var mainImageInput = document.querySelector('input[name="store_main_image"]');
        if (mainImageInput) {
            mainImageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.querySelector('.main-image-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        // Ayarları Kaydet
        function checkLastUpdate() {
            // Form verilerini topla
            const formData = new FormData();
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.type === 'checkbox') {
                    formData.append(input.name, input.checked);
                } else {
                    formData.append(input.name, input.value);
                }
            });

            // API'ye gönder
            console.log('Ayarlar kaydediliyor...', Object.fromEntries(formData));

            // Başarılı mesajı göster
            alert('Ayarlar başarıyla kaydedildi!');
        }

        // Mağaza Bilgileri formu submit kontrolü
        var storeInfoForm = document.getElementById('store-info-form');
        if (storeInfoForm) {
            storeInfoForm.addEventListener('submit', async function (e) {
                e.preventDefault();
                // API'ye fetch ile son güncelleme tarihini sor
                try {
                    const response = await fetch('<?= Helper::baseUrl() . '/api/checkuserUpdateTime.php?_token=' . $csrf->getToken() ?>', { method: 'GET' });
                    const data = await response.json();
                    if (data && data.canUpdate) {
                        console.log(data);
                        storeInfoForm.submit();
                    } else {
                        alert('Mağaza Bilgileri Değişikliği İçin Son Değişikliğin Üzerinden 1 Hafta Beklemek Zorundasınız');
                    }
                } catch (err) {
                    alert('Sunucuya ulaşılamadı. Lütfen tekrar deneyin.');
                }
            });
        }

        var securityForm = document.getElementById('security-form');
        if (securityForm) {
            securityForm.addEventListener('submit', function (e) {
                var currentPassword = securityForm.querySelector('input[name="current_password"]').value.trim();
                var newPassword = securityForm.querySelector('input[name="new_password"]').value.trim();
                var newPasswordConfirm = securityForm.querySelector('input[name="new_password_confirm"]').value.trim();

                // Kontroller
                if (!currentPassword) {
                    alert('Mevcut şifreyi giriniz.');
                    e.preventDefault();
                    return false;
                }
                if (newPassword.length < 6) {
                    alert('Yeni şifre en az 6 karakter olmalı.');
                    e.preventDefault();
                    return false;
                }
                if (newPassword !== newPasswordConfirm) {
                    alert('Yeni şifre ve tekrar şifresi aynı olmalı.');
                    e.preventDefault();
                    return false;
                }
                if (currentPassword === newPassword) {
                    alert('Yeni şifre mevcut şifreyle aynı olamaz.');
                    e.preventDefault();
                    return false;
                }

                // Tüm kontroller geçtiyse form submit edilir (hiçbir şey yapmaya gerek yok)
            });
        }
    });

    let kullaniciEnlem = null;
    let kullaniciBoylam = null;

    function konumuAl() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                kullaniciEnlem = position.coords.latitude;
                kullaniciBoylam = position.coords.longitude;

                document.getElementById("update_store_location").value =
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
</script>


<style>
    .form-text {
        font-size: 0.8rem;
        color: var(--gray);
        margin-top: 5px;
        display: block;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .checkbox-label input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .file-upload {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .file-preview {
        width: 100px;
        height: 100px;
        border-radius: var(--border-radius);
        overflow: hidden;
        border: 1px solid var(--light);
    }

    .file-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .location-input-group {
        display: flex;
        gap: 10px;
    }

    .location-input-group input {
        flex: 1;
    }

    .form-group.time-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-group.time-group label {
        margin-bottom: 0;
        white-space: nowrap;
    }

    .form-group.time-group input[type="time"] {
        width: 120px;
    }

    @media (max-width: 600px) {
        .form-group.time-group {
            flex-direction: column;
            align-items: stretch;
            gap: 6px;
        }

        .form-group.time-group label {
            margin-bottom: 0;
        }

        .form-group.time-group input {
            width: 100%;
            min-width: 0;
        }

        .location-input-group {
            flex-direction: column;
            gap: 6px;
            align-items: stretch;
        }

        .location-input-group input,
        .location-input-group button {
            width: 100%;
            min-width: 0;
        }
    }

    input,
    textarea,
    select,
    button {
        pointer-events: auto !important;
        z-index: 1;
    }
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>