<?php
require_once __DIR__ . '/Helper.php';

class Database
{
    private static $instance = null;
    private $connection;
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $charset;

    private function __construct()
    {
        $this->host = Helper::config('DB_HOST');
        $this->dbname = Helper::config('DB_NAME');
        $this->username = Helper::config('DB_USER');
        $this->password = Helper::config('DB_PASS');
        $this->charset = Helper::config('DB_CHARSET');

        $this->connect();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect(): void
    {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new Exception("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }


    // 🔹 **Dinamik olarak farklı bir veritabanına geçiş yap**
    public function setDatabase($host, $user, $pass, $dbname)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return true;
        } catch (PDOException $error) {
            return false;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function veriGetir($innerjoin = 0, $tablo, $wherealanlar = "", $wherearraydeger = [])
    {
        try {
            // Eğer wherealanlar bir dizi olarak gönderildiyse, SQL parçası yoktur, doğrudan execute parametreleri olarak al
            if (is_array($wherealanlar) && empty($wherearraydeger)) {
                $wherearraydeger = $wherealanlar;
                $wherealanlar = ""; // SQL parçası yok
            }
    
            // SQL sorgusunu hazırla
            $sql = ($innerjoin == 1) ? $tablo : "SELECT * FROM " . $tablo;
    
            // Eğer where koşulu varsa ekle
            if (!empty($wherealanlar) && is_string($wherealanlar)) {
                $sql .= " " . $wherealanlar;
            }
    
            // Sorguyu hazırla ve çalıştır
            $calistir = $this->connection->prepare($sql);
            $sonuc = $calistir->execute($wherearraydeger);
    
            // Sonucu döndür
            return $sonuc ? $calistir->fetchAll(PDO::FETCH_ASSOC) : false;
    
        } catch (PDOException $e) {
            return false;
        }
    }
    

    public function sorguCalistir($tablosorgu, $alanlar = "", $degerlerarray = [])
    {
        try {
            $this->connection->beginTransaction();
            $sql = $tablosorgu . " " . $alanlar;

            if (!empty($degerlerarray)) {
                $calistir = $this->connection->prepare($sql);
                $sonuc = $calistir->execute($degerlerarray);
            } else {
                $sonuc = $this->connection->exec($sql);
            }

            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollback();
            return false;
        }
    }

    public function sorguCalistirSonIdAl($tablosorgu, $alanlar = "", $degerlerarray = [])
    {
        try {
            $this->connection->beginTransaction();
            $sql = $tablosorgu . " " . $alanlar;

            if (!empty($degerlerarray)) {
                $calistir = $this->connection->prepare($sql);
                $sonuc = $calistir->execute($degerlerarray);
            } else {
                $sonuc = $this->connection->exec($sql);
            }

            $lastInsertId = $this->connection->lastInsertId();
            $this->connection->commit();
            return $lastInsertId;

        } catch (PDOException $e) {
            $this->connection->rollback();
            return false;
        }
    }
}

