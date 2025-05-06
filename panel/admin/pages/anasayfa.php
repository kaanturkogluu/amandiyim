<?php


require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../../../classes/Stores.php';
$stores = new Stores();
$storeCount = $stores->getStoreCount();


?>


<div class="admin-panel">


    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="stat-info">
                    <h3>Toplam Mağaza</h3>
                    <p><?= $storeCount ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-info">
                    <h3>Aktif Kampanya</h3>
                    <p>12</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>Toplam Kullanıcı</h3>
                    <p>156</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>Günlük Ziyaret</h3>
                    <p>1,234</p>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="recent-activities">
            <div class="section-header">
                <h2>Son Aktiviteler</h2>
                <a href="#" class="view-all">Tümünü Gör</a>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="activity-content">
                        <p>Yeni mağaza kaydı: <strong>Örnek Mağaza</strong></p>
                        <span class="activity-time">2 saat önce</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="activity-content">
                        <p>Yeni kampanya eklendi: <strong>Yaz İndirimi</strong></p>
                        <span class="activity-time">4 saat önce</span>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-content">
                        <p>Yeni kullanıcı kaydı: <strong>Ahmet Yılmaz</strong></p>
                        <span class="activity-time">6 saat önce</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-panel {
        padding: 20px;
        min-height: calc(100vh - 120px);
    }

    .dashboard-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--white);
        padding: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: var(--shadow-sm);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--primary);
        color: var(--white);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-info h3 {
        font-size: 0.9rem;
        color: var(--gray);
        margin: 0 0 5px 0;
    }

    .stat-info p {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark);
        margin: 0;
    }

    .recent-activities {
        background: var(--white);
        padding: 20px;
        border-radius: 10px;
        box-shadow: var(--shadow-sm);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-header h2 {
        font-size: 1.2rem;
        margin: 0;
    }

    .view-all {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .activity-content {
        flex: 1;
    }

    .activity-content p {
        margin: 0;
        color: var(--dark);
    }

    .activity-time {
        font-size: 0.8rem;
        color: var(--gray);
    }

    @media (max-width: 768px) {
        .admin-panel {
            padding: 15px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>