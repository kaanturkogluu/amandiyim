<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1>Ayarlar</h1>
        <button class="btn btn-primary" onclick="saveSettings()">
            <i class="fas fa-save"></i> Değişiklikleri Kaydet
        </button>
    </div>

    <div class="settings-grid">
        <!-- Genel Ayarlar -->
        <div class="settings-card">
            <div class="settings-header">
                <h2>Genel Ayarlar</h2>
                <i class="fas fa-cog"></i>
            </div>
            <div class="settings-body">
                <form id="generalSettings">
                    <div class="form-group">
                        <label>Site Başlığı</label>
                        <input type="text" name="site_title" value="Amandiyim">
                    </div>
                    <div class="form-group">
                        <label>Site Açıklaması</label>
                        <textarea name="site_description">Dörtyol'un en iyi kampanya platformu</textarea>
                    </div>
                    <div class="form-group">
                        <label>İletişim E-posta</label>
                        <input type="email" name="contact_email" value="info@amandiyim.com">
                    </div>
                    <div class="form-group">
                        <label>İletişim Telefon</label>
                        <input type="tel" name="contact_phone" value="0555 555 55 55">
                    </div>
                </form>
            </div>
        </div>

        <!-- E-posta Ayarları -->
        <div class="settings-card">
            <div class="settings-header">
                <h2>E-posta Ayarları</h2>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="settings-body">
                <form id="emailSettings">
                    <div class="form-group">
                        <label>SMTP Sunucu</label>
                        <input type="text" name="smtp_host" value="smtp.gmail.com">
                    </div>
                    <div class="form-group">
                        <label>SMTP Port</label>
                        <input type="number" name="smtp_port" value="587">
                    </div>
                    <div class="form-group">
                        <label>SMTP Kullanıcı Adı</label>
                        <input type="text" name="smtp_username" value="your-email@gmail.com">
                    </div>
                    <div class="form-group">
                        <label>SMTP Şifre</label>
                        <input type="password" name="smtp_password" value="********">
                    </div>
                    <div class="form-group">
                        <label>E-posta Gönderim Testi</label>
                        <button type="button" class="btn btn-outline" onclick="testEmail()">
                            Test E-postası Gönder
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bildirim Ayarları -->
        <div class="settings-card">
            <div class="settings-header">
                <h2>Bildirim Ayarları</h2>
                <i class="fas fa-bell"></i>
            </div>
            <div class="settings-body">
                <form id="notificationSettings">
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="new_store_notification" checked>
                            <span>Yeni Mağaza Kaydı Bildirimi</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="new_campaign_notification" checked>
                            <span>Yeni Kampanya Bildirimi</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="campaign_expiry_notification" checked>
                            <span>Kampanya Süresi Dolma Bildirimi</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="user_registration_notification" checked>
                            <span>Yeni Kullanıcı Kaydı Bildirimi</span>
                        </label>
                    </div>
                </form>
            </div>
        </div>

        <!-- Güvenlik Ayarları -->
        <div class="settings-card">
            <div class="settings-header">
                <h2>Güvenlik Ayarları</h2>
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="settings-body">
                <form id="securitySettings">
                    <div class="form-group">
                        <label>Admin Şifresi Değiştir</label>
                        <input type="password" name="current_password" placeholder="Mevcut Şifre">
                        <input type="password" name="new_password" placeholder="Yeni Şifre">
                        <input type="password" name="confirm_password" placeholder="Yeni Şifre (Tekrar)">
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="two_factor_auth" checked>
                            <span>İki Faktörlü Doğrulama</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="login_attempts" checked>
                            <span>Başarısız Giriş Denemesi Limiti</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>Oturum Süresi (Dakika)</label>
                        <input type="number" name="session_timeout" value="30">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Tüm formları birleştir
function saveSettings() {
    const generalSettings = new FormData(document.getElementById('generalSettings'));
    const emailSettings = new FormData(document.getElementById('emailSettings'));
    const notificationSettings = new FormData(document.getElementById('notificationSettings'));
    const securitySettings = new FormData(document.getElementById('securitySettings'));

    // Form verilerini birleştir
    const settings = {
        ...Object.fromEntries(generalSettings),
        ...Object.fromEntries(emailSettings),
        ...Object.fromEntries(notificationSettings),
        ...Object.fromEntries(securitySettings)
    };

    // Ayarları kaydet
    console.log('Kaydedilen ayarlar:', settings);
    alert('Ayarlar başarıyla kaydedildi!');
}

// E-posta testi
function testEmail() {
    alert('Test e-postası gönderiliyor...');
    // E-posta gönderme işlemi
}

// Sayfa yüklendiğinde mevcut ayarları yükle
document.addEventListener('DOMContentLoaded', function() {
    // Mevcut ayarları getir ve formlara doldur
    // Bu kısım backend'den veri çekerek yapılacak
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 