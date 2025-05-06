<?php
require_once __DIR__ . '/BaseModel.php';

class Stores extends BaseModel
{
    protected $table = 'stores';
    public $itemsPerPage = 20;

    // Aktif mağazaları al
    public function getAllStoresWithPage($page = 1)
    {

        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . "  LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE store_statu  IN('suspend','blocked','active','waiting')"),
            'data' => $data

        ];





    }
    public function searchStores(array $filters = [])
    {
        // İzin verilen sütunlar
        $allowedColumns = ['store_name', 'store_owner_mail', 'store_owner_phone', 'store_adress'];
    
        $whereClauses = [];
        $params = [];
    
        foreach ($filters as $column => $keyword) {
            if (!in_array($column, $allowedColumns)) {
                throw new Exception("Geçersiz arama sütunu: $column");
            }
    
            $whereClauses[] = "{$column} LIKE :{$column}";
            $params[":{$column}"] = '%' . $keyword . '%';
        }
    
        $whereSQL = '';
        if (!empty($whereClauses)) {
            $whereSQL = 'WHERE ' . implode(' OR ', $whereClauses);
        }
    
        $sql = "SELECT * FROM {$this->table} {$whereSQL}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    
        return [
            'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    }
    

    // Sayfaya göre aktif mağazaları al
    public function getActiveStoresWithPage($page = 1)
    {
        // Sayfa başına gösterilecek öğe sayısı
        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_statu = :st LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);

        // Parametreleri bağla
        $stmt->bindValue(':st', 'active', PDO::PARAM_STR); // Doğrudan değer bağlanıyor
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['total_pages' => $this->getTotalPages("WHERE store_statu='active'"), 'data' => $data];
    }

    public function getStoreCount(){
        $sql = "SELECT COUNT(*) as sayi FROM " . $this->table ;
        $stmt = $this->db->prepare($sql);



        $stmt->execute();
       return $stmt->fetch(PDO::FETCH_ASSOC)['sayi'];
    }


    // Toplam sayfa sayısını al
    public function getTotalPages($where = "")
    {

      $totalItems = self::getStoreCount();

        return ceil($totalItems / $this->itemsPerPage);
    }

}
