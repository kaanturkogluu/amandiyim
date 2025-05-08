<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/CsrfToken.php";
require_once __DIR__ . "/../classes/Stores.php";



$store = new Stores();
$token = CsrfToken::getInstance();
$session = Session::getInstance();
// Örnek olarak checkuserUpdateTime.php dosyası ya da bir route/controller içinde

if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_SERVER['REQUEST_URI'])) {

    echo json_encode(['canUpdate' => false, 'error' => 'CSRF token geçersiz.']);
    exit;
}


// CSRF kontrolü (manuel yapılıyorsa):
$csrfToken = $_GET['_token'] ?? ''; // GET için
// veya
// $data = json_decode(file_get_contents('php://input'), true);
// $csrfToken = $data['_token'] ?? ''; // POST için

if (!$token->validateToken($csrfToken)) {

    echo json_encode(['canUpdate' => false, 'error' => 'CSRF token geçersiz.']);
    exit;
}

$userid = $session->getUserId();

$storedata = $store->find($userid);

if ($storedata) {
    if ($storedata['updated_at']) {
        $lastUpdate = new DateTime($storedata['updated_at']);
        $now = new DateTime();
        $diff = $now->diff($lastUpdate);

        if ($diff->days >= 7) {
           
            echo json_encode(['canUpdate' => true]);
            exit;

            // Son güncellemeden 7 gün veya daha fazla geçmiş
            // Bu blok çalışır
        }
    }

}

echo json_encode(['canUpdate' => false]);
exit;
