<?php
include '../includes/errorCode.php';
include '../includes/sessionCode.php';

//File to handle the saving of search engines from ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    //If it is ajax, have fun!
        include '../includes/config.php';

        date_default_timezone_set('America/Toronto');
        $time = date('Y-m-d H:i:s', time());
        $userID = $_SESSION['user_id'];

        //get the requested data
        $type = htmlspecialchars($_REQUEST['type'],ENT_QUOTES);
        $id = htmlspecialchars($_REQUEST['id'],ENT_QUOTES);
        //$width = htmlspecialchars($_REQUEST['width'],ENT_QUOTES);
        //$blend = htmlspecialchars($_REQUEST['blend'],ENT_QUOTES);
        //$order = htmlspecialchars($_REQUEST['order'],ENT_QUOTES);

        if($type == 'add'){
            //add the app
            $q = "INSERT INTO app_relation (usr,app,date) VALUES ($userID,$id,'$time')";
            $connect->query($q);
            echo $connect->insert_id;
        }
        else if($type == 'remove'){
            //remove the app
            $q = "UPDATE app_relation SET active='0' WHERE usr='$userID' AND id='$id'";
            $connect->query($q);
        }
        else if($type == 'order'){
            //reorder the apps
        }
        else if($type == 'resize'){
            //update width of the app
            $width = htmlspecialchars($_REQUEST['width'],ENT_QUOTES);
            $q = "UPDATE app_relation SET width='$width' WHERE usr='$userID' AND id='$id'";
            $connect->query($q);
        }
        else if($type == 'blend'){
            //update if app is blended or not
            $blend = htmlspecialchars($_REQUEST['blend'],ENT_QUOTES);
            $q = "UPDATE app_relation SET blend='$blend' WHERE usr='$userID' AND id='$id'";
            $connect->query($q);
        }
    }
    else{
        echo 'get out!';
    }
?>