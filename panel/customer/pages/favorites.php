<?php
require_once __DIR__ . '/../includes/header.php';
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Favorilerim</h1>
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Favorilerde ara...">
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
                        <input type="checkbox" checked> Kampanyalar
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" checked> Mağazalar
                    </label>
                </div>
                <div class="filter-group">
                    <h4>Durum</h4>
                    <label class="checkbox">
                        <input type="checkbox" checked> Aktif
                    </label>
                    <label class="checkbox">
                        <input type="checkbox"> Sona Eren
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Favori Kampanyalar -->
<div class="section">
    <div class="section-header">
        <h2>Favori Kampanyalar</h2>
        <div class="section-actions">
            <button class="btn btn-outline btn-sm">
                <i class="fas fa-sort"></i>
                Sırala
            </button>
        </div>
    </div>
    <div class="campaigns-grid">
        <!-- Kampanya 1 -->
        <div class="campaign-card">
            <div class="campaign-image">
                <img src="../assets/images/campaign1.jpg" alt="Kampanya">
                <div class="campaign-badge">%50</div>
            </div>
            <div class="campaign-content">
                <div class="campaign-header">
                    <div class="store-info">
                        <img src="../assets/images/store1.jpg" alt="Mağaza" class="store-logo">
                        <span>Moda Mağazası</span>
                    </div>
                    <button class="btn btn-icon">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <h3>Yaz Sezonu İndirimi</h3>
                <p>Tüm yaz ürünlerinde %50'ye varan indirimler!</p>
                <div class="campaign-meta">
                    <span><i class="fas fa-clock"></i> 3 gün kaldı</span>
                    <span><i class="fas fa-map-marker-alt"></i> 2.5 km</span>
                </div>
                <div class="campaign-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"></i>
                        Detaylar
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-share-alt"></i>
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
                <div class="campaign-header">
                    <div class="store-info">
                        <img src="../assets/images/store2.jpg" alt="Mağaza" class="store-logo">
                        <span>Spor Mağazası</span>
                    </div>
                    <button class="btn btn-icon">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <h3>Spor Ayakkabı İndirimi</h3>
                <p>Seçili spor ayakkabılarda %30 indirim fırsatı!</p>
                <div class="campaign-meta">
                    <span><i class="fas fa-clock"></i> 5 gün kaldı</span>
                    <span><i class="fas fa-map-marker-alt"></i> 1.8 km</span>
                </div>
                <div class="campaign-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"></i>
                        Detaylar
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-share-alt"></i>
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
                <div class="campaign-header">
                    <div class="store-info">
                        <img src="../assets/images/store3.jpg" alt="Mağaza" class="store-logo">
                        <span>Elektronik Mağazası</span>
                    </div>
                    <button class="btn btn-icon">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
                <h3>Elektronik Ürün İndirimi</h3>
                <p>Tüm elektronik ürünlerde %40'a varan indirimler!</p>
                <div class="campaign-meta">
                    <span><i class="fas fa-clock"></i> 2 gün kaldı</span>
                    <span><i class="fas fa-map-marker-alt"></i> 3.2 km</span>
                </div>
                <div class="campaign-actions">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"></i>
                        Detaylar
                    </button>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-share-alt"></i>
                        Paylaş
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Favori Mağazalar -->
<div class="section">
    <div class="section-header">
        <h2>Favori Mağazalar</h2>
        <div class="section-actions">
            <button class="btn btn-outline btn-sm">
                <i class="fas fa-sort"></i>
                Sırala
            </button>
        </div>
    </div>
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
</div>

<style>
    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h2 {
        font-size: 1.5rem;
        color: var(--gray-800);
    }

    /* Mağazalar */
    .stores-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .store-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .store-card:hover {
        transform: translateY(-5px);
    }

    .store-image {
        position: relative;
        height: 200px;
    }

    .store-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .store-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .store-status.open {
        background: var(--success);
        color: white;
    }

    .store-status.closed {
        background: var(--danger);
        color: white;
    }

    .store-content {
        padding: 20px;
    }

    .store-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .store-info h3 {
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .store-rating {
        color: var(--warning);
        font-size: 0.9rem;
    }

    .store-rating span {
        color: var(--gray-600);
        margin-left: 5px;
    }

    .store-address {
        color: var(--gray-600);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .store-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .store-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 15px;
        padding: 15px;
        background: var(--gray-50);
        border-radius: 5px;
    }

    .stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 5px;
    }

    .stat i {
        color: var(--primary);
        font-size: 1.2rem;
    }

    .stat span {
        font-size: 0.8rem;
        color: var(--gray-600);
    }

    .store-actions {
        display: flex;
        gap: 10px;
    }

    /* Kampanyalar */
    .campaigns-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .campaign-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .campaign-card:hover {
        transform: translateY(-5px);
    }

    .campaign-image {
        position: relative;
        height: 200px;
    }

    .campaign-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .campaign-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--primary);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        font-weight: 600;
    }

    .campaign-content {
        padding: 20px;
    }

    .campaign-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .store-logo {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }

    .campaign-content h3 {
        font-size: 1.1rem;
        margin-bottom: 10px;
    }

    .campaign-desc {
        color: var(--gray-600);
        margin-bottom: 15px;
    }

    .campaign-meta {
        display: flex;
        gap: 15px;
        color: var(--gray-500);
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .campaign-actions {
        display: flex;
        gap: 10px;
    }

    /* Favori Butonları */
    .btn-icon {
        color: var(--gray-500);
    }

    .btn-primary {
        background: var(--primary);
        border-color: var(--primary);
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stores-grid,
        .campaigns-grid {
            grid-template-columns: 1fr;
        }

        .store-stats {
            grid-template-columns: 1fr;
        }

        .store-actions,
        .campaign-actions {
            flex-direction: column;
        }

        .store-actions .btn,
        .campaign-actions .btn {
            width: 100%;
        }
    }
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>