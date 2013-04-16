<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    
    include '../includes/class/engines.php';
    include '../includes/config.php';
    
    $e = new searchEngines;
    $e->userID = $_SESSION['user_id'];
    $e->connect = $connect;
    echo $e->getEngines('settings');
            
}

?>