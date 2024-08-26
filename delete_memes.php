<?php
session_start();
include "auth/connect.php";

$userEmail = $_SESSION['userEmail'];

if (empty($userEmail)) {
    header('location: login.php');
    exit();
}

$conn = connect();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM memes WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header('location: memes.php');
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
} else {

    header('location: category.php');
    exit();
}
