<?php
require_once __DIR__ . '/../includes/header.php';

// Arama terimi
$search = isset($_GET['q']) ? $_GET['q'] : '';

// Arama sonuçları
$results = [
    'campaigns' => [
        [
            'id' => 1,
            'title' => 'Yaz Sezonu İndirimi',
            'store' => 'Moda Mağazası',
            'discount' => 50,
            'image' => '../assets/images/campaign1.jpg',
            'store_logo' => '../assets/images/store1.jpg',
            'time_left' => '3 gün kaldı',
            'distance' => '2.5 km'
        ],
        [
            'id' => 2,
            'title' => 'Spor Ayakkabı İndirimi',
            'store' => 'Spor Mağazası',
            'discount' => 30,
            'image' => '../assets/images/campaign2.jpg',
            'store_logo' => '../assets/images/store2.jpg',
            'time_left' => '5 gün kaldı',
            'distance' => '1.8 km'
        ],
        [
            'id' => 3,
            'title' => 'Elektronik Ürün İndirimi',
            'store' => 'Elektronik Mağazası',
            'discount' => 40,
            'image' => '../assets/images/campaign3.jpg',
            'store_logo' => '../assets/images/store3.jpg',
            'time_left' => '2 gün kaldı',
            'distance' => '3.2 km'
        ]
    ],
    'stores' => [
        [
            'id' => 1,
            'name' => 'Moda Mağazası',
            'logo' => '../assets/images/store1.jpg',
            'address' => 'Atatürk Caddesi No:123',
            'rating' => 4.5,
            'campaigns' => 12,
            'followers' => '1.2K',
            'distance' => '2.5 km',
            'status' => 'open'
        ],
        [
            'id' => 2,
            'name' => 'Spor Mağazası',
            'logo' => '../assets/images/store2.jpg',
            'address' => 'İstiklal Caddesi No:456',
            'rating' => 5.0,
            'campaigns' => 8,
            'followers' => '856',
            'distance' => '1.8 km',
            'status' => 'open'
        ],
        [
            'id' => 3,
            'name' => 'Elektronik Mağazası',
            'logo' => '../assets/images/store3.jpg',
            'address' => 'Cumhuriyet Caddesi No:789',
            'rating' => 5.0,
            'campaigns' => 6,
            'followers' => '2.3K',
            'distance' => '3.2 km',
            'status' => 'closed'
        ]
    ]
];
?>

<!-- Sayfa Başlığı -->
<div class="content-header">
    <h1>Arama Sonuçları</h1>
    <div class="header-actions">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Ara..." value="<?= htmlspecialchars($search) ?>">
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
            </div>
        </div>
    </div>
</div>

<!-- Arama Sonuçları -->
<div class="search-results">
    <!-- Kampanyalar -->
    <div class="section">
        <div class="section-header">
            <h2>Kampanyalar</h2>
            <div class="section-actions">
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-sort"></i>
                    Sırala
                </button>
            </div>
        </div>
        <div class="campaigns-grid">
            <?php foreach ($results['campaigns'] as $campaign): ?>
            <div class="campaign-card">
                <div class="campaign-image">
                    <img src="<?= $campaign['image'] ?>" alt="Kampanya">
                    <div class="campaign-badge">%<?= $campaign['discount'] ?></div>
                </div>
                <div class="campaign-content">
                    <div class="campaign-header">
                        <div class="store-info">
                            <img src="<?= $campaign['store_logo'] ?>" alt="Mağaza" class="store-logo">
                            <span><?= $campaign['store'] ?></span>
                        </div>
                        <button class="btn btn-icon">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    <h3><?= $campaign['title'] ?></h3>
                    <div class="campaign-meta">
                        <span><i class="fas fa-clock"></i> <?= $campaign['time_left'] ?></span>
                        <span><i class="fas fa-map-marker-alt"></i> <?= $campaign['distance'] ?></span>
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
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Mağazalar -->
    <div class="section">
        <div class="section-header">
            <h2>Mağazalar</h2>
            <div class="section-actions">
                <button class="btn btn-outline btn-sm">
                    <i class="fas fa-sort"></i>
                    Sırala
                </button>
            </div>
        </div>
        <div class="stores-grid">
            <?php foreach ($results['stores'] as $store): ?>
            <div class="store-card">
                <div class="store-image">
                    <img src="<?= $store['logo'] ?>" alt="Mağaza">
                    <div class="store-status <?= $store['status'] ?>">
                        <i class="fas fa-clock"></i>
                        <?= $store['status'] === 'open' ? 'Açık' : 'Kapalı' ?>
                    </div>
                </div>
                <div class="store-content">
                    <div class="store-header">
                        <div class="store-info">
                            <h3><?= $store['name'] ?></h3>
                            <div class="store-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= $store['rating']): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 <= $store['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span>(<?= $store['rating'] ?>)</span>
                            </div>
                        </div>
                        <button class="btn btn-icon">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>
                    <p class="store-address">
                        <i class="fas fa-map-marker-alt"></i>
                        <?= $store['address'] ?>
                    </p>
                    <div class="store-stats">
                        <div class="stat">
                            <i class="fas fa-tags"></i>
                            <span><?= $store['campaigns'] ?> Aktif Kampanya</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-users"></i>
                            <span><?= $store['followers'] ?> Takipçi</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?= $store['distance'] ?></span>
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
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 