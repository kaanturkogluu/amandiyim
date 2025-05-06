<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="store-content">
    <div class="content-header">
        <h1>Siparişler</h1>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="exportOrders()">
                <i class="fas fa-download"></i> Dışa Aktar
            </button>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Sipariş ara..." onkeyup="searchOrders(this.value)">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active" onclick="filterOrders('all')">Tümü</button>
            <button class="btn btn-outline" onclick="filterOrders('pending')">Bekleyen</button>
            <button class="btn btn-outline" onclick="filterOrders('processing')">İşleniyor</button>
            <button class="btn btn-outline" onclick="filterOrders('completed')">Tamamlandı</button>
            <button class="btn btn-outline" onclick="filterOrders('cancelled')">İptal Edildi</button>
        </div>
    </div>

    <!-- Siparişler Tablosu -->
    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Müşteri</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#12345</td>
                    <td>Ahmet Yılmaz</td>
                    <td>₺150.00</td>
                    <td><span class="status-badge active">Tamamlandı</span></td>
                    <td>2024-03-29 14:30</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" title="Detay" onclick="viewOrder(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Düzenle" onclick="editOrder(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>#12344</td>
                    <td>Mehmet Demir</td>
                    <td>₺275.00</td>
                    <td><span class="status-badge pending">Bekliyor</span></td>
                    <td>2024-03-29 13:15</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-icon" title="Detay" onclick="viewOrder(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" title="Düzenle" onclick="editOrder(2)">
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

<!-- Sipariş Detay Modal -->
<div class="modal" id="orderModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Sipariş Detayı</h2>
            <button class="close-modal" onclick="closeOrderModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="order-info">
                <div class="info-group">
                    <label>Sipariş No:</label>
                    <span>#12345</span>
                </div>
                <div class="info-group">
                    <label>Müşteri:</label>
                    <span>Ahmet Yılmaz</span>
                </div>
                <div class="info-group">
                    <label>Tarih:</label>
                    <span>2024-03-29 14:30</span>
                </div>
                <div class="info-group">
                    <label>Durum:</label>
                    <span class="status-badge active">Tamamlandı</span>
                </div>
            </div>

            <div class="order-items">
                <h3>Sipariş Ürünleri</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Ürün</th>
                            <th>Adet</th>
                            <th>Fiyat</th>
                            <th>Toplam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ürün 1</td>
                            <td>2</td>
                            <td>₺75.00</td>
                            <td>₺150.00</td>
                        </tr>
                        <tr>
                            <td>Ürün 2</td>
                            <td>1</td>
                            <td>₺125.00</td>
                            <td>₺125.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Ara Toplam:</td>
                            <td>₺275.00</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right">KDV (%18):</td>
                            <td>₺49.50</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Genel Toplam:</strong></td>
                            <td><strong>₺324.50</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="order-actions">
                <button class="btn btn-outline" onclick="closeOrderModal()">Kapat</button>
                <button class="btn btn-primary" onclick="updateOrderStatus()">Durumu Güncelle</button>
            </div>
        </div>
    </div>
</div>

<script>
// Sipariş Modal İşlemleri
function viewOrder(id) {
    document.getElementById('orderModal').classList.add('active');
    // Sipariş detaylarını getir
}

function closeOrderModal() {
    document.getElementById('orderModal').classList.remove('active');
}

function editOrder(id) {
    // Sipariş düzenleme sayfasına yönlendir
    console.log('Sipariş düzenleme:', id);
}

function updateOrderStatus() {
    // Sipariş durumunu güncelle
    console.log('Sipariş durumu güncellendi');
}

// Sipariş Arama
function searchOrders(query) {
    console.log('Sipariş arama:', query);
}

// Sipariş Filtreleme
function filterOrders(filter) {
    const buttons = document.querySelectorAll('.filter-buttons .btn');
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    console.log('Sipariş filtreleme:', filter);
}

// Siparişleri Dışa Aktar
function exportOrders() {
    console.log('Siparişler dışa aktarılıyor...');
}
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 