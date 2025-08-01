<?php

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
 
if ($session->isExpired(1800)) { //30 dakika
    $session->kickOut("");
}
$session->touch();
$allowedHost = parse_url(Helper::baseUrl(), PHP_URL_HOST);

if (!$session->isLoggedIn() || !$session->isAdmin()) {
    // Giriş yapılmamışsa veya user_type 'store' değilse login sayfasına yönlendir

    $session->kickOut("Tekrar Oturum Açınız");

}



if (!isset($_SESSION['user_agent'])) {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
}
if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {

    $session->kickOut("Tarayıcı değişti, tekrar giriş yapınız.");
}



$currentUserRole = 'store';
$currentPage = $_SERVER['SCRIPT_NAME']; // Örn: /store/dashboard.php



 


?>