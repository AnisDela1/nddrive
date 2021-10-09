<?php
error_reporting(0);
define("BASEPATH", dirname(__FILE__));

if($_GET['ajax'] == "get-file"){
include "./system/ajax/get-file.php";
}
else if($_GET['ajax'] == "delete"){
include "./system/ajax/delete-post.php";
}
else if($_GET['ajax'] == "info"){
include "./system/ajax/get-info.php";
}
else if($_GET['ajax'] == "edit"){
include "./system/ajax/edit-post.php";
}
else if($_GET['ajax'] == "mirrorace"){
include "./system/ajax/mirrorace.php";
}
else if($_GET['ajax'] == "multiup"){
include "./system/ajax/multiup.php";
}
else if($_GET['ajax'] == "profile"){
include "./system/ajax/profile-post.php";
}
else if($_GET['ajax'] == "setting"){
include "./system/ajax/setting-post.php";
}
else if($_GET['ajax'] == "mirror"){
include "./system/ajax/mirror-post.php";
}
else if($_GET['ajax'] == "ads"){
include "./system/ajax/ads-post.php";
}
else if($_GET['ajax'] == "delkun"){
include "./system/ajax/delkun-post.php";
}
else if($_GET['ajax'] == "role"){
include "./system/ajax/get-role.php";
}
else if($_GET['ajax'] == "role-post"){
include "./system/ajax/role-post.php";
}
else if($_GET['ajax'] == "get-table-admin"){
include "./system/ajax/get-admin.php";
}
else if($_GET['ajax'] == "get-table-broken"){
include "./system/ajax/get-table-broken.php";
}
else if($_GET['ajax'] == "copy-drive"){
include "./system/ajax/copydrive-post.php";
}
else if($_GET['ajax'] == "upload-link"){
include "./system/ajax/uplink-post.php";
}
else if($_GET['ajax'] == "get-table-user"){
include "./system/ajax/get-user.php";
}
else if($_GET['ajax'] == "get-stats"){
include "./system/ajax/get-stats.php";
}
else if($_GET['ajax'] == "get-user-stats"){
include "./system/ajax/get-user-stats.php";
}
else if($_GET['ajax'] == "download"){
include "./system/ajax/download-post.php";
}
else if($_GET['ajax'] == "subtitle"){
include "./system/ajax/subtitle-post.php";
}
else if($_GET['ajax'] == "upload-folder"){
include "./system/ajax/upfol-post.php";
}
else if($_GET['ajax'] == "vidcloud"){
include "./system/ajax/vids-post.php";
}
?>