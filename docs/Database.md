# Database Sınıfı Dokümantasyonu

## Genel Bakış
Database sınıfı, veritabanı işlemlerini yönetmek için kullanılan bir singleton sınıfıdır. PDO kullanarak güvenli ve verimli veritabanı işlemleri sağlar.

## Kurulum

### 1. Veritabanı Bağlantısı
```php
// Database sınıfını kullanmaya başlamak için
$db = Database::getInstance();
```

### 2. Yapılandırma
`.env` dosyasında veritabanı ayarlarınızı tanımlayın:
```env
DB_HOST=localhost
DB_NAME=amandiyim
DB_USER=root
DB_PASS=
DB_CHARSET=utf8mb4
```

## Temel Kullanım

### 1. Sorgu Çalıştırma
```php
// Basit sorgu
$db->query("SELECT * FROM users");

// Parametreli sorgu
$db->query("SELECT * FROM users WHERE id = ?", [1]);

// Named parametreli sorgu
$db->query("SELECT * FROM users WHERE name = :name", ['name' => 'John']);
```

### 2. Tek Satır Veri Alma
```php
// Tek satır veri alma
$user = $db->fetch("SELECT * FROM users WHERE id = ?", [1]);

// Sonuç yoksa null döner
if ($user) {
    echo $user['name'];
}
```

### 3. Tüm Satırları Alma
```php
// Tüm satırları alma
$users = $db->fetchAll("SELECT * FROM users");

// Parametreli sorgu ile tüm satırları alma
$activeUsers = $db->fetchAll("SELECT * FROM users WHERE status = ?", ['active']);
```

### 4. Veri Ekleme
```php
// Veri ekleme
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com'
];
$db->insert('users', $data);

// ID'yi alma
$userId = $db->lastInsertId();
```

### 5. Veri Güncelleme
```php
// Veri güncelleme
$data = [
    'name' => 'John Updated',
    'email' => 'john.updated@example.com'
];
$db->update('users', $data, 'id = ?', [1]);
```

### 6. Veri Silme
```php
// Veri silme
$db->delete('users', 'id = ?', [1]);
```

### 7. Sütun Sayısını Alma
```php
// Tablodaki toplam kayıt sayısı
$total = $db->count('users');

// Koşullu kayıt sayısı
$activeCount = $db->count('users', 'status = ?', ['active']);
```

### 8. Transaction İşlemleri
```php
try {
    $db->beginTransaction();
    
    // İşlemler
    $db->insert('users', ['name' => 'John']);
    $db->insert('profiles', ['user_id' => $db->lastInsertId()]);
    
    $db->commit();
} catch (Exception $e) {
    $db->rollBack();
    throw $e;
}
```

## Gelişmiş Kullanım

### 1. Raw Sorgular
```php
// Raw sorgu çalıştırma
$db->raw("SELECT * FROM users WHERE created_at > DATE_SUB(NOW(), INTERVAL 1 DAY)");
```

### 2. Sorgu Sonuçlarını İşleme
```php
// Her satır için callback fonksiyonu çalıştırma
$db->query("SELECT * FROM users", [], function($row) {
    // Her satır için yapılacak işlemler
    echo $row['name'];
});
```

### 3. Hata Yönetimi
```php
try {
    $db->query("SELECT * FROM non_existent_table");
} catch (PDOException $e) {
    // Hata yönetimi
    error_log($e->getMessage());
}
```

## Güvenlik Özellikleri

1. **SQL Injection Koruması**: PDO prepared statements kullanılarak SQL injection saldırılarına karşı koruma sağlanır.

2. **XSS Koruması**: Veriler otomatik olarak escape edilmez, kullanıcı verilerini gösterirken `Helper::escape()` kullanılmalıdır.

3. **Transaction Desteği**: Veri tutarlılığı için transaction desteği sağlanır.

## Performans İpuçları

1. **Sorgu Önbellekleme**: Tekrarlanan sorgular için önbellekleme kullanın.

2. **Index Kullanımı**: Sık sorgulanan sütunlar için index oluşturun.

3. **Batch İşlemler**: Çoklu veri ekleme/güncelleme için transaction kullanın.

## Hata Ayıklama

### Debug Modu
```php
// Debug modunu aktifleştirme
$db->debug = true;

// Sorgu loglarını görüntüleme
$db->getLastQuery();
```

## Örnek Kullanım Senaryoları

### 1. Kullanıcı Yönetimi
```php
// Kullanıcı ekleme
$userData = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => password_hash('secret', PASSWORD_DEFAULT)
];
$db->insert('users', $userData);

// Kullanıcı güncelleme
$db->update('users', 
    ['status' => 'active'], 
    'id = ?', 
    [$userId]
);

// Kullanıcı silme
$db->delete('users', 'id = ?', [$userId]);
```

### 2. İlişkili Veriler
```php
// Kullanıcı ve profil bilgilerini alma
$user = $db->fetch("
    SELECT u.*, p.* 
    FROM users u 
    LEFT JOIN profiles p ON u.id = p.user_id 
    WHERE u.id = ?
", [$userId]);
```

### 3. Sayfalama
```php
// Sayfalama ile veri alma
$page = 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$users = $db->fetchAll(
    "SELECT * FROM users LIMIT ? OFFSET ?",
    [$limit, $offset]
);
```

## Sık Karşılaşılan Sorunlar ve Çözümleri

1. **Bağlantı Hatası**
   - `.env` dosyasındaki veritabanı bilgilerini kontrol edin
   - Veritabanı sunucusunun çalıştığından emin olun

2. **Sorgu Hataları**
   - SQL syntax'ını kontrol edin
   - Parametre sayısının doğru olduğundan emin olun

3. **Performans Sorunları**
   - Sorguları optimize edin
   - Gerekli indexleri ekleyin
   - Büyük veri setleri için sayfalama kullanın 