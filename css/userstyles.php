<?php
header('Content-Type: text/css');

if(isset($_GET['t'])){
    $theme = $_GET['t'];
    
    include '../includes/colours.php';
    
    if(array_key_exists($theme,$colours)){
        $styles = styles($theme,$colours);
        
        ?>
            .btn-primary,
            .navbar-inner,
            .dropdown-menu li > a:hover,
            .dropdown-menu li > a:focus,
            .dropdown-submenu:hover > a{
                <?php echo $styles ?>
            }
        <?php
    }
    else{
        echo 'invalid';
    }
}
else{
    echo 'error';
}
?>