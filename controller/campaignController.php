<?php


require_once __DIR__ . '/../classes/Campaigns.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . '/../classes/FileUploader.php';
require_once __DIR__ . '/../classes/Categories.php';
$campaingCategoriesObj = new Categories();
$helper = Helper::getInstance();
$fileUploader = new FileUploader();
$session = Session::getInstance();
$csrfToken = CsrfToken::getInstance();
$campaign = new Campaigns();
// Yalnızca mağaza girişi yapılmışsa erişime izin ver
if (!$session->isStore()) {

    $session->kickOut();
    exit;
}

// POST isteği kontrolü
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$csrfToken->validatePostToken()) {
        echo $_SESSION['_token'];
        echo "Token Geçersiz";

        $session->kickOut('CSRF token geçersiz!');
        exit;
    }
    $action = $_POST['action'] ?? 'add';


    $storeId = $_SESSION['user']['id'];


    switch ($action) {
        case 'add':


            $campignsubid = Helper::post('campaing_sub_id');
            if (!is_numeric($campignsubid)) {
                $session->flash('error', 'Kampanya Talebi oluşturulamadı! Veriler üzerinde Oynama Yapmayınız');
                Helper::redirect(Helper::storePanelView('campaings/campaigns'));
                exit;
            }

            $campaignsubsubid = Helper::post('campaing_sub_sub_id') ?? 0;
            $imgUrl = null;

            // 1. Görsel kaynağına göre işlem
            if (isset($_POST['selected_stock_photo']) && empty($_POST['campaign_image'])) {
                // Stok görsel seçilmiş
                $stockPhotoUrl = Helper::post('selected_stock_photo');
                if (empty($stockPhotoUrl)) {
                    $session->flash('error', 'Stok fotoğraf seçimi geçersiz!');
                    Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
                    exit;
                }
                $imgUrl = 'stock-' . $stockPhotoUrl;

            } elseif (isset($_FILES['campaign_image']) && $_FILES['campaign_image']['error'] === UPLOAD_ERR_OK) {
                try {
                    // Dosya türü kontrolü
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($_FILES['campaign_image']['type'], $allowedTypes)) {
                        throw new Exception('Geçersiz dosya türü! Sadece JPEG, PNG, GIF ve WebP formatları desteklenmektedir.');
                    }

                    // Dosya boyutu kontrolü (5MB)
                    if ($_FILES['campaign_image']['size'] > 5 * 1024 * 1024) {
                        throw new Exception('Dosya boyutu çok büyük! Maksimum 5MB yükleyebilirsiniz.');
                    }

                    // Önce dosyayı yükle
                    $uploadResult = $fileUploader->uploadPhoto($_FILES['campaign_image'], 'campaign_images');
                    
                    if (!is_string($uploadResult)) {
                        throw new Exception('Görsel yüklenemedi: ' . $uploadResult);
                    }

                    // Yüklenen dosyanın tam yolunu al
                    $sourcePath = __DIR__ . '/../uploads/images/campaign_images/' . $uploadResult;
                    $destinationPath = __DIR__ . '/../uploads/images/campaign_images/compressed_' . $uploadResult;

                    // Dosyayı sıkıştır
                    $compressedResult = $fileUploader->compressImage($sourcePath, $destinationPath, 80);

                    if ($compressedResult) {
                        // Orijinal dosyayı sil
                        if (file_exists($sourcePath)) {
                            unlink($sourcePath);
                        }
                        // Sıkıştırılmış dosyanın adını al
                        $imgUrl = 'upload-compressed_' . $uploadResult;
                    } else {
                        // Sıkıştırma başarısız olursa orijinal dosyayı kullan
                        $imgUrl = 'upload-' . $uploadResult;
                    }

                } catch (Exception $e) {
                    $session->flash('error', 'Görsel yüklenirken bir hata oluştu: ' . $e->getMessage());
                    Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
                    exit;
                }
            } else {
                $session->flash('error', 'Görsel kaynağı belirtilmedi! Lütfen bir görsel seçin.');
                Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
                exit;
            }

            // 2. Kampanya koşullarını JSON'a çevir
            $jsonConditions = json_encode(Helper::post('conditions'));

            // 3. Verileri oluştur
            $data = [
                'store_id' => $storeId,
                'campaign_title' => Helper::post('campaign_title'),
                'campaign_sub_description' => Helper::post('campaign_description'),
                'campaign_details' => Helper::post('campaign_details'),
                'campaign_start_time' => Helper::post('campaign_start_date'),
                'campaign_end_time' => Helper::post('campaign_end_date'),

                'campaign_image' => $imgUrl,
                'campaign_type' => Helper::post('campaign_type'),
                'campaign_disscount_off' => Helper::post('campaign_discount'),
                'campaign_min_purchase' => Helper::post('campaign_min_purchase'),
                'campaign_conditions' => $jsonConditions,
            ];
            //kampayna kategorilerine göre kayıt yapıcaz




            // 4. Kaydet
            $result = $campaign->create($data);


            if ($result) {

                $kategoriekleme = $campaingCategoriesObj->create([
                    'campaign_id' => $result,
                    'campaign_store_category_id' => $_SESSION['user']['store_category'],
                    'campaign_sub_category_id' => $campignsubid,
                    'campaign_sub_sub_category_id' => $campaignsubsubid
                ]);
                $session->flash('success', 'Kampanya Talebi  oluşturuldu. Talepbiniz onaylandıktan sonra kampanyanız aktif olacaktır.');
                Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
            } else {
                $session->flash('error', 'Kampanya Talebi oluşturulamadı!');
                Helper::redirect(Helper::storePanelView('campaings/campaigns'));
            }
            break;

       case 'update_status':
        if (!isset($_POST['id']) || !isset($_POST['status'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Eksik parametreler'
            ]);
            exit;
        }

        try {
            $campaigns = new Campaigns();
            $result = $campaigns->update($_POST['id'], ['campaing_status' => $_POST['status']]);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Kampanya durumu başarıyla güncellendi'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Kampanya durumu güncellenirken bir hata oluştu'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ]);
        }
        break;
        
        default:
            $session->flash('error', 'Geçersiz işlem!');
            Helper::redirect('panel/store/pages/campaigns/list.php');
            break;
    }
}

/**
 * Kampanya ekleme işlemini yönetir
 */


?>