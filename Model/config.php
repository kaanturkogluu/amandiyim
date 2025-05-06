<?php
// Veritabanı bağlantı bilgileri
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'amandiyim');

// Veritabanı bağlantısı
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
    die();
}

// Zaman dilimi ayarı
date_default_timezone_set('Europe/Istanbul');

// Oturum başlatma
session_start();

// Hata raporlama
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sabit tanımlamaları
define('SITE_URL', 'http://localhost/amandiyim');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/amandiyim/uploads/');
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif']);
define('MAX_IMAGE_SIZE', 5 * 1024 * 1024); // 5MB

// Güvenlik fonksiyonları
function clean($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function generateToken() {
    return bin2hex(random_bytes(32));
}

function validateToken($token) {
    return isset($_SESSION['token']) && hash_equals($_SESSION['token'], $token);
}

// Dosya yükleme fonksiyonu
function uploadFile($file, $targetDir) {
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Geçersiz dosya parametresi.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('Dosya yüklenmedi.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Dosya boyutu çok büyük.');
        default:
            throw new RuntimeException('Bilinmeyen bir hata oluştu.');
    }

    if ($file['size'] > MAX_IMAGE_SIZE) {
        throw new RuntimeException('Dosya boyutu çok büyük.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);

    if (!in_array($mime_type, ALLOWED_IMAGE_TYPES)) {
        throw new RuntimeException('Geçersiz dosya türü.');
    }

    $extension = array_search($mime_type, [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
    ], true);

    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $extension);
    $filepath = $targetDir . $filename;

    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new RuntimeException('Dosya yüklenirken bir hata oluştu.');
    }

    return $filename;
}

// Tarih formatı fonksiyonu
function formatDate($date, $format = 'd.m.Y H:i') {
    return date($format, strtotime($date));
}

// Para formatı fonksiyonu
function formatMoney($amount) {
    return number_format($amount, 2, ',', '.') . ' ₺';
}

// Aktif menü kontrolü
function isActiveMenu($page) {
    return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}

// Kullanıcı girişi kontrolü
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }
}

// Admin kontrolü
function checkAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: ' . SITE_URL . '/login.php');
        exit();
    }
} 