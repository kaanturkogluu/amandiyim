<?php
require_once __DIR__ . "/BaseModel.php";

class Categories extends BaseModel
{

    protected $table = 'campaing_categories';


    public function getCampaingAllCategories($capmaign_id)
    {
        $sql = " SELECT 
    c.id AS category_id,
    c.campaign_id,
    sc.sub_category_name,
    ssc.sub_sub_name
        FROM campaing_categories c
        INNER JOIN campaign_sub_categories sc 
            ON c.campaign_sub_category_id = sc.id
        LEFT JOIN campaign_sub_sub_categories ssc 
            ON c.campaign_sub_sub_category_id = ssc.id
        WHERE c.campaign_id =:cid";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':cid', $capmaign_id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>