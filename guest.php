<?php
include 'includes/sessionCode.php';
include 'includes/config.php';
$_SESSION['user'] = "Guest";
$_SESSION['user_id'] =  "2";
if(isset($_GET['then'])){
	$header = $_GET['then'];
}
else{
	$header = 'index.php';
}
die($header);
header("Location: ".$header);
?>