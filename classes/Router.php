<?php 


require_once __DIR__."/Helper.php";

class Router{


    private static $base_url = null; 

    public function __construct(){

        if(self::$base_url == null){
            self::$base_url = Helper::config('APP_URL');
        }

    }

    public static function base_url(){

        return  Router::base_url; 
    }

    public static function controllers(){

        return self::base_url . "/controllers/";
    }

    public static function view($page = "index"){

        return  self::base_url .$page. ".php";
    }
    
    public static function customerView($page="index"){
        
        return  self::base_url ."panel/customer/pages".$page. ".php";
    }

    public static function storeView($page="index"){

        return self::base_url. "panel/store/pages/". $page . ".php";
    }

}
?>