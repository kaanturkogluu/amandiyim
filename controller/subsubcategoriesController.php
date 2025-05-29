<?php
require_once __DIR__ . '/../classes/CampaignsSubSubCategories.php';

header('Content-Type: application/json');

$subsubcategories = new CampaignsSubSubCategories();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getBySubId') {
        if (!isset($_GET['sub_id'])) {
            throw new Exception('Alt kategori ID\'si gerekli');
        }

        $data = $subsubcategories->getSelectedColumns(
            ['id', 'sub_sub_name', 'sub_sub_description'],
            ['campaing_sub_category_id' => $_GET['sub_id']]
        );

        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? 'create';

        switch ($action) {
            case 'create':
                if (!isset($_POST['sub_sub_category_name'])) {
                    throw new Exception('Alt kategori adı gerekli');
                }

                $data = [
                    'sub_sub_name' => $_POST['sub_sub_category_name'],
                    'sub_sub_description' => $_POST['sub_sub_description'] ?? '',
                    'campaing_sub_category_id' => $_POST['sub_categories_id'] ?? null
                ];
                
                if ($subsubcategories->create($data)) {
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

                if (!isset($_POST['sub_sub_category_name'])) {
                    throw new Exception('Alt kategori adı gerekli');
                }

                $data = [
                    'sub_sub_name' => $_POST['sub_sub_category_name'],
                    'sub_sub_description' => $_POST['sub_sub_description'] ?? ''
                ];

                if ($subsubcategories->update($_POST['id'], $data)) {
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

                if ($subsubcategories->delete($_POST['id'])) {
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