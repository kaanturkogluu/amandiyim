<?php
require_once __DIR__ . "/BaseModel.php";

class Campaigns extends BaseModel
{
    protected $table = "campaigns";
    protected $itemsPerPage = 20;



    public function setItemsPerPage($val)
    {
        $this->itemsPerPage = $val;
    }

    public function getStoresAllCampaignIds()
    {
        $sql = "SELECT store_id, GROUP_CONCAT(id SEPARATOR ', ') AS campaignsIds
        FROM {$this->table} 
        GROUP BY store_id;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getAllCampaignsWithPage($page = 1, $limit = null)
    {
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
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND campaign_status = :active ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':active', "actvie", PDO::PARAM_STR);


        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla


        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE campaign_status='active'"),
            'data' => $data

        ];


    }
    public function getWaitingCampaignsWithPage($page = 1, )
    {
        $offset = ($page - 1) * $this->itemsPerPage;



        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND campaign_status = :cs ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);


        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':cs', "waiting", PDO::PARAM_INT);


        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE campaign_status='waiting'"),
            'data' => $data

        ];


    }
    public function getExpiredCampaignsWithPage($page = 1, $isAdmin = false)
    {
        $offset = ($page - 1) * $this->itemsPerPage;

        if ($isAdmin) {

        }
        // Sayfa numarasına göre verileri çek
        $sql = "SELECT * FROM " . $this->table . " WHERE store_id = :store_id AND campaign_status =:cs ORDER BY id DESC LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':store_id', $this->store_id, PDO::PARAM_INT);
        $stmt->bindValue(':cs', "expired", PDO::PARAM_STR);

        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'total_pages' => $this->getTotalPages("WHERE campaign_status='expired'"),
            'data' => $data

        ];


    }
    public function getCampaignWithPageForAdmin($page = 1, $statu)
    {
        $offset = ($page - 1) * $this->itemsPerPage;



        // Sayfa numarasına göre verileri çek
        if ($statu == 'all') {

            $sql = "SELECT * FROM " . $this->table . "  ORDER BY id DESC LIMIT :offset, :limit";

        } else {

            $sql = "SELECT * FROM " . $this->table . " WHERE  campaign_status = :cs ORDER BY id DESC LIMIT :offset, :limit";
        }
        $stmt = $this->db->prepare($sql);


        if ($statu != 'all') {

            $stmt->bindParam(':cs', $statu, PDO::PARAM_STR);
        }


        // Parametreleri bağla
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT); // Doğrudan sayısal değeri bağla
        $stmt->bindValue(':limit', $this->itemsPerPage, PDO::PARAM_INT); // Limit değerini bağla

        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $where = "WHERE campaign_status = '" . $statu . "'";
        return [
            'total_pages' => $this->getTotalPages($where),
            'data' => $data

        ];


    }
}
?>