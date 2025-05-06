<?php
require_once __DIR__ . '/../includes/header.php';
?>
<div class="store-content">
    <div class="content-header">
        <h1>Analizler</h1>
        <div class="header-actions">
            <div class="date-range">
                <button class="btn btn-outline active" onclick="setDateRange('today')">Bugün</button>
                <button class="btn btn-outline" onclick="setDateRange('week')">Bu Hafta</button>
                <button class="btn btn-outline" onclick="setDateRange('month')">Bu Ay</button>
                <button class="btn btn-outline" onclick="setDateRange('year')">Bu Yıl</button>
            </div>
            <!-- <button class="btn btn-primary" onclick="exportAnalytics()">
                <i class="fas fa-download"></i> Rapor İndir
            </button> -->
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Verilerinizin Analizi 1 Ay Sonra Başlayacaktır</h3>

            </div>

        </div>


    </div>
    <?php
require_once __DIR__ . '/../includes/footer.php';
?>