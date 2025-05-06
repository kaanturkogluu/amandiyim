<?php

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] != "GET") {
    $response['status'] = false;
    $response['message'] = "Geçersiz istek";
    $response['data'] = [];
    echo json_encode($response);
    exit;
}


try {
    $response = [
        'status' => false,
        'message' => '',
        'data' => []
    ];
    // Include işlemleri try-catch bloğuna alındı
    require_once __DIR__ . '/../classes/Database.php';
    require_once __DIR__ . '/../classes/StockPhoto.php';
    require_once __DIR__ . '/../classes/Session.php';
    require_once __DIR__ . '/../classes/CsrfToken.php';



    $db = Database::getInstance();
    $session = Session::getInstance();
    $csrf = CsrfToken::getInstance();

    /**Token Doğrulama */
    if (!$csrf->validateToken($_GET['_token'])) {
        $response['status'] = false;
        $response['message'] = "Geçersiz CSRF token";
        $response['data'] = [];
        echo json_encode($response);
        exit;
    }   
    //Oturum  Acılmamıs İse 
    if (!$session->isLoggedIn() || !$session->isStore()) {
        $response['status'] = false;
        $response['message'] = "Lütfen giriş yapınız";
        $response['data'] = [];
        echo json_encode($response);
        exit;
    }

    $stockPhoto = new StockPhoto();
    $photos = $stockPhoto->getStockPhotos($_SESSION['user']['store_category']);

    if ($photos) {
        $data = [];
        foreach ($photos as $photo) {
            $data[] = [
                'id' => $photo['id'],
                'url' => $photo['url'],
                'title' => $photo['stock_photo_title']
            ];
        }
        $response['status'] = true;
        $response['message'] = "Stok fotoğrafları başarıyla alındı";
        $response['data'] = $data;

    } else {
        // Örnek fotoğraf verileri
        $response['status'] = false;
        $response['message'] = "Stok fotoğrafları bulunamadı";
        $response['data'] = [];
    }



} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    echo json_encode($response);
    exit;
}











?>