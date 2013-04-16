<?php
    include 'includes/sessionCode.php';
    include 'includes/errorCode.php';
    
    include "includes/config.php";  
   
    //if token is missing, make user relog
    if(isset($_SESSION['user']) && !isset($_COOKIE['ft'])){
        header('Location: logout.php');
    }

    if(isset($_COOKIE['user_auth']) && !isset($_SESSION['user'])){
        include "includes/class/login.php";
        //parse the url to see if the 'then' is there
        $parse = parse_url($currentUrl,PHP_URL_QUERY);
        parse_str($parse);
        $log = new login;
        $log->connect = $connect;

        if(isset($then)){
            $log->redirect = htmlspecialchars($then);
        }

        $log->login_handler('remember');
    }
    
    include "includes/class/display.php";
    $dis = new display;
    $dis->connect = $connect;
    if(!isset($_SESSION['user'])){
        $dis->section = 'signin';
        $body = $dis->display();
        $header = '';
        $styles = '';
    }
    else{  
        $dis->user = $_SESSION['user'];
        $dis->userID = $_SESSION['user_id'];
        
        $dis->section = 'log_header';
        $header = $dis->display();
        
        $dis->section = 'log_body';
        $body = $dis->display();
        
        $dis->section = 'user_styles';
        $styles = $dis->display();
    }
    $dis->section = 'scripts';
    $scripts = $dis->display();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Flavrl - Homepage</title>
        
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet"/>
        <link href="font/font-awesome.min.css" rel="stylesheet"/>
        <link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
        <link href="css/styles.css" rel="stylesheet"/>
        
        <?php
            echo $styles;
        ?>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        
        <?php
            echo $scripts
        ?>
        
    </head>
    <body>
        <div class="navbar layer3">
          <div class="navbar-inner">
            <a class="brand">Flavrl</a>
                <div class="nav-collapse">
                <?php
                    echo $header;
                ?>
                    
                </div>
          </div>
        </div>
        <div id="content">
            <div id="content-apps">
                <?php
                    echo $body;
                ?>
            </div>
        </div>
        <div id="modals"></div>
        <div class="app-column notloaded app-master">
            <div class="app-header">
                <span class="app-name"></span>
                <div class="app-header-right pull-right">
                    <a href="javascript:void(0)" data-href='' class="icon-refresh" title="Refresh"></a>
                    <a href="" class="icon-external-link" target="_blank" title="Go to website"></a>
                    <a href="javascript:void(0)" class="icon-resize-full btn-size" title="Expand/Shrink"></a>
                    <a href="javascript:void(0)" class="icon-circle-blank btn-blend" title="Blend/Show"></a>
                    <a href="javascript:void(0)" class="icon-remove" title="Remove"></a>
                </div>
            </div>
            <div class="app-body">
                <div class="app-loading">
                    <i class="icon-spinner icon-spin"></i>
                    Loading data..
                </div>
            </div>
        </div>
    </body>
</html>