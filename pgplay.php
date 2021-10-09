<?php 
error_reporting(0);
include "system/function.php";
if($_GET['id']) {

	$share = json_decode(file_get_contents("base/data/main/share/$_GET[id].json"), true);
	$idgdp = $share['file']['file_id'];
	$setting = json_decode(file_get_contents("base/data/setting/config.json"),true);
	$account = json_decode(file_get_contents("base/data/setting/mirror.json"),true);
    $idsub = $share['file']['poster'];
    $subtitle = "https://$site/subtitle/$idsub";
    
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://player.gdrives.net/embed2.php?host=gdrive&id=$idgdp&lang=Default&sub=$idsub&poster=$idsub&onlylink=yes",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic YWRtaW46RjFyM2I0TGw="
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
    	
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $response");

	
}