<?php 

class GoogleLoginApi{
    public function getAccesToken($client_id,$redirect_uri,$client_secret,$code){
        $url = 'https://oauth2.googleapis.com/token';
       
        $curlPost = 'client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&client_secret='.$client_secret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$curlPost);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        $response = curl_exec($ch);
    }

}
?>