<?php
include '../includes/sessionCode.php';

//File to handle the login form from ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //If it is ajax, have fun!
        
        include '../includes/config.php';
        include '../includes/class/login.php';
    
        $user = trim(htmlspecialchars($_REQUEST['user']));
        $pass = trim(htmlspecialchars($_REQUEST['pass']));
        $pass_hash = md5($pass);
        $check = htmlspecialchars($_REQUEST['check']);
        
        $log = new login;
        $log->user = $user;
        $log->pass = $pass_hash;
        $log->check = $check;
        $log->connect = $connect;
        
        echo $log->login_handler('login');
    
    }
    else{
        die('Get the fuck out');
        //if not, gtfo
    }
?>