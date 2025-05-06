<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="store-content">
    <div class="content-header">
        <h1>Müşteriler</h1>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="exportCustomers()">
                <i class="fas fa-download"></i> Dışa Aktar
            </button>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Müşteri ara..." onkeyup="searchCustomers(this.value)">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active" onclick="filterCustomers('all')">Tümü</button>
            <button class="btn btn-outline" onclick="filterCustomers('active')">Aktif</button>
            <button class="btn btn-outline" onclick="filterCustomers('inactive')">Pasif</button>
            <button class="btn btn-outline" onclick="filterCustomers('new')">Yeni</button>
        </div>
    </div>

    <!-- Müşteriler Tablosu -->
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Müşteri ID</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Kayıt Tarihi</th>
                    <th>Son Sipariş</th>
                    <th>Toplam Sipariş</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#1001</td>
                    <td>Ahmet Yılmaz</td>
                    <td>ahmet@example.com</td>
                    <td>0555 123 4567</td>
                    <td>2024-03-01</td>
                    <td>2024-03-29</td>
                    <td>5</td>
                    <td><span class="status-badge active">Aktif</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" title="Detay" onclick="viewCustomer(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Düzenle" onclick="editCustomer(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>#1002</td>
                    <td>Mehmet Demir</td>
                    <td>mehmet@example.com</td>
                    <td>0555 987 6543</td>
                    <td>2024-03-15</td>
                    <td>2024-03-28</td>
                    <td>2</td>
                    <td><span class="status-badge active">Aktif</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" title="Detay" onclick="viewCustomer(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Düzenle" onclick="editCustomer(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Sayfalama -->
    <div class="pagination">
        <button class="btn btn-outline"><i class="fas fa-chevron-left"></i></button>
        <button class="btn btn-outline active">1</button>
        <button class="btn btn-outline">2</button>
        <button class="btn btn-outline">3</button>
        <button class="btn btn-outline"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<!-- Müşteri Detay Modal -->
<div class="modal" id="customerModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Müşteri Detayı</h2>
            <button class="close-modal" onclick="closeCustomerModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="customer-info">
                <div class="info-group">
                    <label>Müşteri ID:</label>
                    <span>#1001</span>
                </div>
                <div class="info-group">
                    <label>Ad Soyad:</label>
                    <span>Ahmet Yılmaz</span>
                </div>
                <div class="info-group">
                    <label>E-posta:</label>
                    <span>ahmet@example.com</span>
                </div>
                <div class="info-group">
                    <label>Telefon:</label>
                    <span>0555 123 4567</span>
                </div>
                <div class="info-group">
                    <label>Kayıt Tarihi:</label>
                    <span>2024-03-01</span>
                </div>
                <div class="info-group">
                    <label>Durum:</label>
                    <span class="status-badge active">Aktif</span>
                </div>
            </div>

            <div class="customer-stats">
                <h3>Müşteri İstatistikleri</h3>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Toplam Sipariş</h3>
                            <p class="stat-value">5</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Toplam Harcama</h3>
                            <p class="stat-value">₺1,250</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Ortalama Puan</h3>
                            <p class="stat-value">4.8</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-orders">
                <h3>Son Siparişler</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Sipariş No</th>
                            <th>Tarih</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>2024-03-29</td>
                            <td>₺150.00</td>
                            <td><span class="status-badge active">Tamamlandı</span></td>
                        </tr>
                        <tr>
                            <td>#12344</td>
                            <td>2024-03-28</td>
                            <td>₺275.00</td>
                            <td><span class="status-badge active">Tamamlandı</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="customer-actions">
                <button class="btn btn-outline" onclick="closeCustomerModal()">Kapat</button>
                <button class="btn btn-primary" onclick="editCustomer(1)">Düzenle</button>
            </div>
        </div>
    </div>
</div>

<script>
// Müşteri Modal İşlemleri
function viewCustomer(id) {
    document.getElementById('customerModal').classList.add('active');
    // Müşteri detaylarını getir
}

function closeCustomerModal() {
    document.getElementById('customerModal').classList.remove('active');
}

function editCustomer(id) {
    // Müşteri düzenleme sayfasına yönlendir
    console.log('Müşteri düzenleme:', id);
}

// Müşteri Arama
function searchCustomers(query) {
    console.log('Müşteri arama:', query);
}

// Müşteri Filtreleme
function filterCustomers(filter) {
    const buttons = document.querySelectorAll('.filter-buttons .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Müşteri filtreleme:', filter);
}

// Müşterileri Dışa Aktar
function exportCustomers() {
    console.log('Müşteriler dışa aktarılıyor...');
}
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 