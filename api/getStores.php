<?php
require_once __DIR__ . '/../classes/Stores.php';
header('Content-Type: application/json; charset=utf-8');

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$category = isset($_GET['page']) ? (int) $_GET['page'] : 'all';

$stores = new Stores();
$stores->itemsPerPage = 16; // 16 mağaza dönecek


$result = $stores->getActiveStoresWithPage($page);


echo json_encode($result);
