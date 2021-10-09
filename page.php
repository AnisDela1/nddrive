<?php

session_start();
include "system/function.php";
include "system/view/header.php";

if($_GET['s'] == "privacy-policy"){
include "system/view/privacy-policy.php";
}
else if($_GET['s'] == "terms-conditions") {
include "system/view/terms-conditions.php";
}
else if($_GET['s'] == "copyright-policy") {
include "system/view/copyright.php";
}

include "system/view/footer.php";
?>