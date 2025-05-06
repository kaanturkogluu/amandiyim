<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="store-content">
    <div class="content-header">
        <h1>Ayarlar</h1>
        <button class="btn btn-primary" onclick="saveSettings()">
            <i class="fas fa-save"></i> Değişiklikleri Kaydet
        </button>
    </div>

    <!-- Ayarlar Grid -->
    <div class="settings-grid">
        <!-- Mağaza Bilgileri -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h3>Mağaza Bilgileri</h3>
                <button class="btn-icon" onclick="toggleCard('store-info')">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="settings-card-body" id="store-info">
                <div class="form-group">
                    <label>Mağaza Adı</label>
                    <input type="text" name="store_name" value="Test Mağaza">
                </div>
                <div class="form-group">
                    <label>E-posta</label>
                    <input type="email" name="store_email" value="store@example.com">
                </div>
                <div class="form-group">
                    <label>Telefon</label>
                    <input type="tel" name="store_phone" value="0555 123 4567">
                </div>
                <div class="form-group">
                    <label>Adres</label>
                    <textarea name="store_address" rows="3">Örnek Mahallesi, Örnek Sokak No:1</textarea>
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <div class="file-upload">
                        <input type="file" name="store_logo" accept="image/*">
                        <div class="file-preview">
                            <img src="assets/images/store-logo.png" alt="Store Logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kredi Ayarları -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h3>Kredi Ayarları</h3>
                <button class="btn-icon" onclick="toggleCard('credit-settings')">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="settings-card-body" id="credit-settings">
                <div class="form-group">
                    <label>Kredi Bildirim Limiti</label>
                    <input type="number" name="credit_notification_limit" value="500">
                    <small class="form-text">Kredi miktarı bu değerin altına düştüğünde bildirim alırsınız</small>
                </div>
                <div class="form-group">
                    <label>Kredi Bildirim E-posta</label>
                    <input type="email" name="credit_notification_email" value="store@example.com">
                    <small class="form-text">Kredi bildirimlerinin gönderileceği e-posta adresi</small>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="credit_notifications" checked>
                        Kredi bildirimlerini aktif et
                    </label>
                </div>
            </div>
        </div>

        <!-- Kampanya Ayarları -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h3>Kampanya Ayarları</h3>
                <button class="btn-icon" onclick="toggleCard('campaign-settings')">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="settings-card-body" id="campaign-settings">
                <div class="form-group">
                    <label>Maksimum İndirim Oranı (%)</label>
                    <input type="number" name="max_discount_rate" value="50">
                    <small class="form-text">Kampanyalarda kullanabileceğiniz maksimum indirim oranı</small>
                </div>
                <div class="form-group">
                    <label>Minimum Kampanya Süresi (Gün)</label>
                    <input type="number" name="min_campaign_duration" value="7">
                    <small class="form-text">Kampanyalar için minimum süre</small>
                </div>
                <div class="form-group">
                    <label>Maksimum Kampanya Süresi (Gün)</label>
                    <input type="number" name="max_campaign_duration" value="90">
                    <small class="form-text">Kampanyalar için maksimum süre</small>
                </div>
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="auto_pause_campaign" checked>
                        Kredi yetersiz olduğunda kampanyaları otomatik durdur
                    </label>
                </div>
            </div>
        </div>

        <!-- Güvenlik Ayarları -->
        <div class="settings-card">
            <div class="settings-card-header">
                <h3>Güvenlik Ayarları</h3>
                <button class="btn-icon" onclick="toggleCard('security')">
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
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="two_factor_auth">
                        İki Faktörlü Doğrulama
                    </label>
                </div>
                <div class="form-group">
                    <label>Oturum Süresi (Dakika)</label>
                    <input type="number" name="session_timeout" value="30">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

// Dosya Yükleme Önizleme
document.querySelector('input[type="file"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.file-preview img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Ayarları Kaydet
function saveSettings() {
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
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 