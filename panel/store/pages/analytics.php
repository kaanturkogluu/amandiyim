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
            <button class="btn btn-primary" onclick="exportAnalytics()">
                <i class="fas fa-download"></i> Rapor İndir
            </button>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-coins"></i>
            </div>
            <div class="stat-info">
                <h3>Kalan Kredi</h3>
                <p class="stat-value">1,250</p>
                <p class="stat-change">
                    <button class="btn btn-outline btn-sm" onclick="showCreditModal()">
                        <i class="fas fa-plus"></i> Kredi Yükle
                    </button>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-info">
                <h3>Aktif Kampanyalar</h3>
                <p class="stat-value">3</p>
                <p class="stat-change">
                    <a href="campaigns.php" class="btn btn-outline btn-sm">
                        <i class="fas fa-eye"></i> Tümünü Gör
                    </a>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3>Toplam Görüntülenme</h3>
                <p class="stat-value">12,450</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> %15 artış
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-info">
                <h3>Farklı Cihaz Görüntülenme</h3>
                <p class="stat-value">8,250</p>
                <p class="stat-change positive">
                    <i class="fas fa-arrow-up"></i> %12 artış
                </p>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h3>Kampanya Performansı</h3>
                <div class="chart-actions">
                    <button class="btn-icon" onclick="toggleChartType('campaigns')">
                        <i class="fas fa-chart-pie"></i>
                    </button>
                    <button class="btn-icon" onclick="toggleChartType('campaigns')">
                        <i class="fas fa-chart-doughnut"></i>
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
                <h3>En Başarılı Kampanyalar</h3>
                <button class="btn btn-outline">Tümünü Gör</button>
            </div>
            <div class="report-body">
                <table>
                    <thead>
                        <tr>
                            <th>Kampanya</th>
                            <th>Görüntülenme</th>
                            <th>Etkileşim</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yaz İndirimi</td>
                            <td>5,250</td>
                            <td>850</td>
                            <td>
                                <span class="trend positive">
                                    <i class="fas fa-arrow-up"></i> %12
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Sezon Sonu</td>
                            <td>4,800</td>
                            <td>720</td>
                            <td>
                                <span class="trend positive">
                                    <i class="fas fa-arrow-up"></i> %8
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="report-card">
            <div class="report-header">
                <h3>Kredi Kullanım Detayı</h3>
                <button class="btn btn-outline">Tümünü Gör</button>
            </div>
            <div class="report-body">
                <table>
                    <thead>
                        <tr>
                            <th>Kampanya</th>
                            <th>Kredi</th>
                            <th>Kullanım</th>
                            <th>Trend</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yaz İndirimi</td>
                            <td>500</td>
                            <td>%85</td>
                            <td>
                                <span class="trend positive">
                                    <i class="fas fa-arrow-up"></i> %15
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Sezon Sonu</td>
                            <td>750</td>
                            <td>%65</td>
                            <td>
                                <span class="trend positive">
                                    <i class="fas fa-arrow-up"></i> %5
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Kredi Yükleme Modal -->
<div class="modal" id="creditModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Kredi Yükleme</h2>
            <button class="close-modal" onclick="closeCreditModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="coming-soon">
                <i class="fas fa-clock"></i>
                <h3>Yakında</h3>
                <p>Kredi yükleme sistemi yakında aktif olacaktır.</p>
                <p>Şu an için kredi yüklemeleri admin tarafından yapılmaktadır.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Kredi Grafiği
const creditsCtx = document.getElementById('creditsChart').getContext('2d');
const creditsChart = new Chart(creditsCtx, {
    type: 'line',
    data: {
        labels: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
        datasets: [{
            label: 'Kredi Kullanımı',
            data: [100, 150, 200, 250, 300, 350, 400],
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
                beginAtZero: true
            }
        }
    }
});

// Kampanya Grafiği
const campaignsCtx = document.getElementById('campaignsChart').getContext('2d');
const campaignsChart = new Chart(campaignsCtx, {
    type: 'doughnut',
    data: {
        labels: ['Yaz İndirimi', 'Sezon Sonu', 'Diğer'],
        datasets: [{
            data: [45, 35, 20],
            backgroundColor: ['#8E44AD', '#2C3E50', '#E74C3C']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Tarih Aralığı Değiştirme
function setDateRange(range) {
    const buttons = document.querySelectorAll('.date-range .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Tarih aralığı:', range);
}

// Grafik Tipi Değiştirme
function toggleChartType(chart) {
    console.log('Grafik tipi değiştirme:', chart);
}

// Kredi İşlemleri
function showCreditModal() {
    document.getElementById('creditModal').classList.add('active');
}

function closeCreditModal() {
    document.getElementById('creditModal').classList.remove('active');
}

// Rapor İndirme
function exportAnalytics() {
    console.log('Analiz raporu indiriliyor...');
}
</script>

<style>
.coming-soon {
    text-align: center;
    padding: 40px 20px;
}

.coming-soon i {
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 20px;
}

.coming-soon h3 {
    font-size: 1.5rem;
    color: var(--dark);
    margin-bottom: 10px;
}

.coming-soon p {
    color: var(--gray);
    margin-bottom: 5px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.8rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.date-range {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .header-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .date-range {
        margin-bottom: 10px;
    }

    .date-range .btn {
        flex: 1;
    }
}
</style>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>