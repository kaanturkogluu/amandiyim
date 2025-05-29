<?php
require_once __DIR__ . '/../classes/CampaignsSubCategories.php';

header('Content-Type: application/json');

$subcategories = new CampaignsSubCategories();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'create';

        switch ($action) {
            case 'create':
                if (!isset($_POST['sub_category_name'])) {
                    throw new Exception('Alt kategori adı gerekli');
                }

                $data = [
                    'sub_category_name' => $_POST['sub_category_name'],
                    'sub_description' => $_POST['sub_description'] ?? '',
                    'store_categories_id' => $_POST['store_categories_id'] ?? null
                ];

                if ($subcategories->create($data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Alt kategori başarıyla eklendi',
                        'data' => $data
                    ]);
                } else {
                    throw new Exception('Alt kategori eklenirken bir hata oluştu');
                }
                break;

            case 'update':
                if (!isset($_POST['id'])) {
                    throw new Exception('ID parametresi gerekli');
                }

                if (!isset($_POST['sub_category_name'])) {
                    throw new Exception('Alt kategori adı gerekli');
                }

                $data = [
                    'sub_category_name' => $_POST['sub_category_name'],
                    'sub_description' => $_POST['sub_description'] ?? ''
                ];

                if ($subcategories->update($_POST['id'], $data)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Alt kategori başarıyla güncellendi',
                        'data' => array_merge(['id' => $_POST['id']], $data)
                    ]);
                } else {
                    throw new Exception('Alt kategori güncellenirken bir hata oluştu');
                }
                break;

            case 'delete':
                if (!isset($_POST['id'])) {
                    throw new Exception('ID parametresi gerekli');
                }

                if ($subcategories->delete($_POST['id'])) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Alt kategori başarıyla silindi',
                        'id' => $_POST['id']
                    ]);
                } else {
                    throw new Exception('Alt kategori silinirken bir hata oluştu');
                }
                break;

            default:
                throw new Exception('Geçersiz işlem');
        }
    } else {
        throw new Exception('Geçersiz istek metodu');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}