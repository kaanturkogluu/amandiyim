<?php
require_once __DIR__ . '/../classes/Stores.php';
header('Content-Type: application/json; charset=utf-8');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$stores = new Stores();
$stores->itemsPerPage = 24; // 24 mağaza dönecek

try {
    if ($search) {
        // Arama yapılıyorsa
        $result = $stores->searchStoresForList($search, $page);
        echo json_encode($result);
        exit;
    } 
    
    if ($filter === 'all') {
        $result = $stores->getStoresForList($page);
    } else if ($filter === 'open') {
        $result = $stores->getOpenStoresForList($page);
    } else {
        // Kategori filtrelemesi
        $result = $stores->getStoresForList($page, ['category' => (int) $filter]);
    }

    echo json_encode([
        'success' => true,
        'total_pages' => $result['total_pages'],
        'data' => $result['data']
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'data' => []
    ]);
}
