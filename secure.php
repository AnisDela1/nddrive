<?php
error_reporting(0);
function check_file_image($id)
{
    $key = "AIzaSyCno_lVzg3J3egyzd-XO_MBBUzh_Wej2sQ";
    $url = "https://www.googleapis.com/drive/v2/files/$id?&key=$key";
    $curl = curl_init();
    $opts = [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, ];
    curl_setopt_array($curl, $opts);
    $response = json_decode(curl_exec($curl) , true);
    return $response['thumbnailLink'];
}

function my_crypt( $string, $action = 'e' ) {
  $secret_key = 'kretexxxx';
  $secret_iv = 'zzzkretexxxx';
  $output = false;
  $encrypt_method = "AES-256-CBC";
  $key = hash( 'sha256', $secret_key );
  $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
  if( $action == 'e' ) {
    $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
  }else if( $action == 'd' ){
    $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
  }
  return $output;
}


if($_GET['id']){

if(is_numeric($_GET['id'])){
$file = json_decode(file_get_contents("base/data/main/share/$_GET[id].json") , true);
$file = $file['file']['file_id'];
} else {
$file = my_crypt($_GET['id'],"d");
}

$source = sprintf( 'https://www.googleapis.com/drive/v3/files/%s?alt=media&key=AIzaSyD739-eb6NzS_KbVJq1K8ZAxnrMfkIqPyw', $file );

header("HTTP/1.1 301 Moved Permanently");
header("Location: $source");
exit;

 } elseif($_GET['poster']) {

if(is_numeric($_GET['poster'])){
$file = json_decode(file_get_contents("base/data/main/share/$_GET[poster].json") , true);
$file = $file['file']['file_id'];
} else {
$file = my_crypt($_GET['poster'],"d");
}
$image = check_file_image($file);

header("HTTP/1.1 301 Moved Permanently");
header("Location: $image");
exit;

}
?>