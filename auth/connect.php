<?php
function connect()
{
    $dbHost = "localhost";
    $user = "root";
    $pass = "";
    $dbName = "bangla_fb_meme_app";

    $conn = new mysqli($dbHost, $user, $pass, $dbName);
    return $conn;
}

function getImgUrl()
{
    $url = "http://localhost/Project/Sports-Era-Admin-Panel";
    return $url;
}


function closeConnection($cn)
{
    $cn->close();
}