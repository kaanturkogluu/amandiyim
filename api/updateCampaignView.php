<?php
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/CsrfToken.php";
require_once __DIR__ . "/../classes/Session.php";
require_once __DIR__ . "/../classes/FileJobQueue.php";
$filejob= new FileJobQueue();
$token = CsrfToken::getInstance();
$session = Session::getInstance();

$response = ['success' => false, 'message' => ''];


// JSON body'den veri al
if ($_SERVER['REQUEST_METHOD'] === 'POST' && strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
    $rawData = file_get_contents('php://input');
    $data = json_decode($rawData, true);
} else {
    $data = $_POST;
}

if (!$token->validateToken($data['_token'])) {
    $response['message'] = 'Geçersiz Token';
} elseif ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Geçersiz İstek';
} else {
    // Gelen verileri response'a ekle


    // $cview->updateCampaignView($data['campaign'], $data['store']);
    // $response['success'] = true;
    // $response['message'] = "İşlem Başarılı";
    $queue = new FileJobQueue();

    $queue->add([
        'store_id' => $data['store'],
        'campaign_id' => $data['campaign']
    ]);

}

echo json_encode($response);

?>