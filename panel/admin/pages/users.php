<?php
require_once __DIR__ . '/../includes/header.php';
?>

<div class="admin-content">
    <div class="content-header">
        <h1>Kullanıcılar</h1>
        <button class="btn btn-primary" onclick="openAddUserModal()">
            <i class="fas fa-plus"></i> Yeni Kullanıcı Ekle
        </button>
    </div>

    <div class="content-filters">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Kullanıcı ara..." id="userSearch">
        </div>
        <div class="filter-buttons">
            <button class="btn btn-outline active" data-filter="all">Tümü</button>
            <button class="btn btn-outline" data-filter="active">Aktif</button>
            <button class="btn btn-outline" data-filter="inactive">Pasif</button>
            <button class="btn btn-outline" data-filter="banned">Yasaklı</button>
        </div>
    </div>

    <div class="content-table">
        <table>
            <thead>
                <tr>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Kayıt Tarihi</th>
                    <th>Son Giriş</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <!-- Örnek veri -->
                <tr>
                    <td>Ahmet Yılmaz</td>
                    <td>ahmet@example.com</td>
                    <td>0555 555 55 55</td>
                    <td>01.01.2024</td>
                    <td>15.01.2024</td>
                    <td><span class="status-badge active">Aktif</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-icon" onclick="editUser(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-icon" onclick="deleteUser(1)">
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

<!-- Kullanıcı Ekleme/Düzenleme Modal -->
<div class="modal" id="userModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Yeni Kullanıcı Ekle</h2>
            <button class="close-modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="userForm">
                <div class="form-group">
                    <label>Ad Soyad</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>E-posta</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Telefon</label>
                    <input type="tel" name="phone" required>
                </div>
                <div class="form-group">
                    <label>Şifre</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Durum</label>
                    <select name="status" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                        <option value="banned">Yasaklı</option>
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
function openAddUserModal() {
    document.getElementById('userModal').classList.add('active');
    document.getElementById('userForm').reset();
    document.querySelector('.modal-header h2').textContent = 'Yeni Kullanıcı Ekle';
}

function closeModal() {
    document.getElementById('userModal').classList.remove('active');
}

// ESC tuşu ile modalı kapatma
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Modal dışına tıklayarak kapatma
document.getElementById('userModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Form gönderimi
document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Form verilerini işleme
    closeModal();
});

// Kullanıcı düzenleme
function editUser(id) {
    // Kullanıcı verilerini getir ve modalı aç
    document.querySelector('.modal-header h2').textContent = 'Kullanıcı Düzenle';
    document.getElementById('userModal').classList.add('active');
}

// Kullanıcı silme
function deleteUser(id) {
    if (confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?')) {
        // Silme işlemi
    }
}

// Arama işlevi
document.getElementById('userSearch').addEventListener('input', function(e) {
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