<?php

require_once __DIR__ . '/BaseModel.php';

require_once __DIR__ . '/Session.php';
class CampaignsSubSubCategories extends BaseModel
{

    protected $storeCategories;
    protected $store_id;
    protected $table = 'campaign_sub_sub_categories';


    public function __construct()
    {
        parent::__construct();
        $session = Session::getInstance();
        $this->store_id = $session->getUserId();
    }


 



}


?>