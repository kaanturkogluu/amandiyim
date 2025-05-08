<?php

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/Stores.php';

header('Content-Type: application/json');

$session = Session::getInstance();
$token = CsrfToken::getInstance();
$stores = new Stores();

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}
 

// JSON verisini al
$data = json_decode(file_get_contents('php://input'), true);
if (!$token->validateToken($data['_token'])) {

    echo json_encode(['success' => false, 'message' => 'Update failed']);
    exit;
}

if (!isset($data['action']) || $data['action'] !== 'complete_onboarding') {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

try {
    // Mağaza ID'sini al
    $storeId = $session->get('user')['id'];

    // Mağazanın is_new_store durumunu güncelle
    $nd = ['updated_by_store_info' => 1];

    $result = $stores->update($storeId, $nd);




    if ($result) {
        // Session'daki kullanıcı bilgilerini güncelle

        $_SESSION['user']['updated_by_store_info'] = 1;


        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
}
?>