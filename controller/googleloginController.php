<?php

require_once __DIR__ . '/../classes/Helper.php';

require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/MyLogin.php';
require_once __DIR__ . '/../classes/Register.php';

$register = Register::getInstance();
$helper = Helper::getInstance();
$session = Session::getInstance();
$login = MyLogin::getInstance();
// googledan gelen bilgileri al 
// kullanıcıyı kayıt et 
// kullanıcıyı giriş 

// kullanıcıyı ana sayfaya yönlendir 
// 1 kayıt var mı kontrol et 
// 2 kayıt yoksa kayıt et 
// 3 giriş yap 
// 4 ana sayfaya yönlendir 
// kayıt var sa 
// anasayfaya yönlendir 


require_once __DIR__ . '/../vendor/autoload.php';
$client = new Google\Client;
$client->setClientId('579431488499-hvsmo6l60gund27l09o7o84r0m5il28k.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:3000/controller/googleloginController.php');

// Log başlangıcı
 

if (!isset($_GET['code'])) {
   $session->set('login_errors', "Google Login: Authorization code bulunamadı");
  
    exit("Login Failed");
}

// Token ve kullanıcı bilgilerini al
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token['access_token']);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();

// Kullanıcı bilgilerini al
$usermail = $userinfo->email;
$userfullname = $userinfo->name;
$googleid = $userinfo->id;

// Google ID'yi şifre olarak kullan
$password = $googleid; // Şifreyi hashlemeden önce sakla
$hashedPassword = $googleid;

// Kullanıcı bilgilerini hazırla
$useradata = [
    "email" => $usermail,
    "name" => $userfullname,
    "password" => $hashedPassword,
    "password_confirm" => $hashedPassword // Register sınıfı için gerekli
];

 

// Önce login deneyelim
 
if ($login->login($usermail, $password, "customer")) {
   
    header("Location:" . Helper::customerPanelView("anasayfa"));
    exit();
} else {
    
    
    // Kullanıcı kayıtlı değil, kayıt etmeyi dene
    if ($register->register($useradata)) {
       
        // Kayıt başarılı, şimdi login yap
        if ($login->login($usermail, $password, "customer")) {
         
            header("Location:" . Helper::customerPanelView("anasayfa"));
            exit();
        } else {
            echo "<p style='color:red'>Google Login: Kayıt sonrası giriş başarısız</p>";
            echo "<p>Hata mesajları:</p>";
            echo "<pre>" . print_r($login->getErrors(), true) . "</pre>";
            echo "<p>Kullanılan şifre: " . $password . "</p>";
        }
    } else {
        echo "<p style='color:red'>Google Login: Kayıt başarısız</p>";
        echo "<p>Hata mesajları:</p>";
        echo "<pre>" . print_r($register->getErrors(), true) . "</pre>";
    }
    
    // Herhangi bir hata durumunda giriş sayfasına yönlendir
    header("Location:" . Helper::view("giris"));
    exit();
}
