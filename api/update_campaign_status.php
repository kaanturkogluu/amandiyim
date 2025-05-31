<?php
// Hata raporlamasını aç

require_once __DIR__ . '/../classes/Campaigns.php';
require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/CsrfToken.php';
require_once __DIR__ . '/../classes/CreditProvision.php';

// JSON yanıt için header ayarı
header('Content-Type: application/json; charset=utf-8');

// Response fonksiyonu
function sendResponse($success, $message, $data = null, $statusCode = 200)
{
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Sadece POST isteklerini kabul et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Method not allowed', null, 405);
}

try {
    // JSON verisini al
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        sendResponse(false, 'Invalid JSON data', null, 400);
    }

    // CSRF token kontrolü
    $csrf = CsrfToken::getInstance();
    if (!isset($data['_token']) || !$csrf->validateToken($data['_token'])) {
        sendResponse(false, 'Invalid security token', null, 400);
    }

    // Gerekli alanların kontrolü
    if (!isset($data['campaign_id']) || !isset($data['status'])) {
        sendResponse(false, 'Missing required fields', null, 400);
    }

    // Session kontrolü
    $session = Session::getInstance();
    if (!$session->isAdmin()) {
        sendResponse(false, 'Unauthorized access', null, 401);
    }


    // Kampanya nesnesini oluştur
    $campaign = new Campaigns();


    // Kampanyanın varlığını kontrol et
    $campaignData = $campaign->find($data['campaign_id']);
    if (!$campaignData) {
        sendResponse(false, 'Campaign not found', null, 404);
    }

    // Kampanya durumunu güncelle
    $updateData = [
        'campaign_status' => $data['status'],
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $result = $campaign->update($data['campaign_id'], $updateData);


    if ($result) {
        $provision = new CreditProvision();

        $provisionId = $provision->findProvisionId($data['campaign_id']);
        if ($provisionId) {

            $update = $provision->update($provisionId['id'], ['proccess_statu' => 'processed']);

            if ($update) {

                sendResponse(true, 'Campaign status updated successfully', [
                    'campaign_id' => $data['campaign_id'],
                    'new_status' => $data['status']
                ]);
            }

        }

        sendResponse(true, 'Campaign status updated successfully but provision cant updated', [
            'campaign_id' => $data['campaign_id'],
            'new_status' => $data['status']
        ]);



    } else {
        sendResponse(false, 'Failed to update campaign status', null, 400);
    }

} catch (Exception $e) {
    sendResponse(false, 'Error: ' . $e->getMessage(), null, 500);
} catch (Error $e) {
    sendResponse(false, 'Internal server error: ' . $e->getMessage(), null, 500);
}