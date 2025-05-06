<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1>Raporlar</h1>
        <div class="header-actions">
            <button class="btn btn-outline">
                <i class="fas fa-download"></i> Rapor İndir
            </button>
            <button class="btn btn-outline">
                <i class="fas fa-calendar"></i> Tarih Aralığı
            </button>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="stat-info">
                <h3>Toplam Mağaza</h3>
                <p class="stat-value">150</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 12% artış
                </p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Aktif Kampanya</h3>
                <p class="stat-value">45</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 8% artış
                </p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Toplam Kullanıcı</h3>
                <p class="stat-value">1,250</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> 15% artış
                </p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h3>Günlük Ziyaret</h3>
                <p class="stat-value">3,500</p>
                <p class="stat-change negative">
                    <i class="fas fa-arrow-down"></i> 5% azalış
                </p>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3>Ziyaret İstatistikleri</h3>
                <div class="chart-actions">
                    <button class="btn btn-icon">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3>Kampanya Performansı</h3>
                <div class="chart-actions">
                    <button class="btn btn-icon">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="campaignsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Detaylı Raporlar -->
    <div class="reports-grid">
        <div class="report-card">
            <div class="report-header">
                <h3>En Çok Ziyaret Edilen Mağazalar</h3>
                <button class="btn btn-text">Tümünü Gör</button>
            </div>
            <div class="report-body">
                <table>
                    <thead>
                        <tr>
                            <th>Mağaza</th>
                            <th>Ziyaret</th>
                            <th>Değişim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Örnek Mağaza 1</td>
                            <td>1,250</td>
                            <td class="positive">+12%</td>
                        </tr>
                        <tr>
                            <td>Örnek Mağaza 2</td>
                            <td>980</td>
                            <td class="positive">+8%</td>
                        </tr>
                        <tr>
                            <td>Örnek Mağaza 3</td>
                            <td>750</td>
                            <td class="negative">-5%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="report-card">
            <div class="report-header">
                <h3>En Aktif Kampanyalar</h3>
                <button class="btn btn-text">Tümünü Gör</button>
            </div>
            <div class="report-body">
                <table>
                    <thead>
                        <tr>
                            <th>Kampanya</th>
                            <th>Görüntülenme</th>
                            <th>Etkileşim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yaz İndirimi</td>
                            <td>2,500</td>
                            <td>450</td>
                        </tr>
                        <tr>
                            <td>Sezon Sonu</td>
                            <td>1,800</td>
                            <td>320</td>
                        </tr>
                        <tr>
                            <td>Özel Fırsat</td>
                            <td>1,200</td>
                            <td>280</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Ziyaret Grafiği
const visitsCtx = document.getElementById('visitsChart').getContext('2d');
new Chart(visitsCtx, {
    type: 'line',
    data: {
        labels: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
        datasets: [{
            label: 'Ziyaret',
            data: [1200, 1900, 1500, 2500, 2200, 3000, 2800],
            borderColor: '#8E44AD',
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(142, 68, 173, 0.1)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Kampanya Grafiği
const campaignsCtx = document.getElementById('campaignsChart').getContext('2d');
new Chart(campaignsCtx, {
    type: 'bar',
    data: {
        labels: ['Kampanya 1', 'Kampanya 2', 'Kampanya 3', 'Kampanya 4', 'Kampanya 5'],
        datasets: [{
            label: 'Görüntülenme',
            data: [2500, 1800, 1200, 900, 600],
            backgroundColor: '#8E44AD'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 