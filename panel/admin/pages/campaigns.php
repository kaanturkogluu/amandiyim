<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1>Kampanyalar</h1>
        <button class="btn btn-primary" onclick="openAddCampaignModal()">
            <i class="fas fa-plus"></i> Yeni Kampanya Ekle
        </button>
    </div>

    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Kampanya ara..." id="campaignSearch">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active" data-filter="all">Tümü</button>
            <button class="btn btn-outline" data-filter="active">Aktif</button>
            <button class="btn btn-outline" data-filter="expired">Süresi Dolmuş</button>
            <button class="btn btn-outline" data-filter="pending">Onay Bekleyen</button>
        </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Mağaza</th>
                    <th>Kampanya Başlığı</th>
                    <th>İndirim Oranı</th>
                    <th>Başlangıç</th>
                    <th>Bitiş</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <!-- Örnek veri -->
                <tr>
                    <td>Örnek Mağaza</td>
                    <td>Yaz İndirimi</td>
                    <td>%20</td>
                    <td>01.01.2024</td>
                    <td>31.01.2024</td>
                    <td><span class="status-badge active">Aktif</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-icon" onclick="editCampaign(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-icon" onclick="deleteCampaign(1)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <button class="btn btn-outline" disabled>
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="btn btn-outline active">1</button>
        <button class="btn btn-outline">2</button>
        <button class="btn btn-outline">3</button>
        <button class="btn btn-outline">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

<!-- Kampanya Ekleme/Düzenleme Modal -->
<div class="modal" id="campaignModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Yeni Kampanya Ekle</h2>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="campaignForm">
                <div class="form-group">
                    <label>Mağaza</label>
                    <select name="store_id" required>
                        <option value="">Mağaza Seçin</option>
                        <option value="1">Örnek Mağaza</option>
                        <option value="2">Test Mağaza</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kampanya Başlığı</label>
                    <input type="text" name="title" required>
                </div>
                <div class="form-group">
                    <label>Kampanya Açıklaması</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label>İndirim Oranı (%)</label>
                    <input type="number" name="discount_rate" min="0" max="100" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Başlangıç Tarihi</label>
                        <input type="date" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label>Bitiş Tarihi</label>
                        <input type="date" name="end_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Durum</label>
                    <select name="status" required>
                        <option value="pending">Onay Bekliyor</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">İptal</button>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Modal işlemleri
function openAddCampaignModal() {
    document.getElementById('campaignModal').classList.add('active');
    document.getElementById('campaignForm').reset();
    document.querySelector('.modal-header h2').textContent = 'Yeni Kampanya Ekle';
}

function closeModal() {
    document.getElementById('campaignModal').classList.remove('active');
}

// ESC tuşu ile modalı kapatma
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Modal dışına tıklayarak kapatma
document.getElementById('campaignModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Form gönderimi
document.getElementById('campaignForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Form verilerini işleme
    closeModal();
});

// Kampanya düzenleme
function editCampaign(id) {
    // Kampanya verilerini getir ve modalı aç
    document.querySelector('.modal-header h2').textContent = 'Kampanya Düzenle';
    document.getElementById('campaignModal').classList.add('active');
}

// Kampanya silme
function deleteCampaign(id) {
    if (confirm('Bu kampanyayı silmek istediğinizden emin misiniz?')) {
        // Silme işlemi
    }
}

// Arama işlevi
document.getElementById('campaignSearch').addEventListener('input', function(e) {
    // Arama işlemi
});

// Filtreleme işlevi
document.querySelectorAll('.filter-buttons .btn').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
            btn.classList.remove('active');
        });
        this.classList.add('active');
        // Filtreleme işlemi
    });
});
</script>

<?php
require_once __DIR__ . '/../includes/footer.php';
?> 