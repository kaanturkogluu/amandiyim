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

    public function getStoreCount()
    {
        $sql = "SELECT COUNT(*) as sayi FROM " . $this->table;
        $stmt = $this->db->prepare($sql);



        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sayi'];
    }


    public function getOpenStoresForList($page)
    {
        $offset = ($page - 1) * $this->itemsPerPage;
        $now = date('H:i:s');

        $sql = "
        SELECT 
            s.id,
            s.store_main_image,
            s.store_opening_time,
            s.store_closing_time,
            s.store_owner_name,
            s.store_location,
            s.store_name,
            s.store_adress,
            COUNT(c.id) AS active_campaign_count
        FROM 
            {$this->table} AS s
        LEFT JOIN   
            campaigns AS c ON c.store_id = s.id AND c.campaign_status = 'active'
        WHERE 
            s.store_statu = 'active'
            AND TIME(:now) BETWEEN s.store_opening_time AND s.store_closing_time
        GROUP BY 
            s.id
        LIMIT 
            :offset, :limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':now', $now, PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Toplam sayfa sayısını hesapla
        $countSql = "
        SELECT COUNT(DISTINCT s.id) as total
        FROM {$this->table} AS s
        WHERE s.store_statu = 'active'
        AND TIME(:now) BETWEEN s.store_opening_time AND s.store_closing_time
        ";

        $countStmt = $this->db->prepare($countSql);
        $countStmt->bindValue(':now', $now, PDO::PARAM_STR);
        $countStmt->execute();
        $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($total / $this->itemsPerPage);

        return [
            'total_pages' => $totalPages,
            'data' => $data
        ];
    }

    public function getStoresForList($page, $filter = [])
    {
        $offset = ($page - 1) * $this->itemsPerPage;

        $where = "s.store_statu = :st";
        $params = [
            ':st' => 'active',
            ':offset' => $offset,
            ':limit' => $this->itemsPerPage
        ];

        // Kampanya kategorisine göre filtreleme
        if (!empty($filter['category'])) {
            $where .= " AND s.store_category = :category_id";
            $params[':category_id'] = (int) $filter['category'];
        }

        $sql = "
        SELECT 
            s.id,
            s.store_main_image,
            s.store_opening_time,
            s.store_closing_time,
            s.store_owner_name,
            s.store_location,
            s.store_name,
            s.store_adress,
            COUNT(c.id) AS active_campaign_count
        FROM 
            {$this->table} AS s
        LEFT JOIN   
            campaigns AS c ON c.store_id = s.id AND c.campaign_status = 'active'
        WHERE 
            {$where}
        GROUP BY 
            s.id
        LIMIT 
            :offset, :limit
    ";

        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Toplam sayfa hesabı için filtreyi tekrar oluştur
        $totalWhere = "WHERE store_statu = 'active'";
        if (!empty($filter['category'])) {
            $totalWhere .= " AND id IN (
            SELECT store_id FROM campaigns 
            WHERE campaign_status = 'active' AND category_id = " . (int) $filter['category'] . "
        )";
        }

        return [
            'total_pages' => $this->getTotalPages($totalWhere),
            'data' => $data
        ];
    }

    // Toplam sayfa sayısını al
    public function getTotalPages($where = "")
    {

        $totalItems = self::getStoreCount();

        return ceil($totalItems / $this->itemsPerPage);
    }

    public function searchStoresForList($search, $page = 1)
    {
        $offset = ($page - 1) * $this->itemsPerPage;
        $search = '%' . $search . '%';

        $sql = "
        SELECT 
            s.id,
            s.store_main_image,
            s.store_opening_time,
            s.store_closing_time,
            s.store_owner_name,
            s.store_location,
            s.store_name,
            s.store_adress,
            COUNT(c.id) AS active_campaign_count
        FROM 
            {$this->table} AS s
        LEFT JOIN   
            campaigns AS c ON c.store_id = s.id AND c.campaign_status = 'active'
        WHERE 
            s.store_statu = 'active'
            AND 
                s.store_name LIKE :search 
              
          
        GROUP BY 
            s.id
        LIMIT 
            :offset, :limit
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':search', $search, PDO::PARAM_STR);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Toplam sayfa sayısını hesapla
            $countSql = "
            SELECT COUNT(DISTINCT s.id) as total
            FROM {$this->table} AS s
            WHERE s.store_statu = 'active'
            AND 
                s.store_name LIKE :search 
                
            
            ";

            $countStmt = $this->db->prepare($countSql);
            $countStmt->bindValue(':search', $search, PDO::PARAM_STR);
            $countStmt->execute();
            $total = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
            $totalPages = ceil($total / $this->itemsPerPage);

            return [
                'success' => true,
                'total_pages' => $totalPages,
                'data' => $data
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];
        }
    }

    public function getStoreDataWithCampaign($storeId)
    {
        $sql = "
        SELECT 
            s.id,
            s.store_name,
            s.store_main_image,
            s.store_logo,
            s.store_opening_time,
            s.store_closing_time,
            s.store_owner_name,
            s.store_owner_phone,
            s.store_owner_mail,
            s.store_adress,
            s.store_location,
            s.store_statu,
            s.store_category,
            s.store_phone,
            s.store_credits,
            s.local_adress,
            s.created_at,
            s.updated_at,
            CONCAT('[',
                GROUP_CONCAT(
                    JSON_OBJECT(
                        'id', c.id,
                        'title', c.campaign_title,
                        'sub_description', c.campaign_sub_description,
                        'start_time', c.campaign_start_time,
                        'end_time', c.campaign_end_time,
                        'discount_off', c.campaign_disscount_off,
                        'image', c.campaign_image,
                        'min_purchase', c.campaign_min_purchase,
                        'type', c.campaign_type,
                        'status', c.campaign_status,
                        'created_at', c.created_at
                    )
                ),
            ']') as campaigns
        FROM 
            {$this->table} AS s
        LEFT JOIN 
            campaigns AS c ON c.store_id = s.id 
            AND c.campaign_status = 'active'
            AND c.campaign_end_time > NOW()
        WHERE 
            s.id = :store_id
        GROUP BY 
            s.id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':store_id', $storeId, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && isset($result['campaigns'])) {
            $result['campaigns'] = json_decode($result['campaigns'], true);
        }

        return $result;
    }


}
