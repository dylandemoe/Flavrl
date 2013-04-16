<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';

//File to handle the saving of search engines from ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //If it is ajax, have fun!
        include '../includes/config.php';
        
        $bg = htmlspecialchars($_REQUEST['bg']);
        $id = $_SESSION['user_id'];
        
        $q = "UPDATE visual_settings SET bg='$bg' WHERE usr='$id'";
        $connect->query($q);
    }
    else{
        echo 'get out!';
    }
?>