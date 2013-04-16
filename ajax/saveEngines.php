<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';

//File to handle the saving of search engines from ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //If it is ajax, have fun!
        include '../includes/config.php';
        
        $type = $_REQUEST['type'];
        
        if($type == 'save'){
            $action = $_REQUEST['action'];
            $id = htmlspecialchars($_REQUEST['id']);
            $s_id = $_SESSION['user_id'];
            
            if($action == 'add'){
                $q = "INSERT INTO uTe (usr, engine) VALUES ($s_id,$id)";
                $connect->query($q);
                echo 'Added into uTe table';
            }
            else if($action == 'remove'){
                $q = "DELETE FROM uTe WHERE usr=$s_id AND engine=$id";
                $connect->query($q);
                echo 'Removed from uTe table';
            }
            else if($action == 'default-add'){
                $q = "UPDATE uTe SET dft='true' WHERE usr=$s_id AND engine=$id";
                $connect->query($q);
                echo 'Make engine default';
            }
            else if($action == 'default-remove'){
                $q = "UPDATE uTe SET dft='false' WHERE usr=$s_id AND engine=$id";
                $connect->query($q);
                echo 'Removed default from engine';
            }
            else if($action == 'default-and-add'){
                $q = "INSERT INTO uTe (usr, engine, dft) VALUES ($s_id,$id, 'true')";
                $connect->query($q);
                echo 'Added engine and made it the default';
            }
            else{
                echo 'error';
            }
        }
        else if($type == 'update'){
            include '../includes/class/engines.php';
            $e = new searchEngines;
            $e->userID = $_SESSION['user_id'];
            $e->connect = $connect;
            $header = $e->getEngines('header');
            
            echo $header;
        }
        else{
            echo 'wrong type';
        }
    }
    else{
        echo 'get out!';
    }
?>