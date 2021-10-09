<?php
error_reporting(0);
session_start();
include "system/function.php";


if (isset($_SESSION['email'])) {
    
    if ($_GET['action'] == "logout") {
        session_unset();
        session_destroy();
        unset($_COOKIE['user']);
        setcookie('user', '', time() - 1000, '/');
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: https://" . config('site.domain') . "");
        exit;
        
    }
    
} else if (isset($_GET['code'])) {
    
    $token = token("code", $_GET['code']);
    
    if ($token['access_token']) {
        
        $geturl   = "https://www.googleapis.com/oauth2/v3/userinfo?alt=json&access_token=$token[access_token]";
        $user     = load($geturl);
        $userinfo = json_decode($user, true);
        
        if ($userinfo['email']) {
            
            if (file_exists("base/data/user/$userinfo[email].json")) {
                
                $update                  = json_decode(file_get_contents("base/data/user/$userinfo[email].json"), true);
                $update['refresh_token'] = $token['refresh_token'];
                
                if ($update['folder'] == null) {
                    $folder = create_folder($token[access_token]);
                    $folid  = $folder['id'];
                    anyonefolder($folid, $token[access_token]);
                    $update['folder'] = $folder['id'];
                    $update['root']   = $folder['parents']['0'];
                }
                file_put_contents("base/data/user/$userinfo[email].json", json_encode($update, true));
                
            } else {
                
                $folder = create_folder($token[access_token]);
                anyonefolder($folder['id'], $token[access_token]);
                $format = array(
                    role => "member",
                    email => $userinfo['email'],
                    name => $userinfo['name'],
                    picture => $userinfo['picture'],
                    access_token => $token['access_token'],
                    refresh_token => $token['refresh_token'],
                    root => $folder['parents']['0'],
                    folder => $folder['id']
                );
                file_put_contents("base/data/user/$userinfo[email].json", json_encode($format));
                
            }
            
            $_SESSION['email'] = $userinfo['email'];
            setcookie('user', $userinfo['email'] , strtotime('+2 days'), '/');
            
            if (isset($_SESSION['referer'])) {
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $_SESSION[referer]");
                exit;
                
            } else {
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: https://" . config('site.domain') . "/");
                exit;
                
            }
            
        } else
            echo "gagal";
        
    }
    
} else {
    
    if (isset($_GET['r'])) {
        
        $_SESSION[referer] = $_GET['r'];
        
    }
    
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://accounts.google.com/o/oauth2/auth?access_type=offline&prompt=consent&response_type=code&client_id=" . config('drive.client.id') . "&redirect_uri=" . config('drive.redirect.uris') . "&scope=https%3a%2f%2fwww.googleapis.com%2fauth%2fuserinfo.profile+email+https%3a%2f%2fwww.googleapis.com%2fauth%2fdrive");
    exit;
    
}
