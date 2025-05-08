<?php

header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');


if ($session->isExpired(1800)) { //30 dakika
    $session->kickOut("");
}
$session->touch();
$allowedHost = parse_url(Helper::baseUrl(), PHP_URL_HOST);

if (!$session->isLoggedIn() || !$session->isStore()) {
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



$allowedPrefix = "/panel/store/pages";
$currentPage = dirname($currentPage);

if (!str_starts_with($currentPage, $allowedPrefix)) {
    $session->kickOut("Sayfa İçin Yetkiniz Bulunmamakta");
}




$currentFile = basename($_SERVER['PHP_SELF']);




if ($storeData['updated_by_store_info'] == 0) {

    if ($currentFile != 'getStarted.php') {

        header('Location:' . Helper::storePanelView('getStarted'));
        exit;
    }
}

?>