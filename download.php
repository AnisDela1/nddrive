<?php
error_reporting(0);
session_start();

if(isset($_COOKIE['user'])){
        $_SESSION['email'] = $_COOKIE['user'];
    }

function check_info($id)
{
    $key = "AIzaSyCno_lVzg3J3egyzd-XO_MBBUzh_Wej2sQ";
    $url = "https://www.googleapis.com/drive/v2/files/$id?key=$key";
    $curl = curl_init();
    $opts = [CURLOPT_URL => $url, CURLOPT_RETURNTRANSFER => true, ];
    curl_setopt_array($curl, $opts);
    $info = json_decode(curl_exec($curl) , true);
    if(!isset($info['error'])){
$fileinfo = array(
'name' => $info['title'],
'size' => $info['fileSize'],
'mimeType' => $info['mimeType'],
'owner' => $info['ownerNames']['0']
); 
} else {
$fileinfo = false;
}
    return $fileinfo;
}

function my_crypt( $string, $action = 'e' ) {
  $secret_key = 'mysimplexxx';
  $secret_iv = 'mykabarxxx';
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

if(is_numeric($_GET['id'])){

$share = json_decode(file_get_contents("base/data/main/share/$_GET[id].json"), true);
$users = json_decode(file_get_contents("base/data/user/".$share[file][user_id].".json"),true);

}else{

$share = array();
$users = array();
$fill = "base/data/main/share/$_GET[id].json";

if(!file_exists($fill)){
	$file_id = my_crypt($_GET['id'],"d");
	$info = check_info($file_id);
	if($info == false){
		$share['file']['title'] = null;
		} else {
			$share['file']['title'] = $info['name'];
$share['file']['size'] = $info['size'];
$share['file']['mime'] = $info['mimeType'];
$share['file']['owner'] = $info['owner'];
$share['file']['status'] = "publish";
$share['file']['date'] = date("d-M-Y H:i:s");
$share['file']['file_id'] = $file_id;
$share['file']['share_id'] = $_GET['id'];
$users['name'] = $info['owner'];
file_put_contents($fill, json_encode($share, true));
			}
	
	} else {
		$share = json_decode(file_get_contents("base/data/main/share/$_GET[id].json"), true);
$users['name'] = $share['file']['owner'];
		}

}

		
		
$formatv = explode("/",$share['file']['mime']);
$formatv = $formatv['0'];
$_GET['s'] = $share['file']['title'];
include "system/function.php";
include "system/view/header.php";
?>

<?php if($share['file']['status'] == "delete"):?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-md-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary" align="center">The file has been deleted !</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fa fa-exclamation-triangle fa-xl"></i>
                            <br>
                            The file you are trying to access is no longer available
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif($share['file']['title'] == null):?>
    <div class="container-fluid">
            <div class="col-lg-9 col-md-9 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h4 class="m-0 font-weight-bold text-primary" align="center">File not found !</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <i class="fa fa-exclamation-triangle fa-xl"></i>
                            <br>
                            The file you are trying to access cannot be found on this server
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php else:?>
       
      <div class="container-fluid">
      <div id="down-id" hidden="true"><?php echo $_GET['id'] ?></div>
          <!-- Content Row -->
            <div class="row justify-content-center">
              <div class="col-lg-9 col-md-9 mb-4">
              <?php echo config('banner1')?>
              <div class="card shadow mb-4">
              	<div class="card-header py-3">
                  <h4 class="m-0 font-weight-bold text-primary" align="center"><?php echo $share['file']['title']?></h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless" id="dataTable" width="100%" cellspacing="0">
                          <tbody>
                              <tr style="border-bottom: 0.5px solid black; line-height: 1.8em;">
                                  <td>File Size</td>
                                  <td align="right"><?php echo formatBytes($share['file']['size'])?></td>
                              </tr>
                              <tr style="border-bottom: 0.5px solid black; line-height: 1.8em;">
                                  <td>File Type</td>
                                  <td align="right"><?php echo $share['file']['mime']?></td>
                              </tr>
                              <tr>
                                  <td>File Owner</td>
                                  <td align="right"><?php //echo $users['name']?>MyDriveku</td>
                              </tr>
                          </tbody>
                    </table>
                    </div>
                    <br>
                    <?php if($share['file']['status'] == "realbroken"):?>
                    <div class="alert-warning" align="center"><i class="fa fa-exclamation-triangle"></i>  This file is broken ! <br> please ask owner to re-upload this file</div>
                    <?php endif;?>
                    <br>
                    <div class="text" align="center">
                        <?php if(isset($_SESSION['email'])):?>
                        <button onclick="myDownload()" id="down" type="button" class="btn btn-primary btn-user"><i class="fa fa-download"></i>  Download</button>
                        <?php if(config("player") == "enable" && $formatv == "video"):?>
                        <a href="/stream/<?php echo $_GET['id']?>" class="btn btn-primary btn-user"><i class="fa fa-play-circle"></i>  Streaming</a>
                        <a href="/jdapi.php/?id=<?php echo $_GET['id']?>" class="btn btn-primary btn-user"><i class="fa fa-download"></i>  Download</a>
                        <?php else:?>
                        <a href="" class="btn btn-primary btn-user disabled"><i class="fa fa-play-circle"></i>  Streaming</a>
                        <a href="" class="btn btn-primary btn-user disabled"><i class="fa fa-download"></i>  Download</a>
                        <?php endif;?>
                        <?php else:?>
                        <form action="/login.php" method="GET">
                            <input name="r" value="https://<?php echo config('site.domain')?>/file/<?php echo $_GET['id']?>" type="hidden">
                            <text style="color:red;font-weight:1000;font-size:20px;text-transform:uppercase">Perlu Login Pake Akun Google Kalau Mau Download</text></br>
                            <button class="btn btn-primary btn-user" type="submit"><i class="fa fa-download"></i>  Download(Login)</button>
                            <?php if(config("player") == "enable" && $formatv == "video"):?>
                            <a href="/stream/<?php echo $_GET['id']?>" class="btn btn-primary btn-user"><i class="fa fa-play-circle"></i>  Streaming</a>
                            <a href="/jdapi.php/?id=<?php echo $_GET['id']?>" class="btn btn-primary btn-user"><i class="fa fa-download"></i>  Download(No Login)</a>
                            <?php else:?>
                            <a href="" class="btn btn-primary btn-user disabled"><i class="fa fa-play-circle"></i>  Streaming</a>
                            <a href="" class="btn btn-primary btn-user disabled"><i class="fa fa-download"></i>  Download(No Login)</a>
                            <?php endif;?>
                        </form>
                        <?php endif;?>
                        <br><br>
                        <?php if(isset($share['file']['mirror'])):?>
                        <button type="button" onClick="window.location.href='<?php echo $share['file']['mirror']?>'" class="btn btn-dark btn-sm"><i class="fa fa-link"></i> Download Via Multiup</button>
                        <?php endif;?>
                        <?php if(isset($share['file']['ace'])):?>
                        <button type="button" onClick="window.location.href='<?php echo $share['file']['ace']?>'" class="btn btn-dark btn-sm"><i class="fa fa-link"></i> Download Via MirrorAce</button>
                        <?php endif;?>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="text" align="left">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#link" role="tab" data-toggle="tab">Link</a>
                            </li>
                            <li class="nav-item">
                                 <a class="nav-link" href="#html" role="tab" data-toggle="tab">Html</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#embed" role="tab" data-toggle="tab">Embed</a>
                            </li>
                        </ul>
                    </div>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="link">
                        <div class="card">
                            <div class="card-body">
                                    <p onclick="copy(this)">https://<?php echo config('site.domain')?>/file/<?php echo $_GET[id] ?></p>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="html">
                        <div class="card">
                            <div class="card-body">
                                    <p onclick="copy(this)">&lt;a href=&quot;https://<?php echo config('site.domain')?>/file/<?php echo $_GET[id] ?>&quot;&gt; <?php echo $share[file][title]?> - <?php echo formatBytes($share[file][size])?>&lt;/a&gt;</p>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="embed">
                        <div class="card">
                            <div class="card-body">
                                    <p onclick="copy(this)">&lt;iframe src=&quot;https://<?php echo config('site.domain')?>/stream/<?php echo $_GET[id] ?>&quot; frameborder=&quot;0&quot; width=&quot;100%&quot; height=&quot;300&quot; allowfullscreen=&quot;allowfullscreen&quot;&gt&lt;/iframe&gt;</p>
                            </div>
                        </div>
                    </div>
                </div>
                        
                    </div>
                    <br>
                </div>
              </div>
            </div>
        </div>
        <!-- /.container-fluid -->
      </div>

<?php echo config('banner2')?>

<noscript>
alert("please enable JavaScript in your browser");
</noscript>
<?php endif;?>
<?php
include "system/view/footer.php";
?>