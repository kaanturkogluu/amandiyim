<?php
require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . '/../classes/Stores.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/FileUploader.php';

// Session ve CSRF kontrolü için gerekli sınıfları başlat
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();
$stores = new Stores();
$fileUploader = new FileUploader();

// Yanıt formatı
$response = [
    'success' => false,
    'message' => '',
    'data' => null
];



// POST isteklerini kontrol et
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // CSRF token kontrolü
    if (!$csrf->validateToken($_POST['_token'])) {
        $response['message'] = 'Güvenlik doğrulaması başarısız!';
        $response['data'] = $_POST;
        echo json_encode($response);
        exit;
    }

    // İşlem tipini kontrol et
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'add':
            // Mağaza ekleme işlemi
            try {
                // Gerekli alanları kontrol et


                // Dosya yüklemeleri için kontrol
                $storeData = $_POST;

                unset($storeData['action']);

                unset($storeData['_token']);
                $password = $storeData['store_owner_password'];
                $storeData['store_owner_password'] = password_hash($password, PASSWORD_DEFAULT);
                $logoResult = $fileUploader->uploadPhoto($_FILES['store_logo'], 'stores_logos');
                // Logo yükleme
                $storeData['store_logo'] = $logoResult;
                // Ana görsel yükleme

                $imagePath = $fileUploader->uploadPhoto($_FILES['store_main_image'], 'store_images');
                $storeData['store_main_image'] = $imagePath;




                // Mağaza ekle
                $result = $stores->create($storeData);



                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Mağaza başarıyla eklendi.';
                    $response['data'] = $result;
                } else {
                    throw new Exception("Mağaza eklenirken bir hata oluştu!");
                }

            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
            break;

        case 'update':
            try {




                $storeId = (int) $_POST['update_store_id'];
                $storedata = $stores->find($storeId);
                $updateData = $_POST;
                unset($updateData['action']);
                unset($updateData['_token']);
                unset($updateData['update_store_id']);
                $newData = [];

                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'update_') === 0) {
                        // "update_" kelimesini çıkar
                        $newKey = substr($key, strlen('update_'));
                        $newData[$newKey] = $value;
                    }
                }

                unset($newData['store_id']);


                if (isset($_FILES['update_store_logo']) && $_FILES['update_store_logo']['error'] === UPLOAD_ERR_OK) {
                    // Yeni logo yüklendi
                    $logoResult = $fileUploader->uploadPhoto($_FILES['update_store_logo'], 'stores_logos');

                    // Logo yükleme
                    $newData['store_logo'] = $logoResult;
                    //Eski resmi sil

                    if ($storedata['store_logo'] != 'store-default-icon.jpg') {

                        $fileUploader->deletePhoto($storedata['store_logo'], 'images/stores_logos');
                    }
                }
                if (isset($_FILES['update_store_main_image']) && $_FILES['update_store_main_image']['error'] === UPLOAD_ERR_OK) {
                    // Yeni ana görsel yüklendi
                    $imagePath = $fileUploader->uploadPhoto($_FILES['update_store_main_image'], 'store_images');
                    $newData['store_main_image'] = $imagePath;
                    //Eski resmi sil
                    if ($storedata['store_logo'] != 'store-default-image.jpg') {

                        $fileUploader->deletePhoto($storedata['store_main_image'], 'images/store_images');
                    }
                }


                $response['data'] = $newData;


                $result = $stores->update($storeId, $newData);


                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Mağaza başarıyla güncellendi.';
                    $response['data'] = $result;
                } else {
                    throw new Exception("Mağaza güncellenirken bir hata oluştu!");
                }

            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
            break;

        case 'delete':
            try {

                // Mağaza ID kontrolü
                if (!isset($_POST['store_id'])) {
                    throw new Exception("Mağaza ID'si gereklidir!");
                }

                $storeId = (int) $_POST['store_id'];

                $storedata = $stores->find($storeId);
                $storeLogo = $storedata['store_logo'];
                $storemainimage = $storedata['store_main_image'];

                if($storeLogo !='store-default-icon.jpg'){

                    $fileUploader->deletePhoto($storeLogo, 'images/stores_logos');
                }
                if($storemainimage != 'store-default-image.jpg'){

                    $fileUploader->deletePhoto($storemainimage, 'images/store_images');
                }


                // Mağazayı sil
                $result = $stores->delete($storeId);

                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Mağaza başarıyla silindi.';
                } else {
                    throw new Exception("Mağaza silinirken bir hata oluştu!");
                }

            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
            break;

        case 'change_status':
            try {
                // Gerekli alan kontrolü
                if (!isset($_POST['id']) || !isset($_POST['status'])) {
                    throw new Exception("Mağaza ID ve yeni durum gereklidir!");
                }

                $storeId = (int) $_POST['id'];
                $newStatus = $_POST['status'];

                // Durumu güncelle
                $result = $stores->updateStoreStatus($storeId, $newStatus);

                if ($result) {
                    $response['success'] = true;
                    $response['message'] = 'Mağaza durumu güncellendi.';
                } else {
                    throw new Exception("Mağaza durumu güncellenirken bir hata oluştu!");
                }

            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
            break;

        case 'getData':
            try {

                // Mağaza ID kontrolü
                if (!isset($_POST['store_id'])) {
                    throw new Exception("Mağaza ID'si gereklidir!");
                }

                $storeId = (int) $_POST['store_id'];

                $storedata = $stores->find($storeId);





                if ($storedata) {
                    $response['success'] = true;
                    $response['data'] = $storedata;
                } else {
                    throw new Exception("Veriler Alınırken bir hata oluştu!");
                }

            } catch (Exception $e) {
                $response['message'] = $e->getMessage();
            }
            break;
        default:
            $response['message'] = 'Geçersiz işlem!';
            break;
    }

} else {
    $response['message'] = 'Geçersiz istek metodu!';
}


// JSON yanıtını gönder
header('Content-Type: application/json');
echo json_encode($response);


