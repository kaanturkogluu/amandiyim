<?php
require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . '/../classes/Stores.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/FileUploader.php';

date_default_timezone_set('Europe/Istanbul');


// Session ve CSRF kontrolü için gerekli sınıfları başlat
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();
$stores = new Stores();
$fileUploader = new FileUploader();

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
        case 'update':
            try {
                $storeId = (int) $_POST['update_store_id'];

                if (!$session->checkSendedUserId($storeId)) {
                    $session->flash('error', 'Kıpraşma , Banlanırsın');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                }


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
                $newData['updated_at'] = date("Y-m-d H:i:s");


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
                    $session->flash('success', 'Mağaza bilgileri güncellendi.<br>  Değişikliklerin Uygulanması İçin <b>Lütfen Çıkış Yapıp </b>Tekrar Oturum Açınız');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                } else {
                    $session->flash('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                }

            } catch (Exception $e) {
                $session->flash('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
                header("Location: " . Helper::storePanelView('settings'));


            }
            break;

        case 'security':
            try {
                $storeId = (int) $_POST['store_id'];

                if (!$session->checkSendedUserId($storeId)) {
                    $session->flash('error', 'Kıpraşma , Banlanırsın');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                }
                $storeData = $stores->find($storeId);
                $dbsifresi = $storeData['store_owner_password'];



                $inputeskisifre = $_POST['current_password'];


                $yenisifre = password_hash($_POST['new_password_confirm'], PASSWORD_DEFAULT);



                // girilen şifre ile mevcut şifre aynı değilse
                if (
                    !password_verify($inputeskisifre, $dbsifresi)
                ) {
                    $session->flash('error', 'Eski Şifreler Uyuşmuyor');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                }
                //eski şifre ile yeni şifre aynı ise 
                if (password_verify($yenisifre, $dbsifresi)) {
                    $session->flash('error', 'Yeni Şifre Eskisi İle Aynı Olamaz ');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;
                }

                //sifre güncelleme 

                $data = [
                    'store_owner_password' => $yenisifre
                ];
                $result = $stores->update($storeId, $data);
                if ($result) {
                    $session->flash('success', 'Şifreniz Başarıyla Değiştrildi');
                    header("Location: " . Helper::storePanelView('settings'));
                    exit;


                }
                $session->flash('error', 'İşlemi Şuanda Gerçekleştiremiyoruz');
                header("Location: " . Helper::storePanelView('settings'));
                exit;

            } catch (PDOException $e) {
                $session->flash('error', 'Bir hata oluştu, lütfen tekrar deneyin.');
                header("Location: " . Helper::storePanelView('settings'));


            }
            break;

    }

}