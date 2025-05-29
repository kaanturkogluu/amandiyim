<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Session.php';

class BaseModel
{
    protected $db;
    protected $table; // her modelde bu tanımlanmalı

    protected $storeCategory;
    protected $store_id;
    protected $itemsPerPage = 20;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $session = Session::getInstance();
        if ($session->isStore()) {
            $this->store_id = $_SESSION['user']['id'];
            $this->storeCategory = $_SESSION['user']['store_category'] ?? 0;
        }


    }

    /**
     * Tüm kayıtları getir
     */
    public function all()
    {
        $sql = "SELECT * FROM {$this->getTable()}";
        $query = $this->db->query($sql);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    /* 
    Kayıt sayısını getir
    */
    public function count($where = "")
    {
        $sql = "SELECT COUNT(*) as 'sayi' FROM {$this->getTable()} $where";
        $query = $this->db->query($sql);
        return $query->fetch(PDO::FETCH_ASSOC)['sayi'];
    }

    public function getTotalPages($where = "")
    {

        $totalItems = self::count($where);
        return ceil($totalItems / $this->itemsPerPage);
    }

    /**
     * ID ile tek kayıt getir
     */
    public function find($id)
    {
        $sql = "SELECT * FROM {$this->getTable()} WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Kayıt ekle son idyi al
     */
    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
    
        $sql = "INSERT INTO {$this->getTable()} ($columns) VALUES ($placeholders)";
        $query = $this->db->prepare($sql);
        $success = $query->execute($data);
    
        if ($success) {
            return $this->db->lastInsertId(); // Eklenen kaydın ID'si
        }
    
        return false; // Eklenme başarısız
    }
    

    /**
     * Kayıt güncelle
     */
    public function update($id, $data)
    {
        $setPart = "";
        foreach ($data as $column => $value) {
            $setPart .= "$column = :$column, ";
        }
        $setPart = rtrim($setPart, ", ");

        $sql = "UPDATE {$this->getTable()} SET $setPart WHERE id = :id";
        $data['id'] = $id;
        $query = $this->db->prepare($sql);
        return $query->execute($data);
    }

    /**
     * Kayıt sil
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->getTable()} WHERE id = :id";
        $query = $this->db->prepare($sql);
        return $query->execute(['id' => $id]);
    }

    /**
     * Tablo adını kontrol ederek getir (güvenlik için)
     */
    protected function getTable()
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->table)) {
            throw new Exception("Geçersiz tablo adı!");
        }
        return $this->table;
    }


    public function getLimitedData($limit, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE store_id = :sid ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':sid', $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getSelectedColumns(array $columns, array $where = [])
    {


        // Sütunları güvenli şekilde virgülle ayır
        $columnList = implode(", ", array_map(function ($col) {
            return "`" . preg_replace('/[^a-zA-Z0-9_]/', '', $col) . "`";
        }, $columns));

        // WHERE koşulları için parçalar
        $conditions = [];
        $params = [];

        foreach ($where as $key => $value) {
            $cleanKey = preg_replace('/[^a-zA-Z0-9_]/', '', $key);
            $conditions[] = "`$cleanKey` = :$cleanKey";
            $params[$cleanKey] = $value;
        }

        // SQL cümlesi oluştur
        $sql = "SELECT $columnList FROM `{$this->table}`";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Sorguyu hazırla ve çalıştır
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        // Sonuçları döndür
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
