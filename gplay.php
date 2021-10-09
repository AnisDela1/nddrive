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
    $google_link = "https://drive.google.com/file/d/$idgdp/view?usp=sharing";
    $gdrivep = "//gdriveplayer.to/embed2.php?link=$google_link&subtitle=$subtitle&poster=$idsub";
	
	
}
        header("Location: $gdrivep");