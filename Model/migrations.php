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
    ->string('store_opening_time')->default('09:00')
    ->string('store_closing_time')->default('18:00')
    ->string('store_adress')
    ->string('store_logo')->default('store-default-icon.jpg')
    ->string('store_phone')
    ->string('store_main_image')->default('store-default-main-image.jpg')
    ->string('store_credits')->default('1000')
    ->enum('store_statu', ['suspend', 'blocked', 'active', 'waiting'])
    ->string('store_confirmed_ip_adress')
    ->integer('updated_by_store_info')->default(0)
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
    ->integer('campaing_credit_amount')->default('0')
    ->enum('campaign_type', ['discount', 'bogo', 'bundle', 'discount_amount'])->default('discount')
    ->enum('campaign_status', ['expired', 'active', 'suspend', 'waiting'])->default('waiting')
    ->foreignKey('store_id', 'stores', 'id');


// Campaigns Statics tablosu
$campaignsStaticsBlueprint = new Blueprint('campaigns_statics');
$campaignsStaticsBlueprint->id()
    ->integer('campaign_id')
    ->string('total_views', 10)->default("0")
    ->string('total_diffrent_views', 10)->default("0")
    ->integer('store_id')
    ->foreignKey('campaign_id', 'campaigns', 'id');

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


$creditProvisionBluePrint = new Blueprint('credit_provision');
$creditProvisionBluePrint->id()
    ->integer('amaount')
    ->integer('store_id')
    ->enum('proccess_statu', ['processed', 'waiting'])->default('waiting')
    ->enum('proccess', ['spending_credit', 'upload_credit'])
    ->json('description')
    ->timestamps();
// Phones tablosus
$phonesBlueprint = new Blueprint('phones');
$phonesBlueprint->id()
    ->integer('customer_id')
    ->string('phone_number', 10)
    ->string('is_verified', 1)
    ->foreignKey('customer_id', 'customers', 'id');


// Phone Verified Codes tablosu
$phoneVerifiedCodesBlueprint = new Blueprint('phone_verified_codes');
$phoneVerifiedCodesBlueprint->id()
    ->string('code', 6)
    ->integer('phone_id')
    ->foreignKey('phone_id', 'phones', 'id');




$stockPhotosBlueprint = new Blueprint('stock_photos');
$stockPhotosBlueprint->id()
    ->string('url')
    ->string('stock_photo_title')

    ->integer('stock_photo_store_category')
    ->integer('stock_photo_sub_category')->default(0)
    ->integer('stock_photo_sub_sub_category')->default(0)
    ->foreignKey('id', 'store_categories', 'id');



$campaignViewsBlueprint = new Blueprint('campaign_views');
$campaignViewsBlueprint->id()
    ->integer('campaign_id')
    ->string('ip_adress')
    ->foreignKey('campaign_id', 'campaigns', 'id');


$creditHistoryBluePrint = new Blueprint('credit_History');
$creditHistoryBluePrint->id()
    ->integer('store_id')
    ->enum('process', ['loading', 'update', 'spending'])
    ->integer('credit_value')
    ->integer('before_procces_credit_value')
    ->integer('after_proccess_credit_value')
    ->json('credit_details')->integer('amount');


$campaingCategoriesBluePrint = new Blueprint('campaing_categories');
$campaingCategoriesBluePrint->id()
    ->integer('campaign_id')
    ->integer('campaign_store_category_id')
    ->integer('campaign_sub_category_id')
    ->integer('campaign_sub_sub_category_id')->default(0)
;

$storeCategoriesBlueprint = new Blueprint('store_categories');
$storeCategoriesBlueprint->id()
    ->string('category_name')
    ->string('category_description')
    ->string('category_image')
    ->string('category_icon')
    ->enum('status', ['active', 'inactive']);


$campaingSubCategoriesBlueprint = new Blueprint('campaign_sub_categories');
$campaingSubCategoriesBlueprint->id()
    ->integer('store_categories_id')
    ->string('sub_category_name')
    ->string('sub_description', 255)
    ->foreignKey('store_categories_id', 'store_categories', 'id');

$campaign_sub_sub_categoriesBlueprint = new Blueprint('campaign_sub_sub_categories');
$campaign_sub_sub_categoriesBlueprint->id()
    ->integer('campaing_sub_category_id')
    ->string('sub_sub_name', 255)
    ->string('sub_sub_description', 255);


$featuredCampaignsBluePrint = new Blueprint('featured_campaigns');
$featuredCampaignsBluePrint->id()
    ->integer('campaign_id')
    ->integer('orderNumber')->default(1)
    ->timestamp('featured_started_date')->default('CURRENT_TIMESTAMP')
    ->timestamp('featured_ended_date')->default('CURRENT_TIMESTAMP')
    ->timestamps();




// Migration'ları çalıştır
$migrations = [
    $adminBlueprint->create() => "admin",
    $storeBlueprint->create() => "store",
    $campaignsBlueprint->create() => "campaigns",
    $customersBlueprint->create() => "customers",
    $phonesBlueprint->create() => "phones",
    $phoneVerifiedCodesBlueprint->create() => "phone_verified_codes",
    $campaignsStaticsBlueprint->create() => "campaigns_statics",
    $stockPhotosBlueprint->create() => "stock_photos",
    $campaignViewsBlueprint->create() => "campaign_views",
    $creditHistoryBluePrint->create() => "credit_details",
    $storeCategoriesBlueprint->create() => "store_categories",
    $campaingCategoriesBluePrint->create() => "campaing_categories",
    $campaingSubCategoriesBlueprint->create() => "campaign_sub_categories",
    $campaign_sub_sub_categoriesBlueprint->create() => "campaign_sub_sub_categories",
    $creditProvisionBluePrint->create() => "credit_provision",
    $featuredCampaignsBluePrint->create()=>"featured_campaigns"

];


// Admin kullanıcısı oluştur

try {
    $say = 0;
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


    echo $say . " Tane Tablo Oluşturuldu . <br>";
    echo "Tüm migration'lar başarıyla tamamlandı.\n";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}