<?php

session_start();
if(isset($_COOKIE['user'])){
        $_SESSION['email'] = $_COOKIE['user'];
    }
include "system/function.php";
include "system/view/header.php";

?>

<?php if(isset($_SESSION['email'])):?>
<?php
if($_GET['s'] == "upload-link"){
include "system/view/upload-link.php";
}
else if($_GET['s'] == "copy-drive") {
include "system/view/copy-drive.php";
}
else if($_GET['s'] == "upload-subtitle") {
include "system/view/upload-subtitle.php";
}
else if($_GET['s'] == "upload-file") {
include "system/view/upload-file.php";
}
else if($_GET['s'] == "shared-file") {
include "system/view/shared-file.php";
}
else if($_GET['s'] == "profile") {
include "system/view/profile.php";
}
else if($_GET['s'] == "broken") {
include "system/view/broken.php";
}
else if($_GET['s'] == "setting") {
include "system/view/setting.php";
}
else if($_GET['s'] == "file-manager") {
include "system/view/file-manager.php";
}
else if($_GET['s'] == "user-manager") {
include "system/view/user-manager.php";
}
else if($_GET['s'] == "upload-folder") {
include "system/view/upload-folder.php";
}
?>

<?php else:?>

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4">
            <div class="card-body">
                <div class="text-center">
                <div class="alert-warning"><i class="fa fa-exclamation-triangle"></i>Access Denied ! Please Login</div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<?php
include "system/view/footer.php";
?>