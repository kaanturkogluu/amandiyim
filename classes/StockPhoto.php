<?php

require_once __DIR__ . '/../classes/BaseModel.php';
class StockPhoto extends BaseModel
{
    protected $table = 'stock_photos';



    public function getStockPhotos($subcategoryid, $subsubcategoryid = 0)
    {
        $sql = "SELECT * FROM {$this->table} WHERE stock_photo_store_category = :storeCategory AND stock_photo_sub_category = :spsc";
    
        // Alt alt kategori varsa koşula ekle
        if ($subsubcategoryid != 0) {
            $sql .= " AND stock_photo_sub_sub_category = :subsub";
        }
    
        $stmt = $this->db->prepare($sql);
    
        // Parametreleri bağla
        $stmt->bindParam(':storeCategory', $this->storeCategory, PDO::PARAM_INT);
        $stmt->bindParam(':spsc', $subcategoryid, PDO::PARAM_INT);
    
        if ($subsubcategoryid != 0) {
            $stmt->bindParam(':subsub', $subsubcategoryid, PDO::PARAM_INT);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}