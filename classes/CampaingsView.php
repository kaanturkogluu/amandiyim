<?php
require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/IpHelper.php';
class CampaingsView extends BaseModel
{
    protected $table = 'campaign_views';

    public function getCampaignView($campaign_id)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE campaign_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$campaign_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getDifferentTotalViews($campaign_id)
    {
        $sql = "SELECT COUNT(DISTINCT ip_adress) as total FROM {$this->table} WHERE campaign_id = ?  ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$campaign_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 1;
    }

    public function getStoresCampaing(){
        $sql= "SELECT store_id, GROUP_CONCAT(id SEPARATOR ', ') AS campaigns
        FROM campaigns 
        GROUP BY store_id;";
    }
    public function updateCampaignView($campaign_id)
    {
        $ip = IpHelper::getUserIp();
     
      
        $sql = "INSERT INTO {$this->table} (campaign_id, ip_adress) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$campaign_id, $ip]);
   
    }
}