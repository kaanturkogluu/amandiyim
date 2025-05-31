<?php
require_once __DIR__ . "/BaseModel.php";


class FeaturedCampaigns extends BaseModel
{


    protected $table = "featured_campaigns";

    public function getFeaturedCampaingForList()
    {

        $sql = "SELECT f.id,f.orderNumber,f.featured_started_date,f.featured_ended_date,s.store_name , c.campaign_title  FROM {$this->table} f 
        INNER JOIN campaigns c ON c.id=f.campaign_id 
        INNER JOIN stores s ON c.store_id=s.id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedCampaing()
    {
        $sql = "SELECT c.store_id as 'storeid',c.id,c.campaign_title,c.campaign_sub_description,f.featured_started_date,f.featured_ended_date,c.campaign_image,c.campaign_type,c.campaign_disscount_off
from featured_campaigns f 
INNER JOIN campaigns c ON c.id=f.campaign_id   WHERE date(f.featured_ended_date) <= NOW() ORDER BY f.orderNumber  ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}