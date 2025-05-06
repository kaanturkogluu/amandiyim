<?php
require_once __DIR__.'/../includes/header.php';
?>

<div class="customer-content">
    <div class="content-header">
        <h1>Profili Düzenle</h1>
        <a href="profile.php" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Geri Dön
        </a>
    </div>

    <div class="edit-profile-grid">
        <!-- Sol Kolon -->
        <div class="edit-profile-left">
            <!-- Profil Fotoğrafı -->
            <div class="card">
                <div class="card-header">
                    <h3>Profil Fotoğrafı</h3>
                </div>
                <div class="card-body">
                    <div class="profile-photo-upload">
                        <div class="current-photo">
                            <img src="../assets/images/avatar.jpg" alt="Profil Fotoğrafı">
                        </div>
                        <div class="upload-actions">
                            <button class="btn btn-outline">
                                <i class="fas fa-camera"></i>
                                Fotoğraf Değiştir
                            </button>
                            <button class="btn btn-outline btn-danger">
                                <i class="fas fa-trash"></i>
                                Fotoğrafı Kaldır
                            </button>
                        </div>
                        <div class="upload-info">
                            <p>Önerilen boyut: 400x400 piksel</p>
                            <p>Maksimum dosya boyutu: 2MB</p>
                            <p>İzin verilen formatlar: JPG, PNG</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hesap Bilgileri -->
            <div class="card">
                <div class="card-header">
                    <h3>Hesap Bilgileri</h3>
                </div>
                <div class="card-body">
                    <form class="form">
                        <div class="form-group">
                            <label for="name">Ad Soyad</label>
                            <input type="text" id="name" class="form-control" value="Ahmet Yılmaz">
                        </div>
                        <div class="form-group">
                            <label for="email">E-posta</label>
                            <input type="email" id="email" class="form-control" value="ahmet.yilmaz@email.com">
                        </div>
                        <div class="form-group">
                            <label for="phone">Telefon Numarası</label>
                            <input type="tel" id="phone" class="form-control" value="+90 555 123 4567">
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Doğum Tarihi</label>
                            <input type="date" id="birthdate" class="form-control" value="1990-01-01">
                        </div>
                        <div class="form-group">
                            <label for="gender">Cinsiyet</label>
                            <select id="gender" class="form-control">
                                <option value="">Seçiniz</option>
                                <option value="male" selected>Erkek</option>
                                <option value="female">Kadın</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">Şehir</label>
                            <select id="city" class="form-control">
                                <option value="">Seçiniz</option>
                                <option value="istanbul" selected>İstanbul</option>
                                <option value="ankara">Ankara</option>
                                <option value="izmir">İzmir</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="district">İlçe</label>
                            <select id="district" class="form-control">
                                <option value="">Seçiniz</option>
                                <option value="kadikoy" selected>Kadıköy</option>
                                <option value="besiktas">Beşiktaş</option>
                                <option value="sisli">Şişli</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Adres</label>
                            <textarea id="address" class="form-control" rows="3">Atatürk Caddesi No:123 Kadıköy/İstanbul</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sağ Kolon -->
        <div class="edit-profile-right">
            <!-- Şifre Değiştirme -->
            <div class="card">
                <div class="card-header">
                    <h3>Şifre Değiştir</h3>
                </div>
                <div class="card-body">
                    <form class="form">
                        <div class="form-group">
                            <label for="current-password">Mevcut Şifre</label>
                            <input type="password" id="current-password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="new-password">Yeni Şifre</label>
                            <input type="password" id="new-password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Yeni Şifre (Tekrar)</label>
                            <input type="password" id="confirm-password" class="form-control">
                        </div>
                        <div class="password-requirements">
                            <p>Şifre gereksinimleri:</p>
                            <ul>
                                <li>En az 8 karakter uzunluğunda olmalı</li>
                                <li>En az bir büyük harf içermeli</li>
                                <li>En az bir küçük harf içermeli</li>
                                <li>En az bir rakam içermeli</li>
                                <li>En az bir özel karakter içermeli</li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bildirim Tercihleri -->
            <div class="card">
                <div class="card-header">
                    <h3>Bildirim Tercihleri</h3>
                </div>
                <div class="card-body">
                    <div class="notification-preferences">
                        <div class="preference-item">
                            <div class="preference-info">
                                <h4>E-posta Bildirimleri</h4>
                                <p>Yeni kampanya ve güncellemeler hakkında e-posta al</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                        <div class="preference-item">
                            <div class="preference-info">
                                <h4>SMS Bildirimleri</h4>
                                <p>Önemli kampanya ve güncellemeler hakkında SMS al</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox">
                            </div>
                        </div>
                        <div class="preference-item">
                            <div class="preference-info">
                                <h4>Push Bildirimleri</h4>
                                <p>Anlık kampanya ve güncellemeler hakkında bildirim al</p>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" checked>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kaydet Butonu -->
            <div class="save-actions">
                <button class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Değişiklikleri Kaydet
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Content Header */
.content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.content-header h1 {
    font-size: 1.8rem;
    color: var(--gray-800);
}

/* Edit Profile Grid */
.edit-profile-grid {
    display: grid;
    grid-template-columns: 400px 1fr;
    gap: 30px;
}

/* Profile Photo Upload */
.profile-photo-upload {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
}

.current-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--primary);
}

.current-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.upload-actions {
    display: flex;
    gap: 10px;
}

.upload-info {
    text-align: center;
    color: var(--gray-600);
    font-size: 0.9rem;
}

.upload-info p {
    margin: 5px 0;
}

/* Form */
.form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.form-group label {
    font-weight: 500;
    color: var(--gray-700);
}

.form-control {
    padding: 8px 12px;
    border: 1px solid var(--gray-300);
    border-radius: 5px;
    font-size: 1rem;
}

.form-control:focus {
    border-color: var(--primary);
    outline: none;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
}

/* Password Requirements */
.password-requirements {
    margin-top: 15px;
    padding: 15px;
    background: var(--gray-50);
    border-radius: 5px;
}

.password-requirements p {
    font-weight: 500;
    margin-bottom: 10px;
}

.password-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.password-requirements li {
    font-size: 0.9rem;
    color: var(--gray-600);
    display: flex;
    align-items: center;
    gap: 5px;
}

.password-requirements li::before {
    content: "•";
    color: var(--primary);
}

/* Notification Preferences */
.notification-preferences {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.preference-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: var(--gray-50);
    border-radius: 8px;
}

.preference-info h4 {
    font-size: 1rem;
    margin-bottom: 3px;
}

.preference-info p {
    font-size: 0.9rem;
    color: var(--gray-600);
}

/* Save Actions */
.save-actions {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

/* Responsive */
@media (max-width: 992px) {
    .edit-profile-grid {
        grid-template-columns: 1fr;
    }

    .edit-profile-left {
        max-width: 500px;
        margin: 0 auto;
    }
}

@media (max-width: 768px) {
    .content-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }

    .upload-actions {
        flex-direction: column;
        width: 100%;
    }

    .preference-item {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .save-actions {
        justify-content: center;
    }
}
</style>

<?php
require_once 'includes/footer.php';
?> 