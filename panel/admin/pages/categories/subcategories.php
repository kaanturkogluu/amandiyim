<?php
require_once __DIR__ . '/../../includes/header.php';
require_once classes . 'CampaignsSubCategories.php';

$subcategories = new CampaignsSubCategories();
$id = $_GET['id'];
$categories = $subcategories->getSelectedColumns(['id', 'sub_category_name', 'sub_description'], ['store_categories_id' => $id]);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="<?= Helper::adminPanelView('categories/categories') ?>" class="back-button">
                                <i class="fas fa-arrow-left"></i> Geri Dön
                            </a>
                        </div>
                        <h3 class="card-title">Alt Kategoriler</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" onclick="openAddModal()">
                                Yeni Alt Kategori Ekle
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Alt Kategori Adı</th>
                                <th>Açıklama</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody id="subcategoriesTable">
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo $category['id']; ?></td>
                                    <td><?php echo htmlspecialchars($category['sub_category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['sub_description']); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="window.location.href='subsubcategories.php?subid=<?= $category['id'] ?>&mainsub=<?=$id?>'">
                                            Alt Kategori Başlıkları
                                        </button>

                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="openEditModal(<?php echo htmlspecialchars(json_encode($category)); ?>)">
                                            Düzenle
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete(<?php echo $category['id']; ?>)">
                                            Sil
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<div id="addModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Yeni Alt Kategori Ekle</h5>
            <span class="close" onclick="closeModal('addModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addForm">
                <div class="form-group">
                    <label>Alt Kategori Adı</label>
                    <input type="text" class="form-control" name="sub_category_name" required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea class="form-control" name="sub_description"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">İptal</button>
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Alt Kategori Düzenle</h5>
            <span class="close" onclick="closeModal('editModal')">&times;</span>
        </div>
        <div class="modal-body">
            <form id="editForm">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>Alt Kategori Adı</label>
                    <input type="text" class="form-control" name="sub_category_name" id="edit_sub_category_name"
                        required>
                </div>
                <div class="form-group">
                    <label>Açıklama</label>
                    <textarea class="form-control" name="sub_description" id="edit_sub_description"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">İptal</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="deleteModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Alt Kategori Sil</h5>
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
        </div>
        <div class="modal-body">
            <p>Bu alt kategoriyi silmek istediğinizden emin misiniz?</p>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">İptal</button>
                <button type="button" class="btn btn-danger" onclick="deleteSubcategory()">Sil</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 500px;
        border-radius: 5px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: black;
    }

    /* Geri Dön Butonu Stilleri */
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background-color: #17a2b8;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .back-button i {
        margin-right: 8px;
        font-size: 16px;
    }

    .back-button:hover {
        background-color: #138496;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .back-button:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Card Header Düzenlemesi */
    .card-header {
        padding: 1rem;
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .card-header .d-flex {
        gap: 1rem;
    }

    .card-title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 500;
        color: #333;
    }
</style>

<script>
    let currentDeleteId = null;

    // Modal işlemleri
    function openAddModal() {
        document.getElementById('addModal').style.display = 'block';
    }

    function openEditModal(category) {
        document.getElementById('edit_id').value = category.id;
        document.getElementById('edit_sub_category_name').value = category.sub_category_name;
        document.getElementById('edit_sub_description').value = category.sub_description;
        document.getElementById('editModal').style.display = 'block';
    }

    function confirmDelete(id) {
        currentDeleteId = id;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Form işlemleri
    document.getElementById('addForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('store_categories_id', '<?php echo $id; ?>');
        formData.append('action', 'create');

        try {
            const response = await fetch('<?= Helper::controller('subcategoriesController') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message || 'Bir hata oluştu!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        }
    });

    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('action', 'update');

        try {
            const response = await fetch('<?= Helper::controller('subcategoriesController') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message || 'Bir hata oluştu!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        }
    });

    async function deleteSubcategory() {
        if (!currentDeleteId) return;

        try {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', currentDeleteId);

            const response = await fetch('<?= Helper::controller('subcategoriesController') ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);
                window.location.reload();
            } else {
                alert(result.message || 'Bir hata oluştu!');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Bir hata oluştu!');
        }
    }

    // Modal dışına tıklandığında kapatma
    window.onclick = function (event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>