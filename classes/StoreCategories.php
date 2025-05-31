<?php
require_once __DIR__ . "/BaseModel.php";


class StoreCategories extends BaseModel
{


    protected $table = "store_categories";



    public function getActiveCamapignFilter()
    {

        $sql = "SELECT DISTINCT st.id, st.category_name
FROM campaigns c
INNER JOIN campaing_categories ct ON c.id = ct.campaign_id
INNER JOIN store_categories st ON st.id = ct.campaign_store_category_id
WHERE c.campaign_status = 'active';
";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
?>