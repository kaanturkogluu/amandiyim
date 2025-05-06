<?php
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/MyLogin.php';

// Google OAuth 2.0 yapılandırması
$google_client_id = 'YOUR_GOOGLE_CLIENT_ID';
$google_client_secret = 'YOUR_GOOGLE_CLIENT_SECRET';
$google_redirect_url = 'http://localhost/amandiyim/api/googleLogin.php';

// Google OAuth 2.0 sınıfını oluştur
require_once __DIR__ . '/../vendor/autoload.php';
$client = new Google_Client();
$client->setClientId($google_client_id);
$client->setClientSecret($google_client_secret);
$client->setRedirectUri($google_redirect_url);
$client->addScope('email');
$client->addScope('profile');

// Google'dan gelen kod ile giriş işlemi
if (isset($_GET['code'])) {
    try {
        // Google'dan token al
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Google servisini oluştur
        $google_oauth = new Google_Service_Oauth2($client);

        // Kullanıcı bilgilerini al
        $google_account_info = $google_oauth->userinfo->get();
        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $picture = $google_account_info->picture;

        // Veritabanı bağlantısı
        $database = Database::getInstance();
        $db = $database->getConnection();

        // Kullanıcıyı kontrol et
        $stmt = $db->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Yeni kullanıcı oluştur
            $password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO customers (name, email, password, status) VALUES (?, ?, ?, 'active')");
            $stmt->execute([$name, $email, $password]);
            
            $user_id = $db->lastInsertId();
        } else {
            $user_id = $user['id'];
        }

        // Oturum başlat
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_picture'] = $picture;
        $_SESSION['login_type'] = 'google';

        // Başarılı giriş sonrası yönlendirme
        header('Location: ../panel/customer/pages/anasayfa.php');
        exit;

    } catch (Exception $e) {
        // Hata durumunda
        session_start();
        $_SESSION['error'] = "Google ile giriş yapılırken bir hata oluştu: " . $e->getMessage();
        header('Location: ../giris.php');
        exit;
    }
} else {
    // Google giriş sayfasına yönlendir
    $auth_url = $client->createAuthUrl();
    header('Location: ' . $auth_url);
    exit;
}
