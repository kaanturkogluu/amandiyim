<?php
require_once __DIR__ . '/../classes/database.php';

// Database bağlantısını oluştur
$database = Database::getInstance();
$db = $database->getConnection();

try {
    // Foreign key kontrollerini geçici olarak devre dışı bırak
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Tabloları temizle
    $tables = [
        'campaigns_statics',
        'campaigns',
        'campaign_categories',
        'favorites',
        'store_follows',
        'reviews',
        'complaints',
        'notifications',
        'campaign_views',
        'stores',
        'categories',
        'customers',
        'admins'
    ];

    foreach ($tables as $table) {
        // Önce tablonun var olup olmadığını kontrol et
        $result = $db->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            $db->exec("TRUNCATE TABLE $table");
            echo "$table tablosu temizlendi.<br>";
        } else {
            echo "$table tablosu bulunamadı.<br>";
        }
    }

    // Foreign key kontrollerini tekrar etkinleştir
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

    // Örnek Admin Hesabı
    $adminPassword = password_hash('123456', PASSWORD_DEFAULT);
    $adminSQL = "INSERT INTO admins (admin_name, admin_surname, admin_password, admin_mail, admin_phone, admin_city) 
                 VALUES ('Admin', 'User', ?, 'admin@amandiyim.com', '5551234567', 'İstanbul')";

    $stmt = $db->prepare($adminSQL);
    $stmt->execute([$adminPassword]);
    echo "Admin hesabı başarıyla oluşturuldu.<br>";
    echo "E-posta: admin@amandiyim.com<br>";
    echo "Şifre: 123456<br><br>";

    // Örnek Müşteri Hesabı
    $customerPassword = password_hash('123456', PASSWORD_DEFAULT);
    $customerSQL = "INSERT INTO customers (name, surname, email, password, address, city, company_name, status, notes) 
                    VALUES ('Test', 'Müşteri', 'test@customer.com', ?, 'Test Adres', 'İstanbul', 'Test Şirket', 'active', 'Test Notlar')";

    $stmt = $db->prepare($customerSQL);
    $stmt->execute([$customerPassword]);
    echo "Müşteri hesabı başarıyla oluşturuldu.<br>";
    echo "E-posta: test@customer.com<br>";
    echo "Şifre: 123456<br><br>";

    // Örnek Mağaza Hesabı
    $storePassword = password_hash('123456', PASSWORD_DEFAULT);
    $storeSQL = "INSERT INTO stores (store_name, store_owner_name, store_owner_mail, store_owner_password, 
                                   store_location, store_owner_phone, store_adress, store_statu, store_credits) 
                 VALUES ('Test Mağaza', 'Test Mağaza Sahibi', 'test@store.com', ?, 'İstanbul', '5551234567', 
                        'Test Mağaza Adresi', 'active', '10000')";

    $stmt = $db->prepare($storeSQL);
    $stmt->execute([$storePassword]);
    echo "Mağaza hesabı başarıyla oluşturuldu.<br>";
    echo "E-posta: test@store.com<br>";
    echo "Şifre: 123456<br>";

    $storeCategorySQL = " INSERT INTO categories (category_name, category_description, category_image, category_icon)
VALUES
('Restoranlar', 'Yemek, fast food ve kafe kampanyaları', 'restoran.jpg', 'fas fa-utensils'),
('Giyim & Moda', 'Kadın, erkek ve çocuk giyim indirimleri', 'giyim.jpg', 'fas fa-tshirt'),
('Elektronik', 'Telefon, bilgisayar ve aksesuar kampanyaları', 'elektronik.jpg', 'fas fa-tv'),
('Market & Alışveriş', 'Süpermarketler ve günlük ihtiyaçlar', 'market.jpg', 'fas fa-shopping-basket'),
('Kozmetik & Kişisel Bakım', 'Parfüm, makyaj ve bakım ürünleri', 'kozmetik.jpg', 'fas fa-magic'),
('Mobilya & Dekorasyon', 'Ev dekorasyon ve mobilya kampanyaları', 'mobilya.jpg', 'fas fa-couch'),
('Spor & Outdoor', 'Spor salonları, ekipman ve giyim indirimleri', 'spor.jpg', 'fas fa-dumbbell'),
('Eğlence & Hobi', 'Sinema, tiyatro, oyun ve hobiler', 'eglence.jpg', 'fas fa-gamepad'),
('Sağlık & Güzellik', 'Diyetisyen, güzellik merkezi ve sağlık hizmetleri', 'saglik.jpg', 'fas fa-heartbeat'),
('Eğitim & Kurslar', 'Dil okulları, sertifika programları ve eğitim merkezleri', 'egitim.jpg', 'fas fa-book');
";
$stmt = $db->prepare($storeCategorySQL);
$stmt->execute();
echo "Kategoriler başarıyla oluşturuldu.<br>";

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage() . "<br>";
}
//Admin hesabı başarıyla oluşturuldu.
//E-posta: admin@amandiyim.com
//Şifre: 123456

//Müşteri hesabı başarıyla oluşturuldu.
//E-posta: test@customer.com
//Şifre: 123456

//Mağaza hesabı başarıyla oluşturuldu.
//E-posta: test@store.com
//Şifre: 123456


