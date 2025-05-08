<?php
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../../classes/Session.php';

header('Content-Type: application/json');

$session = Session::getInstance();
$db = Database::getInstance();

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// JSON verisini al
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['action']) || $data['action'] !== 'complete_onboarding') {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

try {
    // Mağaza ID'sini al
    $storeId = $session->get('user')['id'];
    
    // Mağazanın is_new_store durumunu güncelle
    $result = $db->sorguCalistir(
        "UPDATE stores SET is_new_store = 0 WHERE id = ?",
        [$storeId]
    );

    if ($result) {
        // Session'daki kullanıcı bilgilerini güncelle
        $user = $session->get('user');
        $user['is_new_store'] = 0;
        $session->set('user', $user);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred']);
} 