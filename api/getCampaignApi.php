<?php
header('Content-Type: application/json; charset=utf-8');

// $db bağlantı nesnesi olarak kabul ediliyor
require_once __DIR__ . '/../classes/Database.php'; // Eğer bağlantı burada ise, yoksa bu satırı kaldırabilirsiniz
require_once __DIR__ . '/../classes/Helper.php'; // Eğer bağlantı burada ise, yoksa bu satırı kaldırabilirsiniz

$con = DataBase::getInstance();
$db = $con->getConnection();
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 12;
$category = isset($_GET['category']) ? (int) $_GET['category'] : null;

// Güvenlik için limit'i sınırla
if ($limit > 50)
    $limit = 50;

try {
    $sql = "
   SELECT 
        c.campaign_type,
        c.store_id,
        c.id,
        c.campaign_title,
        c.campaign_disscount_off,
        c.campaign_image,
        c.campaign_sub_description,
        c.campaign_end_time
       FROM campaigns c 
        INNER JOIN campaing_categories  cc ON cc.campaign_id = c.id 
   
    WHERE 
        c.campaign_status = 'active' 
        AND c.campaign_end_time > NOW() ";

    // Kategori filtresi ekle
    if ($category !== null) {
        $sql .= "  AND cc.campaign_store_category_id=:category";
    }

    $sql .= " ORDER BY c.campaign_end_time DESC LIMIT :offset, :limit";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    
    if ($category !== null) {
        $stmt->bindValue(':category', $category, PDO::PARAM_INT);
    }

    $stmt->execute();
    $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($campaigns as &$c) {
        $resim = $c['campaign_image'];
        if ($resim) {
            $cc = explode("-", $resim, 2);  // ✅ sadece ilk "-"'ye göre parçala
            if ($cc[0] == "stock" && isset($cc[1])) {
                $c['campaign_image'] = Helper::upolads('images/stock_photos/' . $cc[1]);
            } elseif ($cc[0] == "upload" && isset($cc[1])) {
                $c['campaign_image'] = Helper::upolads('images/campaign_images/' . $cc[1]);
            }
        }
        
    }

    echo json_encode($campaigns);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}