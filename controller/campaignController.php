<?php


require_once __DIR__ . '/../classes/Campaigns.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Helper.php';
require_once __DIR__ . '/../classes/FileUploader.php';
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

             
        
            $imgUrl = null;
        
            // 1. Görsel kaynağına göre işlem
            if (Helper::post('image_source') == 'stock') {
                // Stok görsel seçilmiş
                $imgUrl = 'stock-' . Helper::post('stock_photo_url');
        
            } elseif (Helper::post('image_source') == 'upload') {
                // Yüklenen görsel base64 olarak gelmişse
                $base64 = Helper::post('image_base64');
        
                if (!empty($base64) && preg_match('/^data:image\/webp;base64,/', $base64)) {
                    $base64 = substr($base64, strpos($base64, ',') + 1);
                    $decodedData = base64_decode($base64);
                
                    // Dosyayı kaydet
                    $filename = uniqid('img_') . '.webp';
                    $filePath = __DIR__ . '/../uploads/images/campaign_images/' . $filename;
                
                    // Dosyayı belirtilen dizine kaydet
                    file_put_contents($filePath, $decodedData);
                
                    // Veritabanına kaydedilecek URL
                    // Dosya yolunu sadece dosya adıyla değiştir
                    $imgUrl = 'upload-' . $filename;  // Bu URL veritabanına kaydedilecek
                }
                 else {
                    $session->flash('error', 'Görsel yüklenemedi! Tekrar Deneyiniz.');
                    Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
               
                }
            } else {
                $session->flash('error', 'Görsel Kaynağı Tanımsız!, Tekrar Deneyiniz.');
                Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
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
        
            // 4. Kaydet
            $result = $campaign->create($data);
        
          if($result){
            $session->flash('success', 'Kampanya Talebi  oluşturuldu. Talepbiniz onaylandıktan sonra kampanyanız aktif olacaktır.');
            Helper::redirect(Helper::storePanelView('campaigns/campaigns'));
          }else{
            $session->flash('error', 'Kampanya Talebi oluşturulamadı!');
            Helper::redirect(Helper::storePanelView('campaings/campaigns'));
          }
            break;
        
        case 'edit':
            handleEditCampaign();
            break;
        case 'delete':
            handleDeleteCampaign();
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
