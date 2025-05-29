<?php

header('Content-Type: application/json');
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/CsrfToken.php";
require_once __DIR__ . "/../classes/CampaignsSubCategories.php";
require_once __DIR__ . "/../classes/StockPhoto.php";
require_once __DIR__ . "/../classes/Helper.php";

$token = CsrfToken::getInstance();
$session = Session::getInstance();
$subcategories = new CampaignsSubCategories();
$stockPhotos = new StockPhoto();

if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SERVER['REQUEST_URI'])) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz İstek.']);
    exit;
}

$requestToken = $_GET['token'] ?? $_POST['token'] ?? '';
$action = $_GET['action'] ?? $_POST['action'] ?? '';

if (!$token->validateToken($requestToken)) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz Token İsteği']);
    exit;
}

$response = ['success' => false, 'data' => null, 'message' => 'Geçersiz Yanıt'];

switch ($action) {
    case 'getSubCategories':
        if (!isset($_GET['main_id'])) {
            $response['message'] = 'Ana kategori ID\'si gerekli';
            break;
        }

        $mainId = $_GET['main_id'];
        $data = $subcategories->getSelectedColumns(
            ['id', 'sub_category_name', 'sub_description'],
            ['store_categories_id' => $mainId]
        );

        if ($data) {
            $response['success'] = true;
            $response['data'] = $data;
            $response['message'] = 'Alt kategoriler başarıyla getirildi';
        } else {
            $response['message'] = 'Alt kategori bulunamadı';
        }
        break;

    case 'getPhotos':
        $mainId = $_GET['main_id'] ?? null;
        $subId = $_GET['sub_id'] ?? null;
        $subSubId = $_GET['sub_sub_id'] ?? null;

        $conditions = [];
        if ($mainId)
            $conditions['stock_photo_store_category'] = $mainId;
        if ($subId)
            $conditions['stock_photo_sub_category'] = $subId;
        if ($subSubId && $subSubId !== '0')
            $conditions['stock_photo_sub_sub_category'] = $subSubId;

        $data = $stockPhotos->getSelectedColumns(
            ['id', 'stock_photo_title', 'url', 'stock_photo_store_category', 'stock_photo_sub_category', 'stock_photo_sub_sub_category'],
            $conditions
        );

        if ($data) {
            // Kategori bilgilerini ekle
            foreach ($data as &$photo) {
                if ($photo['stock_photo_store_category']) {
                    $mainCategory = $subcategories->find($photo['stock_photo_store_category']);
                    $photo['category_name'] = $mainCategory['category_name'] ?? '';
                }
                if ($photo['stock_photo_sub_category']) {
                    $subCategory = $subcategories->find($photo['stock_photo_sub_category']);
                    $photo['sub_category_name'] = $subCategory['sub_category_name'] ?? '';
                }
                if ($photo['stock_photo_sub_category'] && $photo['stock_photo_sub_sub_category'] !== '0') {
                    $subSubCategory = $subcategories->find($photo['stock_photo_sub_sub_category']);
                    $photo['sub_sub_category_name'] = $subSubCategory['sub_sub_name'] ?? '';
                }
            }

            $response['success'] = true;
            $response['data'] = $data;
            $response['message'] = 'Fotoğraflar başarıyla getirildi';
        } else {
            $response['message'] = 'Fotoğraf bulunamadı';
        }
        break;

    case 'deletePhoto':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $response['message'] = 'Geçersiz istek metodu';
            break;
        }

        if (!isset($_POST['id'])) {
            $response['message'] = 'Fotoğraf ID\'si gerekli';
            break;
        }

        $photoId = $_POST['id'];
        
        // Önce fotoğrafı bul
        $photo = $stockPhotos->find($photoId);
        if (!$photo) {
            $response['message'] = 'Fotoğraf bulunamadı';
            break;
        }

        // Dosyayı sil
        $uploadDir = __DIR__ . '/../uploads/images/stock_photos/';
        if (file_exists($uploadDir . $photo['url'])) {
            unlink($uploadDir . $photo['url']);
        }

        // Veritabanından sil
        $result = $stockPhotos->delete($photoId);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Fotoğraf başarıyla silindi';
        } else {
            $response['message'] = 'Fotoğraf silinirken bir hata oluştu';
        }
        break;

    default:
        $response['message'] = 'Geçersiz işlem';
        break;
}

echo json_encode($response);
exit;

