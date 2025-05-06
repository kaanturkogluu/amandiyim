<?php
 
require_once __DIR__ . '/vendor/autoload.php';
$client = new Google\Client;
$client->setClientId('579431488499-hvsmo6l60gund27l09o7o84r0m5il28k.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:3000/redirect.php');


if(!isset($_GET['code'])){ //giri islemi basarız ise 
  
    exit("Login Failed");
}

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
$client->setAccessToken($token['access_token']);
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();

echo "<pre>";
print_r(
    $userinfo
);
echo "</pre>";
