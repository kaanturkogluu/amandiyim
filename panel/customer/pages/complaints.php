<?php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Şikayetlerim</h1>
    <div class="header-actions">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newComplaintModal">
            <i class="fas fa-plus"></i>
            Yeni Şikayet
        </button>
    </div>
</div>

<!-- Şikayet Listesi -->
<div class="complaints-list">
    <!-- Şikayet 1 -->
    <div class="complaint-card">
        <div class="complaint-header">
            <div class="complaint-info">
                <h3>Kampanya İçeriği Yanlış</h3>
                <span class="complaint-date">
                    <i class="fas fa-calendar"></i>
                    15.03.2024
                </span>
            </div>
            <div class="complaint-status pending">
                <i class="fas fa-clock"></i>
                Beklemede
            </div>
        </div>
        <div class="complaint-content">
            <div class="complaint-store">
                <img src="../assets/images/store1.jpg" alt="Mağaza" class="store-logo">
                <span>Moda Mağazası</span>
            </div>
            <p class="complaint-text">
                Kampanya detaylarında belirtilen indirim oranı mağazada uygulanmıyor. 
                Web sitesinde %50 indirim yazıyor ancak mağazada %30 indirim uygulanıyor.
            </p>
            <div class="complaint-meta">
                <span><i class="fas fa-tags"></i> Kampanya: Yaz Sezonu İndirimi</span>
                <span><i class="fas fa-map-marker-alt"></i> Şube: Atatürk Caddesi</span>
            </div>
            <div class="complaint-actions">
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-trash"></i>
                    Sil
                </button>
            </div>
        </div>
    </div>

    <!-- Şikayet 2 -->
    <div class="complaint-card">
        <div class="complaint-header">
            <div class="complaint-info">
                <h3>Mağaza Hizmeti Yetersiz</h3>
                <span class="complaint-date">
                    <i class="fas fa-calendar"></i>
                    10.03.2024
                </span>
            </div>
            <div class="complaint-status in-progress">
                <i class="fas fa-spinner"></i>
                İşleme Alındı
            </div>
        </div>
        <div class="complaint-content">
            <div class="complaint-store">
                <img src="../assets/images/store2.jpg" alt="Mağaza" class="store-logo">
                <span>Spor Mağazası</span>
            </div>
            <p class="complaint-text">
                Mağaza personeli müşteri hizmetleri konusunda yetersiz. 
                Ürün bilgisi sorulduğunda yeterli bilgi verilmiyor ve ilgisiz davranılıyor.
            </p>
            <div class="complaint-meta">
                <span><i class="fas fa-store"></i> Şube: İstiklal Caddesi</span>
                <span><i class="fas fa-clock"></i> Ziyaret: 10.03.2024 14:30</span>
            </div>
            <div class="complaint-actions">
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-trash"></i>
                    Sil
                </button>
            </div>
        </div>
    </div>

    <!-- Şikayet 3 -->
    <div class="complaint-card">
        <div class="complaint-header">
            <div class="complaint-info">
                <h3>Ürün Kalitesi Sorunu</h3>
                <span class="complaint-date">
                    <i class="fas fa-calendar"></i>
                    05.03.2024
                </span>
            </div>
            <div class="complaint-status resolved">
                <i class="fas fa-check-circle"></i>
                Çözüldü
            </div>
        </div>
        <div class="complaint-content">
            <div class="complaint-store">
                <img src="../assets/images/store3.jpg" alt="Mağaza" class="store-logo">
                <span>Elektronik Mağazası</span>
            </div>
            <p class="complaint-text">
                Satın alınan ürün 2 gün sonra arıza verdi. 
                Garanti kapsamında olmasına rağmen değişim işlemi uzun sürdü.
            </p>
            <div class="complaint-meta">
                <span><i class="fas fa-box"></i> Ürün: Akıllı Telefon</span>
                <span><i class="fas fa-receipt"></i> Fatura No: #12345</span>
            </div>
            <div class="complaint-actions">
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-edit"></i>
                    Düzenle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-trash"></i>
                    Sil
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Yeni Şikayet Modal -->
<div class="modal fade" id="newComplaintModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Yeni Şikayet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Şikayet Türü</label>
                        <select class="form-control">
                            <option value="">Seçiniz</option>
                            <option value="campaign">Kampanya</option>
                            <option value="service">Hizmet</option>
                            <option value="product">Ürün</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mağaza</label>
                        <select class="form-control">
                            <option value="">Seçiniz</option>
                            <option value="1">Moda Mağazası</option>
                            <option value="2">Spor Mağazası</option>
                            <option value="3">Elektronik Mağazası</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Başlık</label>
                        <input type="text" class="form-control" placeholder="Şikayet başlığı">
                    </div>
                    <div class="form-group">
                        <label>Açıklama</label>
                        <textarea class="form-control" rows="4" placeholder="Şikayetinizi detaylı bir şekilde açıklayınız"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Dosya Ekle</label>
                        <input type="file" class="form-control" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">İptal</button>
                <button type="button" class="btn btn-primary">Gönder</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>