<?php


require_once __DIR__ . '/../classes/Helper.php';

require_once __DIR__ . '/../classes/Session.php';
require_once __DIR__ . '/../classes/MyLogin.php';

$helper = Helper::getInstance();
$session = Session::getInstance();
$login = MyLogin::getInstance();

$usermail = $helper::post("email");
$userpassword = $helper::post("password");
$userType = $helper::post("user_type");

 

 
$loginpaths = [
    "admin" => Helper::url("panel/admin/pages/anasayfa.php"),
    "customer" => Helper::url("panel/customer/pages/anasayfa.php"),
    "store" => Helper::url("panel/store/pages/anasayfa.php")
];

$loginstate = $login->login($usermail, $userpassword, $userType);




if ($loginstate) {
    header('Location: ' . $loginpaths[$userType]);
    exit;
} else {

    header('Location: ' . Helper::view("giris") . "?type=" . $userType);
    exit;
}
