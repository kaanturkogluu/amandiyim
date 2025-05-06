<?php

require_once __DIR__ . '/../classes/BaseModel.php';
class StockPhoto extends BaseModel
{
    protected $table = 'stock_photos';



    public function getStockPhotos($storeCategoryId)
    {
        $sql = "SELECT * FROM $this->table WHERE stock_photo_category = :cid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cid', $storeCategoryId, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

}