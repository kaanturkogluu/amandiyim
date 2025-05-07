<?php

require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/CampaingsView.php';
require_once __DIR__ . '/Session.php';
class CampaignsStatics extends BaseModel
{

    protected $store_id;
    protected $table = 'campaigns_statics';


    public function __construct()
    {
        parent::__construct();
        $session = Session::getInstance();
        $this->store_id = $session->getUserId();
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
                $values[] = $d['total_views'];
                $values[] = $d['total_diffrent_views'];
            }

            $sql = "INSERT INTO {$this->table} (store_id, campaign_id, total_views, total_diffrent_views) VALUES " . implode(',', $placeholders);

            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute($values);

            return $result;
        }
    }


    public function getAllStatistics()
    {

  
        $sql = "SELECT SUM(total_views) as total_view, SUM(total_diffrent_views) as total_difrent_views FROM {$this->table} WHERE store_id = :store_id";
            $stmt = $this->db->prepare($sql);
        $stmt->execute(['store_id' => $this->store_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




}


?>