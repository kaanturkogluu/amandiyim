<?php
require_once 'Blueprint.php';
require_once '../classes/database.php';

// Database bağlantısını oluştur
$database = Database::getInstance();
$db = $database->getConnection();

// Users tablosu
$adminBlueprint = new Blueprint('admins');
$adminBlueprint->id()
    ->string('admin_name')
    ->string('admin_surname')
    ->string('admin_password')
    ->string('admin_token')
    ->timestamp('last_login')
    ->string('admin_phone')
    ->string('admin_mail', 100)->unique()
    ->string('admin_city', 30);


// Store tablosu
$storeBlueprint = new Blueprint('stores');
$storeBlueprint->id()
    ->string('store_location')
    ->string('store_owner_password')
    ->string('store_owner_mail')
    ->string('store_name')
    ->string('store_owner_phone')
    ->string('store_owner_name')
    ->string('work_time')->default('09:00 - 18:00')
    ->string('store_adress')
    ->string('store_logo')->default('store-default-icon.jpg')
    ->string('store_phone')
    ->string('store_main_image')->default('store-default-main-image.jpg')
    ->string('store_credits')->default('1000')
    ->enum('store_statu', ['suspend', 'blocked', 'active', 'waiting'])
    ->string('store_confirmed_ip_adress')
    ->text('local_adress')
    ->integer('store_category');


// Campaigns tablosu
$campaignsBlueprint = new Blueprint('campaigns');
$campaignsBlueprint->id()
    ->integer('store_id')
    ->string('campaign_title')
    ->string('campaign_sub_description')
    ->text('campaign_details')
    ->timestamp('campaign_start_time')->default('CURRENT_TIMESTAMP')
    ->timestamp('campaign_end_time')->default('CURRENT_TIMESTAMP')
    ->string('campaign_disscount_off', 10)
    ->json('campaign_conditions')
    ->string('campaign_image')
    ->string('campaign_min_purchase')
    ->integer('campaign_category')
    ->integer('isConfirmed')->default('0')
    ->enum('campaign_type', ['discount', 'bogo', 'bundle'])->default('discount')
    ->enum('campaign_status',['expired', 'active', 'suspend','waiting'])->default('waiting')
    ->foreignKey('store_id', 'stores', 'id');


// Campaigns Statics tablosu
$campaignsStaticsBlueprint = new Blueprint('campaigns_statics');
$campaignsStaticsBlueprint->id()
    ->integer('campaign_id')
    ->string('total_views', 10)->default("0")
    ->string('total_diffrent_views', 10)->default("0")
    ->integer('store_id')
    ->foreignKey('id', 'campaigns');

// Customers tablosu
$customersBlueprint = new Blueprint('customers');
$customersBlueprint->id()
    ->string('name', 100)->string('password', 100)
    ->string('surname', 100)->nullable()
    ->string('email', 100)->unique()
    ->text('address')
    ->string('city', 50)
    ->string('company_name', 100)
    ->enum('status', ['active', 'passive', 'blocked'])
    ->text('notes')
    ->timestamps();


// Phones tablosu
$phonesBlueprint = new Blueprint('phones');
$phonesBlueprint->id()
    ->integer('customer_id')
    ->string('phone_number', 10)
    ->string('is_verified', 1)
    ->foreignKey('customer_id', 'customers');


// Phone Verified Codes tablosu
$phoneVerifiedCodesBlueprint = new Blueprint('phone_verified_codes');
$phoneVerifiedCodesBlueprint->id()
    ->string('code', 6)
    ->integer('phone_id')
    ->foreignKey('phone_id', 'phones');


    
 $storeCategoriesBlueprint = new Blueprint('store_categories');
 $storeCategoriesBlueprint->id()
    ->string('category_name')
    ->string('category_description')
    ->string('category_image')
    ->string('category_icon');


    $stockPhotosBlueprint = new Blueprint('stock_photos');
    $stockPhotosBlueprint->id()
    ->string('url')
    ->string('stock_photo_title')
   
    ->integer('stock_photo_category')->foreignKey('id', 'store_categories');
   


    $campaignViewsBlueprint = new Blueprint('campaign_views');
    $campaignViewsBlueprint->id()
    ->integer('campaign_id')
    ->string('ip_adress')
    ->foreignKey('campaign_id', 'campaigns');


    $creditHistoryBluePrint= new Blueprint('credit_History');
    $creditHistoryBluePrint->id() 
    ->integer('store_id')
    ->enum('process',['loading','update','spending'])
    ->integer('credit_value')
    ->integer('before_procces_credit_value')
    ->integer('after_proccess_credit_value')
    ->json('credit_details')->integer('amount');


    $campaingCategoriesBluePrint  = new Blueprint('campaing_categories');
    $campaingCategoriesBluePrint->id()
     -> integer('campaign_id')
     ->string('category_name')
     ->string('category_ikon')
     ->string('category_image');
 
    
// Migration'ları çalıştır
$migrations = [
    $adminBlueprint->create() => "admin",
    $storeBlueprint->create() => "store",
    $campaignsBlueprint->create() => "campaigns",
    $customersBlueprint->create() => "customers",
    $phonesBlueprint->create() => "phones",
    $phoneVerifiedCodesBlueprint->create() => "phone_verified_codes",
    $campaignsStaticsBlueprint->create() => "campaigns_statics",
    $storeCategoriesBlueprint->create() => "store_categories",
    $stockPhotosBlueprint->create() => "stock_photos",
    $campaignViewsBlueprint->create() => "campaign_views",
    $creditHistoryBluePrint->create()=>"credit_details",
    $campaingCategoriesBluePrint->create()=> "campaing_categories"
];


// Admin kullanıcısı oluştur

try {
    $say = 0 ; 
    foreach ($migrations as $sql => $table) {
        $say++;
        echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ddd; border-radius: 5px;'>";
        echo "<strong>Tablo İşlemi Başlatılıyor:</strong> " . strtoupper($table) . "<br>";

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
            echo "<span style='color: green;'>✓ Tablo başarıyla oluşturuldu: " . $table . "</span><br>";
            echo "<small>SQL Sorgusu:</small> <code>" . htmlspecialchars($sql) . "</code>";
        } catch (PDOException $e) {
            echo "<span style='color: red;'>✗ Hata: " . $e->getMessage() . "</span><br>";
            echo "<small>Hatalı SQL Sorgusu:</small> <code>" . htmlspecialchars($sql) . "</code>";
        }

        echo "</div>";
        echo "<br>";
    }


echo $say  . " Tane Tablo Oluşturuldu . <br>";
    echo "Tüm migration'lar başarıyla tamamlandı.\n";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}