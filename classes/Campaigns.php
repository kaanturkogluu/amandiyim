<?php
require_once __DIR__ . "/BaseModel.php";

class Campaigns extends BaseModel
{
    protected $table = "campaigns";
    protected $itemsPerPage = 20;



    public function setItemsPerPage($val){
        $this->itemsPerPage = $val;
    }

    public function getStoresAllCampaignIds(){
        $sql= "SELECT store_id, GROUP_CONCAT(id SEPARATOR ', ') AS campaignsIds
        FROM {$this->table} 
        GROUP BY store_id;";
        $stmt =$this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getAllCampaignsWithPage($page = 1, $limit=null) {
        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id  ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla

        $limit == null ? $limit = $this->itemsPerPage : '';
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages(),
            'data' => $data

        ];


    }

    public function getActiveCampaignsWithPage($page = 1)
    {
        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND isConfirmed = 1 ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

       
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE isConfirmed=1"),
            'data' => $data

        ];


    }
    public function getWaitingCampaignsWithPage($page = 1)
    {
        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND isConfirmed = 0 ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE isConfirmed=0"),
            'data' => $data

        ];


    } public function getExpiredCampaignsWithPage($page = 1)
    {
        $offset = ($page - 1) * $this->itemsPerPage;

        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND isConfirmed = 2 ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE isConfirmed=2"),
            'data' => $data

        ];


    }

}
?>