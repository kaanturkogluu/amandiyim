<?php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Kampanyalar</h1>
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Kampanya ara...">
        </div>
        <div class="filter-dropdown">
            <button class="btn btn-outline">
                <i class="fas fa-filter"></i>
                Filtrele
            </button>
            <div class="dropdown-menu">
                <div class="filter-group">
                    <h4>Kategori</h4>
                    <label class="checkbox">
                        <input type="checkbox" checked> Moda
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" checked> Spor
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" checked> Elektronik
                    </label>
                </div>
                <div class="filter-group">
                    <h4>İndirim Oranı</h4>
                    <label class="checkbox">
                        <input type="checkbox"> %50 ve üzeri
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> %30 - %49
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> %20 ve altı
                    </label>
                </div>
                <div class="filter-group">
                    <h4>Durum</h4>
                    <label class="checkbox">
                        <input type="checkbox" checked> Aktif
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> Yakında
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> Sona Eren
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kampanyalar Grid -->
<div class="campaigns-grid">
    <!-- Kampanya 1 -->
    <div class="campaign-card">
        <div class="campaign-image">
            <img src="../assets/images/campaign1.jpg" alt="Kampanya">
            <div class="campaign-badge">%50</div>
        </div>
        <div class="campaign-content">
            <div class="campaign-store">
                <img src="../assets/images/store1.jpg" alt="Mağaza" class="store-avatar">
                <span>Moda Mağazası</span>
            </div>
            <h3>Yaz İndirimi</h3>
            <p class="campaign-desc">Tüm yaz ürünlerinde %50'ye varan indirimler!</p>
            <div class="campaign-meta">
                <span><i class="fas fa-clock"></i> 3 gün kaldı</span>
                <span><i class="fas fa-map-marker-alt"></i> 2.5 km</span>
            </div>
            <div class="campaign-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-heart"></i>
                    Favorilere Ekle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-share"></i>
                    Paylaş
                </button>
            </div>
        </div>
    </div>

    <!-- Kampanya 2 -->
    <div class="campaign-card">
        <div class="campaign-image">
            <img src="../assets/images/campaign2.jpg" alt="Kampanya">
            <div class="campaign-badge">%30</div>
        </div>
        <div class="campaign-content">
            <div class="campaign-store">
                <img src="../assets/images/store2.jpg" alt="Mağaza" class="store-avatar">
                <span>Spor Mağazası</span>
            </div>
            <h3>Spor Ayakkabı İndirimi</h3>
            <p class="campaign-desc">Seçili spor ayakkabılarda %30 indirim fırsatı!</p>
            <div class="campaign-meta">
                <span><i class="fas fa-clock"></i> 5 gün kaldı</span>
                <span><i class="fas fa-map-marker-alt"></i> 1.8 km</span>
            </div>
            <div class="campaign-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-heart"></i>
                    Favorilere Ekle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-share"></i>
                    Paylaş
                </button>
            </div>
        </div>
    </div>

    <!-- Kampanya 3 -->
    <div class="campaign-card">
        <div class="campaign-image">
            <img src="../assets/images/campaign3.jpg" alt="Kampanya">
            <div class="campaign-badge">%40</div>
        </div>
        <div class="campaign-content">
            <div class="campaign-store">
                <img src="../assets/images/store3.jpg" alt="Mağaza" class="store-avatar">
                <span>Elektronik Mağazası</span>
            </div>
            <h3>Elektronik İndirimi</h3>
            <p class="campaign-desc">Seçili elektronik ürünlerde %40 indirim!</p>
            <div class="campaign-meta">
                <span><i class="fas fa-clock"></i> 7 gün kaldı</span>
                <span><i class="fas fa-map-marker-alt"></i> 3.2 km</span>
            </div>
            <div class="campaign-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-heart"></i>
                    Favorilere Ekle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-share"></i>
                    Paylaş
                </button>
            </div>
        </div>
    </div>

    <!-- Kampanya 4 -->
    <div class="campaign-card">
        <div class="campaign-image">
            <img src="../assets/images/campaign4.jpg" alt="Kampanya">
            <div class="campaign-badge">%25</div>
        </div>
        <div class="campaign-content">
            <div class="campaign-store">
                <img src="../assets/images/store4.jpg" alt="Mağaza" class="store-avatar">
                <span>Kitap Mağazası</span>
            </div>
            <h3>Kitap İndirimi</h3>
            <p class="campaign-desc">Tüm kitaplarda %25 indirim fırsatı!</p>
            <div class="campaign-meta">
                <span><i class="fas fa-clock"></i> 10 gün kaldı</span>
                <span><i class="fas fa-map-marker-alt"></i> 4.5 km</span>
            </div>
            <div class="campaign-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-heart"></i>
                    Favorilere Ekle
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-share"></i>
                    Paylaş
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Sayfalama -->
<div class="pagination">
    <button class="btn btn-outline" disabled>
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="btn btn-primary">1</button>
    <button class="btn btn-outline">2</button>
    <button class="btn btn-outline">3</button>
    <button class="btn btn-outline">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>