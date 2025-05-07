<?php

require_once __DIR__ . '/../classes/BaseModel.php';
require_once __DIR__ . '/../classes/CampaingsView.php';
require_once __DIR__ . '/../classes/CampaignsStatics.php';
require_once __DIR__ . '/../classes/Campaigns.php';
date_default_timezone_set('Europe/Istanbul');

// Günlük log dosyasının adı, tarih formatıyla
$tarih = date("d-m-Y");
$logFilePath = __DIR__ . "/../websitedata/{$tarih}istatistikDurumu.txt";

// Log dosyasını aç (ekleme modu - 'a' ile)
$logFile = fopen($logFilePath, 'a');
if (!$logFile) {
    die("Log dosyası oluşturulamadı: " . $logFilePath);
}

// Yeni bir log satırı eklemek için yardımcı bir fonksiyon
function logMessage($message, $logFile) {
    $timestamp = date("Y-m-d H:i:s");  // Zaman damgası ekle
    $logEntry = "[{$timestamp}] {$message}\n";
    fwrite($logFile, $logEntry);
}

$campaingView = new CampaingsView();
$campaing = new Campaigns();
$campaignStatics = new CampaignsStatics();

logMessage("İşlem Başlatıldı.", $logFile);


// Verileri al
$calculetdData = $campaingView->calculateAllStoreViews();

 
 

// Verilerin 50'şer satır olarak kaydedilmesi işlemi
try {  
    $durum = $campaignStatics->createCollective($calculetdData);
    logMessage("İstatistikler başarıyla eklendi.", $logFile);
} catch (Exception $e) {
    logMessage("Hata oluştu: " . $e->getMessage(), $logFile);
}

// Loglama işlemi sırasında karşılaşılan başarı veya hata mesajlarını kaydet
logMessage("İşlem Tamamlandı.", $logFile);

// Dosyayı kapat
fclose($logFile);

?>
