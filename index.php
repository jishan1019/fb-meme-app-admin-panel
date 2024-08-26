<?php 

session_start();

$userEmail = $_SESSION['userEmail'];

if (empty($userEmail)) {
    header('location: login.php');
    exit();
}else{
    header('location: settings.php');
}


?>