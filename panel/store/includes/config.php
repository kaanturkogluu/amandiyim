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
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}

// Oturum ayarları
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Zaman dilimi
date_default_timezone_set('Europe/Istanbul');

// Hata raporlama
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sabit değişkenler
define('SITE_URL', 'http://localhost/amandiyim');
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'] . '/amandiyim/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

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
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Kredi işlemleri için fonksiyonlar
function checkCredit($store_id, $required_credit) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT credit_balance FROM stores WHERE id = ?");
        $stmt->execute([$store_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['credit_balance'] >= $required_credit;
    } catch(PDOException $e) {
        error_log("Kredi kontrolü hatası: " . $e->getMessage());
        return false;
    }
}

function updateCredit($store_id, $amount, $type = 'deduct') {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Kredi bakiyesini güncelle
        $sql = "UPDATE stores SET credit_balance = credit_balance " . ($type === 'deduct' ? '-' : '+') . " ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$amount, $store_id]);
        
        // Kredi geçmişini kaydet
        $sql = "INSERT INTO credit_history (store_id, amount, type, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([$store_id, $amount, $type]);
        
        $db->commit();
        return true;
    } catch(PDOException $e) {
        $db->rollBack();
        error_log("Kredi güncelleme hatası: " . $e->getMessage());
        return false;
    }
}

// Kampanya işlemleri için fonksiyonlar
function createCampaign($store_id, $data) {
    global $db;
    
    try {
        $db->beginTransaction();
        
        // Kredi kontrolü
        if (!checkCredit($store_id, $data['credit_cost'])) {
            throw new Exception("Yetersiz kredi!");
        }
        
        // Kampanyayı oluştur
        $sql = "INSERT INTO campaigns (store_id, name, discount_rate, start_date, end_date, credit_cost, description, status, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $store_id,
            $data['name'],
            $data['discount_rate'],
            $data['start_date'],
            $data['end_date'],
            $data['credit_cost'],
            $data['description']
        ]);
        
        // Krediyi düş
        updateCredit($store_id, $data['credit_cost'], 'deduct');
        
        $db->commit();
        return true;
    } catch(Exception $e) {
        $db->rollBack();
        error_log("Kampanya oluşturma hatası: " . $e->getMessage());
        return false;
    }
}

function updateCampaign($campaign_id, $data) {
    global $db;
    
    try {
        $sql = "UPDATE campaigns SET 
                name = ?, 
                discount_rate = ?, 
                start_date = ?, 
                end_date = ?, 
                description = ?, 
                status = ?,
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['discount_rate'],
            $data['start_date'],
            $data['end_date'],
            $data['description'],
            $data['status'],
            $campaign_id
        ]);
        
        return true;
    } catch(PDOException $e) {
        error_log("Kampanya güncelleme hatası: " . $e->getMessage());
        return false;
    }
}

function deleteCampaign($campaign_id) {
    global $db;
    
    try {
        // Önce kampanya bilgilerini al
        $stmt = $db->prepare("SELECT store_id, credit_cost FROM campaigns WHERE id = ?");
        $stmt->execute([$campaign_id]);
        $campaign = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$campaign) {
            throw new Exception("Kampanya bulunamadı!");
        }
        
        $db->beginTransaction();
        
        // Kampanyayı sil
        $stmt = $db->prepare("DELETE FROM campaigns WHERE id = ?");
        $stmt->execute([$campaign_id]);
        
        // Krediyi geri ver
        updateCredit($campaign['store_id'], $campaign['credit_cost'], 'add');
        
        $db->commit();
        return true;
    } catch(Exception $e) {
        $db->rollBack();
        error_log("Kampanya silme hatası: " . $e->getMessage());
        return false;
    }
}

// Mağaza işlemleri için fonksiyonlar
function getStoreInfo($store_id) {
    global $db;
    
    try {
        $stmt = $db->prepare("SELECT * FROM stores WHERE id = ?");
        $stmt->execute([$store_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        error_log("Mağaza bilgisi alma hatası: " . $e->getMessage());
        return false;
    }
}

function updateStoreInfo($store_id, $data) {
    global $db;
    
    try {
        $sql = "UPDATE stores SET 
                name = ?, 
                email = ?, 
                phone = ?, 
                address = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $store_id
        ]);
        
        return true;
    } catch(PDOException $e) {
        error_log("Mağaza güncelleme hatası: " . $e->getMessage());
        return false;
    }
}

// Dosya yükleme fonksiyonu
function uploadFile($file, $target_dir) {
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
    
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        throw new RuntimeException('Dosya boyutu çok büyük.');
    }
    
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    
    $allowed_types = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif'
    ];
    
    if (!array_key_exists($mime_type, $allowed_types)) {
        throw new RuntimeException('Geçersiz dosya türü.');
    }
    
    $extension = $allowed_types[$mime_type];
    $filename = sprintf('%s.%s', sha1_file($file['tmp_name']), $extension);
    $filepath = $target_dir . $filename;
    
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new RuntimeException('Dosya yüklenemedi.');
    }
    
    return $filename;
}
?> 