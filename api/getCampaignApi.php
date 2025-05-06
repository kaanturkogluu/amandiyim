<?php
header('Content-Type: application/json; charset=utf-8');

// $db bağlantı nesnesi olarak kabul ediliyor
require_once __DIR__ . '/../classes/Database.php'; // Eğer bağlantı burada ise, yoksa bu satırı kaldırabilirsiniz

$con= DataBase::getInstance();
$db = $con->getConnection();
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 12;

// Güvenlik için limit'i sınırla
if ($limit > 50) $limit = 50;

try {
    $stmt = $db->prepare("SELECT campaign_type,store_id,id,campaign_title, campaign_disscount_off, campaign_image, campaign_sub_description, campaign_end_time FROM campaigns WHERE isConfirmed = 1 ORDER BY campaign_end_time DESC LIMIT :offset, :limit");
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($campaigns);
} catch (Exception $e) {
    echo json_encode(['error'=>$e->getMessage()]);
}