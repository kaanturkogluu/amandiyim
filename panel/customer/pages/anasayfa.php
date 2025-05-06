<?php
require_once __DIR__ . '/../includes/header.php';
?>
<div class="customer-content">
    <div class="content-header">
        <h1>Hoş Geldiniz, Ahmet</h1>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="showNotifications()">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
        </div>
    </div>

    <!-- İstatistikler -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Toplam Kampanya</h3>
                <div class="stat-value">24</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 3 yeni
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <h3>Takip Edilen Mağaza</h3>
                <div class="stat-value">12</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 1 yeni
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-info">
                <h3>Favori Kampanya</h3>
                <div class="stat-value">8</div>
                <div class="stat-change">
                    <i class="fas fa-minus"></i> Değişim yok
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>Aktif Şikayet</h3>
                <div class="stat-value">2</div>
                <div class="stat-change negative">
                    <i class="fas fa-arrow-up"></i> 1 yeni
                </div>
            </div>
        </div>
    </div>

    <!-- Son Kampanyalar -->
    <div class="section">
        <div class="section-header">
            <h2>Son Kampanyalar</h2>
            <a href="campaigns.php" class="btn btn-outline">Tümünü Gör</a>
        </div>
        <div class="campaigns-grid">
            <div class="campaign-card">
                <div class="campaign-image">
                    <img src="https://www.olcamimarlik.com/wp-content/uploads/2023/03/magaza-dekorasyon-tadilat-1024x683.jpg" alt="Kampanya">
                    <div class="campaign-badge">Yeni</div>
                </div>
                <div class="campaign-content">
                    <h3>Yaz İndirimi</h3>
                    <div class="store-name">
                        <i class="fas fa-store"></i> Moda Mağazası
                    </div>
                    <p class="campaign-desc">Tüm yaz ürünlerinde %50'ye varan indirimler!</p>
                    <div class="campaign-meta">
                        <span><i class="fas fa-calendar"></i> 15.06.2024</span>
                        <span><i class="fas fa-map-marker-alt"></i> İstanbul</span>
                    </div>
                    <a href="#" class="btn btn-primary btn-block">Detaylar</a>
                </div>
            </div>
            <div class="campaign-card">
                <div class="campaign-image">
                    <img src="../assets/images/campaign2.jpg" alt="Kampanya">
                    <div class="campaign-badge">Popüler</div>
                </div>
                <div class="campaign-content">
                    <h3>Sezon Sonu</h3>
                    <div class="store-name">
                        <i class="fas fa-store"></i> Spor Mağazası
                    </div>
                    <p class="campaign-desc">Sezon sonu ürünlerde büyük indirim!</p>
                    <div class="campaign-meta">
                        <span><i class="fas fa-calendar"></i> 20.06.2024</span>
                        <span><i class="fas fa-map-marker-alt"></i> Ankara</span>
                    </div>
                    <a href="#" class="btn btn-primary btn-block">Detaylar</a>
                </div>
            </div>
            <div class="campaign-card">
                <div class="campaign-image">
                    <img src="../assets/images/campaign3.jpg" alt="Kampanya">
                </div>
                <div class="campaign-content">
                    <h3>Özel Fırsat</h3>
                    <div class="store-name">
                        <i class="fas fa-store"></i> Elektronik Mağazası
                    </div>
                    <p class="campaign-desc">Seçili ürünlerde %30 indirim!</p>
                    <div class="campaign-meta">
                        <span><i class="fas fa-calendar"></i> 25.06.2024</span>
                        <span><i class="fas fa-map-marker-alt"></i> İzmir</span>
                    </div>
                    <a href="#" class="btn btn-primary btn-block">Detaylar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Takip Edilen Mağazalar -->
    <div class="section">
        <div class="section-header">
            <h2>Takip Edilen Mağazalar</h2>
            <a href="stores.php" class="btn btn-outline">Tümünü Gör</a>
        </div>
        <div class="stores-grid">
            <div class="store-card">
                <div class="store-image">
                    <img src="../assets/images/store1.jpg" alt="Mağaza">
                </div>
                <div class="store-content">
                    <h3>Moda Mağazası</h3>
                    <div class="store-address">
                        <i class="fas fa-map-marker-alt"></i> İstanbul, Kadıköy
                    </div>
                    <div class="store-meta">
                        <span><i class="fas fa-tags"></i> 5 Kampanya</span>
                        <span><i class="fas fa-star"></i> 4.5</span>
                    </div>
                    <a href="#" class="btn btn-outline btn-block">Mağazayı Gör</a>
                </div>
            </div>
            <div class="store-card">
                <div class="store-image">
                    <img src="../assets/images/store2.jpg" alt="Mağaza">
                </div>
                <div class="store-content">
                    <h3>Spor Mağazası</h3>
                    <div class="store-address">
                        <i class="fas fa-map-marker-alt"></i> Ankara, Çankaya
                    </div>
                    <div class="store-meta">
                        <span><i class="fas fa-tags"></i> 3 Kampanya</span>
                        <span><i class="fas fa-star"></i> 4.2</span>
                    </div>
                    <a href="#" class="btn btn-outline btn-block">Mağazayı Gör</a>
                </div>
            </div>
            <div class="store-card">
                <div class="store-image">
                    <img src="../assets/images/store3.jpg" alt="Mağaza">
                </div>
                <div class="store-content">
                    <h3>Elektronik Mağazası</h3>
                    <div class="store-address">
                        <i class="fas fa-map-marker-alt"></i> İzmir, Karşıyaka
                    </div>
                    <div class="store-meta">
                        <span><i class="fas fa-tags"></i> 2 Kampanya</span>
                        <span><i class="fas fa-star"></i> 4.8</span>
                    </div>
                    <a href="#" class="btn btn-outline btn-block">Mağazayı Gör</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* İstatistikler */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.campaign {
        background: var(--primary);
    }

    .stat-icon.store {
        background: var(--success);
    }

    .stat-icon.favorite {
        background: var(--danger);
    }

    .stat-icon.notification {
        background: var(--warning);
    }

    .stat-info h3 {
        font-size: 1.8rem;
        color: var(--gray-800);
        margin-bottom: 5px;
    }

    .stat-info p {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    /* Section */
    .section {
        margin-bottom: 30px;
    }

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

    /* Campaigns Grid */
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

    .campaign-store {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .store-avatar {
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

    /* Stores Grid */
    .stores-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
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

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .campaigns-grid,
        .stores-grid {
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