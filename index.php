<?php
    session_start();
    if(isset($_COOKIE['user'])){
        $_SESSION['email'] = $_COOKIE['user'];
    }
    include "system/function.php";
    include "system/view/header.php";
    include "system/view/main.php";
    include "system/view/footer.php";
?>