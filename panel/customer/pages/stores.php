<?php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Mağazalar</h1>
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Mağaza ara...">
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
                    <h4>Mesafe</h4>
                    <label class="checkbox">
                        <input type="checkbox"> 1 km içinde
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> 5 km içinde
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> 10 km içinde
                    </label>
                </div>
                <div class="filter-group">
                    <h4>Durum</h4>
                    <label class="checkbox">
                        <input type="checkbox" checked> Açık
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> Kapalı
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mağazalar Grid -->
<div class="stores-grid">
    <!-- Mağaza 1 -->
    <div class="store-card">
        <div class="store-image">
            <img src="../assets/images/store1.jpg" alt="Mağaza">
            <div class="store-status open">
                <i class="fas fa-clock"></i>
                Açık
            </div>
        </div>
        <div class="store-content">
            <div class="store-header">
                <div class="store-info">
                    <h3>Moda Mağazası</h3>
                    <div class="store-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span>(4.5)</span>
                    </div>
                </div>
                <button class="btn btn-icon">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            <p class="store-address">
                <i class="fas fa-map-marker-alt"></i>
                Atatürk Caddesi No:123
            </p>
            <div class="store-meta">
                <span><i class="fas fa-clock"></i> 09:00 - 22:00</span>
                <span><i class="fas fa-phone"></i> 0212 345 67 89</span>
            </div>
            <div class="store-stats">
                <div class="stat">
                    <i class="fas fa-tags"></i>
                    <span>12 Aktif Kampanya</span>
                </div>
                <div class="stat">
                    <i class="fas fa-users"></i>
                    <span>1.2K Takipçi</span>
                </div>
                <div class="stat">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>2.5 km</span>
                </div>
            </div>
            <div class="store-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-store"></i>
                    Mağazayı Ziyaret Et
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-directions"></i>
                    Yol Tarifi
                </button>
            </div>
        </div>
    </div>

    <!-- Mağaza 2 -->
    <div class="store-card">
        <div class="store-image">
            <img src="../assets/images/store2.jpg" alt="Mağaza">
            <div class="store-status open">
                <i class="fas fa-clock"></i>
                Açık
            </div>
        </div>
        <div class="store-content">
            <div class="store-header">
                <div class="store-info">
                    <h3>Spor Mağazası</h3>
                    <div class="store-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span>(5.0)</span>
                    </div>
                </div>
                <button class="btn btn-icon">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            <p class="store-address">
                <i class="fas fa-map-marker-alt"></i>
                İstiklal Caddesi No:456
            </p>
            <div class="store-meta">
                <span><i class="fas fa-clock"></i> 10:00 - 21:00</span>
                <span><i class="fas fa-phone"></i> 0212 987 65 43</span>
            </div>
            <div class="store-stats">
                <div class="stat">
                    <i class="fas fa-tags"></i>
                    <span>8 Aktif Kampanya</span>
                </div>
                <div class="stat">
                    <i class="fas fa-users"></i>
                    <span>856 Takipçi</span>
                </div>
                <div class="stat">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>1.8 km</span>
                </div>
            </div>
            <div class="store-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-store"></i>
                    Mağazayı Ziyaret Et
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-directions"></i>
                    Yol Tarifi
                </button>
            </div>
        </div>
    </div>

    <!-- Mağaza 3 -->
    <div class="store-card">
        <div class="store-image">
            <img src="../assets/images/store3.jpg" alt="Mağaza">
            <div class="store-status closed">
                <i class="fas fa-clock"></i>
                Kapalı
            </div>
        </div>
        <div class="store-content">
            <div class="store-header">
                <div class="store-info">
                    <h3>Elektronik Mağazası</h3>
                    <div class="store-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span>(5.0)</span>
                    </div>
                </div>
                <button class="btn btn-icon">
                    <i class="fas fa-heart"></i>
                </button>
            </div>
            <p class="store-address">
                <i class="fas fa-map-marker-alt"></i>
                Cumhuriyet Caddesi No:789
            </p>
            <div class="store-meta">
                <span><i class="fas fa-clock"></i> 09:00 - 20:00</span>
                <span><i class="fas fa-phone"></i> 0212 123 45 67</span>
            </div>
            <div class="store-stats">
                <div class="stat">
                    <i class="fas fa-tags"></i>
                    <span>6 Aktif Kampanya</span>
                </div>
                <div class="stat">
                    <i class="fas fa-users"></i>
                    <span>2.3K Takipçi</span>
                </div>
                <div class="stat">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>3.2 km</span>
                </div>
            </div>
            <div class="store-actions">
                <button class="btn btn-primary btn-sm">
                    <i class="fas fa-store"></i>
                    Mağazayı Ziyaret Et
                </button>
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-directions"></i>
                    Yol Tarifi
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