<?php
require_once __DIR__ . '/../../includes/header.php';
require_once classes . 'StoreCategories.php';

$storeCategories = new StoreCategories();
$categories = $storeCategories->all();
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mağaza Kategorileri</h1>
                </div>
                <div class="col-sm-6 ">
                    <button type="button" class="btn btn-primary float-right" id="addCategoryBtn">
                        <i class="fas fa-plus"></i> Yeni Kategori Ekle
                    </button>
                </div>
                
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kategori Adı</th>
                                    <th>Durum</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?= $category['id'] ?></td>
                                        <td><?= htmlspecialchars($category['category_name']) ?></td>
                                        <td>
                                            <span
                                                class="badge badge-<?= $category['status'] == 'active' ? 'success' : 'danger' ?>">
                                                <?= $category['status'] == 'active' ? 'Aktif' : 'Pasif' ?>
                                            </span>
                                        </td>
                                        <td>
                                     
                                            <a href="subcategories.php?id=<?=$category['id']?>" class="btn btn-info">Alt Kampanya Başlıkları</a>
                                      
                                        <button type="button" class="btn btn-sm btn-info edit-category"
                                            data-id="<?= $category['id'] ?>"
                                            data-name="<?= htmlspecialchars($category['category_name']) ?>"
                                            data-status="<?= $category['status'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger delete-category"
                                            data-id="<?= $category['id'] ?>">
                                            <i class="fas fa-trash"></i>
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
    </section>
</div>

<!-- Modal Template -->
<template id="modalTemplate">
    <div class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close-modal">&times;</button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"></div>
        </div>
    </div>
</template>

<style>
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal.show {
        display: flex;
        opacity: 1;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        width: 90%;
        max-width: 500px;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
    }

    .modal.show .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        padding: 1rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        margin: 0;
        font-size: 1.25rem;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        color: #6c757d;
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-footer {
        padding: 1rem;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.375rem 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .btn {
        padding: 0.375rem 0.75rem;
        border-radius: 0.25rem;
        cursor: pointer;
        border: 1px solid transparent;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
</style>

<script>
    class Modal {
        constructor() {
            this.modal = null;
            this.template = document.getElementById('modalTemplate');
        }

        create(title, content, footer) {
            const clone = this.template.content.cloneNode(true);
            this.modal = clone.querySelector('.modal');

            this.modal.querySelector('.modal-title').textContent = title;
            this.modal.querySelector('.modal-body').innerHTML = content;
            this.modal.querySelector('.modal-footer').innerHTML = footer;

            document.body.appendChild(this.modal);

            this.setupEventListeners();
            this.show();
        }

        setupEventListeners() {
            const closeBtn = this.modal.querySelector('.close-modal');
            closeBtn.addEventListener('click', () => this.hide());

            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.hide();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.modal.classList.contains('show')) {
                    this.hide();
                }
            });
        }

        show() {
            this.modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        hide() {
            this.modal.classList.remove('show');
            document.body.style.overflow = '';
            setTimeout(() => {
                this.modal.remove();
                this.modal = null;
            }, 300);
        }
    }

    class CategoryManager {
        constructor() {
            this.modal = new Modal();
            this.setupEventListeners();
        }

        setupEventListeners() {
            // Add Category Button
            document.getElementById('addCategoryBtn').addEventListener('click', () => this.showAddModal());

            // Edit Buttons
            document.querySelectorAll('.edit-category').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const name = button.dataset.name;
                    const status = button.dataset.status;
                    this.showEditModal(id, name, status);
                });
            });

            // Delete Buttons
            document.querySelectorAll('.delete-category').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    this.deleteCategory(id);
                });
            });
        }

        showAddModal() {
            const content = `
            <form id="addCategoryForm">
                <div class="form-group">
                    <label for="category_name">Kategori Adı</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                </div>
                <div class="form-group">
                    <label for="status">Durum</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Pasif</option>
                    </select>
                </div>
            </form>
        `;

            const footer = `
            <button type="button" class="btn btn-secondary" id="cancelAdd">İptal</button>
            <button type="button" class="btn btn-primary" id="saveAdd">Kaydet</button>
        `;

            this.modal.create('Yeni Kategori Ekle', content, footer);

            document.getElementById('cancelAdd').addEventListener('click', () => this.modal.hide());
            document.getElementById('saveAdd').addEventListener('click', () => this.addCategory());
        }

        showEditModal(id, name, status) {
            const content = `
            <form id="editCategoryForm">
                <input type="hidden" name="id" value="${id}">
                <div class="form-group">
                    <label for="edit_category_name">Kategori Adı</label>
                    <input type="text" class="form-control" id="edit_category_name" name="category_name" value="${name}" required>
                </div>
                <div class="form-group">
                    <label for="edit_status">Durum</label>
                    <select class="form-control" id="edit_status" name="status" required>
                        <option value="active" ${status === 'active' ? 'selected' : ''}>Aktif</option>
                        <option value="inactive" ${status === 'inactive' ? 'selected' : ''}>Pasif</option>
                    </select>
                </div>
            </form>
        `;

            const footer = `
            <button type="button" class="btn btn-secondary" id="cancelEdit">İptal</button>
            <button type="button" class="btn btn-primary" id="saveEdit">Güncelle</button>
        `;

            this.modal.create('Kategori Düzenle', content, footer);

            document.getElementById('cancelEdit').addEventListener('click', () => this.modal.hide());
            document.getElementById('saveEdit').addEventListener('click', () => this.updateCategory());
        }

        async addCategory() {
            const form = document.getElementById('addCategoryForm');
            const formData = new FormData(form);
            formData.append('action', 'create');
            formData.append('_token', '<?= $csrf->getToken() ?>');

            try {
                const response = await fetch('<?= Helper::controller('categoryController') ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    location.reload();
                } else {
                    alert('Kategori eklenirken bir hata oluştu.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Bir hata oluştu.');
            }
        }

        async updateCategory() {
            const form = document.getElementById('editCategoryForm');
            const formData = new FormData(form);
            formData.append('action', 'update');
            formData.append('_token', '<?= $csrf->getToken() ?>');

            try {
                const response = await fetch('<?= Helper::controller('categoryController') ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    location.reload();
                } else {
                    alert('Kategori güncellenirken bir hata oluştu.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Bir hata oluştu.');
            }
        }

        async deleteCategory(id) {
            if (!confirm('Bu kategoriyi silmek istediğinizden emin misiniz?')) {
                return;
            }

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', id);
            formData.append('_token', '<?= $csrf->getToken() ?>');

            try {
                const response = await fetch('<?= Helper::controller('categoryController') ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert('Kategori silinirken bir hata oluştu.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Bir hata oluştu.');
            }
        }
    }

    // Initialize the category manager when the DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        new CategoryManager();
    });
</script>

<?php
require_once __DIR__ . '/../../includes/footer.php';
?>