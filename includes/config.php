<?php
    //config file for flavrl, php style!
    
    //host
    $sql_host = '';
    //Port
    $sql_port = '';
    //User
    $sql_user = '';
    //Password
    $sql_pass = '';
    //Database
    $sql_db = '';
    
    $connect = new mysqli($sql_host, $sql_user, $sql_pass, $sql_db);
    
    $self = "";
    
    $apps = "";
    
    //domain!
    $domain = '';
    
    //Current URL
    $currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>