<?php
 
require_once __DIR__. '/../classes/Session.php';
require_once __DIR__. '/../classes/CsrfToken.php';
require_once __DIR__. '/../classes/StockPhoto.php';
require_once __DIR__. '/../classes/Helper.php';

// JSON yanıt için header ayarla
header('Content-Type: application/json');

// Session ve CSRF token kontrolü
$session = Session::getInstance();
$csrf = CsrfToken::getInstance();

// POST isteği kontrolü
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Geçersiz istek metodu'
    ]);
    exit;
}

// Token kontrolü
if (!isset($_POST['token']) || !$csrf->validateToken($_POST['token'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Geçersiz token'
    ]);
    exit;
}

// Action kontrolü
if (!isset($_POST['action'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Action parametresi gerekli'
    ]);
    exit;
}

// StockPhoto sınıfını başlat
$stockPhotos = new StockPhoto();

// Action'a göre işlem yap
switch ($_POST['action']) {
    case 'getPhotos':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['sub_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Alt kategori ID\'si gerekli'
            ]);
            exit;
        }

        $subId = $_POST['sub_id'];
        $subSubId = isset($_POST['sub_sub_id']) ? $_POST['sub_sub_id'] : '0';

        try {
            // Fotoğrafları getir
            $photos = $stockPhotos->getStockPhotos($subId, $subSubId);

            echo json_encode([
                'success' => true,
                'data' => $photos
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Fotoğraflar getirilirken bir hata oluştu: ' . $e->getMessage()
            ]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Geçersiz action'
        ]);
        break;
}











?>