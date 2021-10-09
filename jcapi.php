<?php 
error_reporting(0);
include "system/function.php";

if($_GET['id']) {

	$share = json_decode(file_get_contents("base/data/main/share/$_GET[id].json"), true);
	$idgdp = $share['file']['file_id'];
	$setting = json_decode(file_get_contents("base/data/setting/config.json"),true);
	$account = json_decode(file_get_contents("base/data/setting/mirror.json"),true);
    $idsub = $share['file']['poster'];
    $subtitle = "https://player.nddrive.pw/subtitle/$idsub";
    $google_link = "https://drive.google.com/file/d/$idgdp/view?usp=sharing";
    $gdrivep = file_get_contents("https://player.nddrive.pw/api/ff0a0bf0c5c4a3872b1e7d221d15a954?url=$google_link"); //ubah domain sesuai domain juicyplayer anda
	
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: https://$gdrivep/?subs=https://player.nddrive.pw/subtitle/$idsub"); //ubah domain sesuai domain juicyplayer anda
}
