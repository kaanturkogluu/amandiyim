<?php


require_once __DIR__ . '/../classes/BaseModel.php';
require_once __DIR__ . '/../classes/CampaingsView.php';
require_once __DIR__ . '/../classes/Campaigns.php';

$campaingView = new CampaingsView();
$campaing = new Campaigns();

$storesCampaingIds = $campaing->getStoresAllCampaignIds();
 
echo "<pre>";

foreach($storesCampaingIds as $s){

    echo $s['store_id'] . "<br>";
    echo $s['campaignsIds'] . "<br>";
    echo "<hr>";
}

var_dump(memory_get_usage($storesCampaingIds));

//campanyalari storelara göre grupla




//Günlük Görüntüleme Sayısını Al 


//Günlük farklı ip sayısını al  
//campaing_statick tablosuna kayıt et 
//finalede günlük istatistikleri almak için kullanılacak 


?>