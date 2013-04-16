<?php
include 'includes/sessionCode.php';
include 'includes/config.php';
unset($_SESSION["user"]);
setcookie("user_auth",'', time()-1, '/');
header("Location: index.php");
?>