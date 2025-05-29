<?php

header('Content-Type: application/json');
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/CsrfToken.php";
require_once __DIR__ . "/../classes/StockPhoto.php";
require_once __DIR__ . "/../classes/Helper.php";
require_once __DIR__ . "/../classes/StoreCategories.php";
require_once __DIR__ . "/../classes/FileUploader.php";

$token = CsrfToken::getInstance();
$session = Session::getInstance();
$stockPhotos = new StockPhoto();
$fileUploader = new FileUploader();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Geçersiz İstek.']);
    exit;
}

$requestToken = $_POST['_token'] ?? '';
$action = $_POST['action'] ?? '';

if (!$token->validateToken($requestToken)) {
    echo json_encode(['success' => false, 'message' => 'Geçersiz Token İsteği']);
    exit;
}

$response = ['success' => false, 'data' => null, 'message' => 'Geçersiz Yanıt'];

// Resim sıkıştırma fonksiyonu

try {
    switch ($action) {
        case 'create':
            if (!isset($_POST['title']) || !isset($_POST['main_category']) || !isset($_POST['sub_category']) || !isset($_FILES['photo'])) {
                throw new Exception('Gerekli alanlar eksik');
            }

            $title = $_POST['title'];
            $mainCategory = $_POST['main_category'];
            $subCategory = $_POST['sub_category'];
            $subSubCategory = $_POST['sub_sub_category'] ?? '0';
            $photo = $_FILES['photo'];

            // Ana kategori kontrolü
            $storeCategory = new StoreCategories();
            if (!$storeCategory->find($mainCategory)) {
                throw new Exception('Geçersiz ana kategori');
            }

            // Fotoğrafı yükle
            $uploadResult = $fileUploader->uploadPhoto($photo, 'stock_photos');
            
            if (!is_string($uploadResult)) {
                throw new Exception($uploadResult); // Hata mesajını fırlat
            }

            // Yüklenen fotoğrafı sıkıştır
            $uploadDir = __DIR__ . '/../uploads/images/stock_photos/';
            $sourcePath = $uploadDir . $uploadResult;
            $compressedPath = $uploadDir . 'compressed_' . $uploadResult;
            
            if (!$fileUploader->compressImage($sourcePath, $compressedPath)) {
                // Sıkıştırma başarısız olursa orijinal dosyayı sil
                unlink($sourcePath);
                throw new Exception('Resim sıkıştırılırken bir hata oluştu');
            }

            // Orijinal dosyayı sil ve sıkıştırılmış dosyayı yeniden adlandır
            unlink($sourcePath);
            rename($compressedPath, $sourcePath);

            // Veritabanına kaydet
            $data = [
                'stock_photo_title' => $title,
                'stock_photo_store_category' => $mainCategory,
                'stock_photo_sub_category' => $subCategory,
                'stock_photo_sub_sub_category' => $subSubCategory,
                'url' => $uploadResult,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $stockPhotos->create($data);

            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Fotoğraf başarıyla eklendi';
                $response['data'] = $result;
            } else {
                throw new Exception('Fotoğraf eklenirken bir hata oluştu');
            }
            break;

        case 'update':
            if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['main_category']) || !isset($_POST['sub_category'])) {
                throw new Exception('Gerekli alanlar eksik');
            }

            // Ana kategori kontrolü
            $storeCategory = new StoreCategories();
            if (!$storeCategory->find($_POST['main_category'])) {
                throw new Exception('Geçersiz ana kategori');
            }

            $data = [
                'id' => $_POST['id'],
                'stock_photo_title' => $_POST['title'],
                'stock_photo_store_category' => $_POST['main_category'],
                'stock_photo_sub_category' => $_POST['sub_category'],
                'stock_photo_sub_sub_category' => $_POST['sub_sub_category'] ?? '0',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Eğer yeni bir resim yüklendiyse
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                // Eski resmi sil
                $oldPhoto = $stockPhotos->find($_POST['id']);
                if ($oldPhoto) {
                    $fileUploader->deletePhoto($oldPhoto['url'], 'images/stock_photos');
                }

                // Yeni resmi yükle
                $uploadResult = $fileUploader->uploadPhoto($_FILES['photo'], 'stock_photos');
                
                if (!is_string($uploadResult)) {
                    throw new Exception($uploadResult);
                }

                // Yüklenen fotoğrafı sıkıştır
                $uploadDir = __DIR__ . '/../uploads/images/stock_photos/';
                $sourcePath = $uploadDir . $uploadResult;
                $compressedPath = $uploadDir . 'compressed_' . $uploadResult;
                
                if (!$fileUploader->compressImage($sourcePath, $compressedPath)) {
                    unlink($sourcePath);
                    throw new Exception('Resim sıkıştırılırken bir hata oluştu');
                }

                // Orijinal dosyayı sil ve sıkıştırılmış dosyayı yeniden adlandır
                unlink($sourcePath);
                rename($compressedPath, $sourcePath);

                $data['url'] = $uploadResult;
            }

            $result = $stockPhotos->update($data);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Fotoğraf başarıyla güncellendi';
                $response['data'] = $result;
            } else {
                throw new Exception('Fotoğraf güncellenirken bir hata oluştu');
            }
            break;

        case 'delete':
            if (!isset($_POST['id'])) {
                throw new Exception('ID parametresi eksik');
            }

            // Önce resmi sil
            $photo = $stockPhotos->getById($_POST['id']);
            if ($photo) {
                $fileUploader->deletePhoto($photo['url'], 'images/stock_photos');
            }

            $result = $stockPhotos->delete($_POST['id']);
            if ($result) {
                $response['success'] = true;
                $response['message'] = 'Fotoğraf başarıyla silindi';
            } else {
                throw new Exception('Fotoğraf silinirken bir hata oluştu');
            }
            break;

        default:
            throw new Exception('Geçersiz işlem');
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;