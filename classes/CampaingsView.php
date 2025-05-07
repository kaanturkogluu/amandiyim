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

    public function getStoresCampaing()
    {
        $sql = "SELECT store_id, GROUP_CONCAT(id SEPARATOR ', ') AS campaigns
        FROM campaigns 
        GROUP BY store_id;";
    }



    public function calculateAllStoreViews($startDate = null, $endDate = null)
    {
        // Tarihleri ayarla: Eğer parametre verilmezse, varsayılan olarak dünden bugüne al
        if (!$startDate || !$endDate) {
            $endDate = date('Y-m-d 23:59:59');
            $startDate = date('Y-m-d 00:00:00', strtotime('-1 day'));
        }
    
        $sql = "
            SELECT 
                store_id,
                campaign_id,
                COUNT(*) AS total_views,
                COUNT(DISTINCT ip_adress) AS total_diffrent_views
            FROM 
                {$this->table}
            WHERE 
                created_at BETWEEN :start_date AND :end_date
            GROUP BY 
                store_id, campaign_id
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createCollective($data)
    {
        // Verileri 50'lik gruplara böl
        $chunks = array_chunk($data, 50);



        foreach ($chunks as $chunk) {
            $placeholders = [];
            $values = [];

            foreach ($chunk as $d) {
                $placeholders[] = "(?, ?, ?, ?)";
                $values[] = $d['store_id'];
                $values[] = $d['campaign_id'];
                $values[] = $d['ip_address'];
                $values[] = $d['created_at'];
               
            }

            $sql = "INSERT INTO {$this->table} (store_id, campaign_id, ip_adress,created_at  ) VALUES " . implode(',', $placeholders);

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($values);

            return $result;
        }
    }
    public function updateCampaignView($campaign_id,$store_id)
    {
        $ip = IpHelper::getUserIp() ?? 0;


        $sql = "INSERT INTO {$this->table} (campaign_id, ip_adress,store_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$campaign_id, $ip,$store_id]);

    }
}
//total view toplam kayıt sayısı olarak gelicek
//total difrent view farklı id e ait olan toplam kayıt sayısı olarak gelicek