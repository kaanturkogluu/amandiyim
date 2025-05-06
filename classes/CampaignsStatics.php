<?php

require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/CampaingsView.php';
class CampaignsStatics extends BaseModel
{

    protected $table = 'campaign_statics';




    public function calculateStatics($campaign_id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE campaign_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$campaign_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Görüntüleme Sayısını Hepsini Al 
    public function getViewStatics($store_id)
    {

        // Storeid ile kampanyaları al
        $sql = "SELECT id FROM campaigns WHERE store_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$store_id]);
        $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $campaingsViewObject = new CampaingsView();

        $viewsArray = array_map(function ($campaign) use ($campaingsViewObject) {
            return $campaingsViewObject->getCampaignView($campaign['id']);
        }, $campaigns);


        //Toplam Görüntüleme Sayısını Al 
        $totalViews = array_reduce($viewsArray, function ($carry, $item) {
            return $carry + $item;
        }, 0);

        return $totalViews;

    }

    public function getDifdrentIpStatics($store_id)
    {
        // Storeid ile kampanyaları al
        $sql = "SELECT id FROM campaigns WHERE store_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$store_id]);
        $campaigns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $campaingsViewObject = new CampaingsView();

        $viewsArray = array_map(function ($campaign) use ($campaingsViewObject) {
            return $campaingsViewObject->getDifferentTotalViews($campaign['id']);
        }, $campaigns);


        //Toplam Görüntüleme Sayısını Al 
        $totalViews = array_reduce($viewsArray, function ($carry, $item) {
            return $carry + $item;
        }, 0);

        return $totalViews;

    }



}

$statick = new CampaignsStatics();
 
$totalIp = $statick->getDifdrentIpStatics($_SESSION['user']['id']);
 
echo $totalIp;
?>