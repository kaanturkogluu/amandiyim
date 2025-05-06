<?php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Profilim</h1>
    <div class="header-actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <i class="fas fa-edit"></i>
            Profili Düzenle
        </button>
    </div>
</div>

<!-- Profil Bilgileri -->
<div class="profile-section">
    <div class="profile-header">
        <div class="profile-avatar">
            <img src="../assets/images/avatar.jpg" alt="Profil">
            <button class="btn btn-icon btn-circle">
                <i class="fas fa-camera"></i>
            </button>
        </div>
        <div class="profile-info">
            <h2>Ahmet Yılmaz</h2>
            <p class="text-muted">ahmet.yilmaz@email.com</p>
        </div>
    </div>

    <div class="profile-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h3>24</h3>
                <p>Favori Kampanya</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <h3>12</h3>
                <p>Takip Edilen Mağaza</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-comment"></i>
            </div>
            <div class="stat-info">
                <h3>8</h3>
                <p>Yorum</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="stat-info">
                <h3>2</h3>
                <p>Aktif Şikayet</p>
            </div>
        </div>
    </div>

    <div class="profile-details">
        <div class="detail-group">
            <h3>Kişisel Bilgiler</h3>
            <div class="detail-item">
                <span class="detail-label">Ad Soyad</span>
                <span class="detail-value">Ahmet Yılmaz</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">E-posta</span>
                <span class="detail-value">ahmet.yilmaz@email.com</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Telefon</span>
                <span class="detail-value">+90 555 123 45 67</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Doğum Tarihi</span>
                <span class="detail-value">01.01.1990</span>
            </div>
        </div>

        <div class="detail-group">
            <h3>Adres Bilgileri</h3>
            <div class="detail-item">
                <span class="detail-label">Adres</span>
                <span class="detail-value">Atatürk Caddesi No:123 Kadıköy/İstanbul</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">İl</span>
                <span class="detail-value">İstanbul</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">İlçe</span>
                <span class="detail-value">Kadıköy</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Posta Kodu</span>
                <span class="detail-value">34700</span>
            </div>
        </div>

        <div class="detail-group">
            <h3>Hesap Bilgileri</h3>
            <div class="detail-item">
                <span class="detail-label">Üyelik Tarihi</span>
                <span class="detail-value">01.01.2024</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Son Giriş</span>
                <span class="detail-value">15.03.2024 14:30</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Hesap Durumu</span>
                <span class="detail-value">
                    <span class="badge badge-success">Aktif</span>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Profil Düzenleme Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profili Düzenle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Profil Fotoğrafı</label>
                        <div class="avatar-upload">
                            <img src="../assets/images/avatar.jpg" alt="Profil" class="preview">
                            <input type="file" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ad Soyad</label>
                        <input type="text" class="form-control" value="Ahmet Yılmaz">
                    </div>
                    <div class="form-group">
                        <label>E-posta</label>
                        <input type="email" class="form-control" value="ahmet.yilmaz@email.com">
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="tel" class="form-control" value="+90 555 123 45 67">
                    </div>
                    <div class="form-group">
                        <label>Doğum Tarihi</label>
                        <input type="date" class="form-control" value="1990-01-01">
                    </div>
                    <div class="form-group">
                        <label>Adres</label>
                        <textarea class="form-control" rows="3">Atatürk Caddesi No:123 Kadıköy/İstanbul</textarea>
                    </div>
                    <div class="form-group">
                        <label>İl</label>
                        <select class="form-control">
                            <option value="34">İstanbul</option>
                            <option value="06">Ankara</option>
                            <option value="35">İzmir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>İlçe</label>
                        <select class="form-control">
                            <option value="1">Kadıköy</option>
                            <option value="2">Beşiktaş</option>
                            <option value="3">Üsküdar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Posta Kodu</label>
                        <input type="text" class="form-control" value="34700">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<!-- Şifre Değiştirme Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Şifre Değiştir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Mevcut Şifre</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Yeni Şifre (Tekrar)</label>
                        <input type="password" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary">Değiştir</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>