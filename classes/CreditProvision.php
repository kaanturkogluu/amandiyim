<?php
require_once __DIR__ . "/BaseModel.php";


class CreditProvision extends BaseModel
{


    protected $table = "credit_provision";


    public function findProvisionId($campaign_id)
    {
        $sql = "SELECT id FROM {$this->table} WHERE JSON_UNQUOTE(JSON_EXTRACT(`description`, '$.from_campaign_id')) = :cid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cid', $campaign_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


}
?>